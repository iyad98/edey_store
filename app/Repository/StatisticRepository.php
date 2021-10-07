<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 7:12 م
 */

namespace App\Repository;


use App\Models\Order;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repository\CartRepository;

use App\Models\OrderPharmacy;
use App\Models\OrderProduct;
use App\Models\Pharmacy;
use App\Models\Admin;
use App\Models\AdminFcm;
use App\Models\Coupon;
use App\Models\NotificationAppUser;
use App\Models\Product;
use App\Models\OrderUserShipping;

use App\User;

use Carbon\Carbon;
use DB;
// Repository
use App\Repository\NotificationAdminRepository;

// jobs
use  App\Jobs\SendNotificationJob;
use  App\Jobs\SendToNextPharmacy;

use Illuminate\Foundation\Bus\DispatchesJobs;

// service
use App\Services\Firestore;

class StatisticRepository
{
    use DispatchesJobs;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;

    }


    public function __call($name, $arguments)
    {
        return $this->order->$name(...$arguments);
    }

    public function general_latest_data() {
        $users = User::latest()->UserRegistered()->limit(10)->get();
        $orders = Order::latest()->limit(10)->get();

        $most_purchase_product = OrderProduct::has('exist_product')->with('product')
            ->whereHas('order', function ($query) {
                $query->whereIn('status', [orignal_order_status()['finished'] , orignal_order_status()['processing'] ,orignal_order_status()['new']] );
            })->select('product_id', DB::raw('count(order_id) as order_count'))
            ->orderBy(DB::raw('count(order_id)'), 'desc')
            ->orderBy('product_id', 'desc')
            ->limit(10)
            ->groupBy('product_id')->get();
        return [
            'users' => $users ,
            'orders' => $orders ,
            'most_purchase_product' => $most_purchase_product,
        ];
    }
    public function general_data($start_at, $end_at)
    {
        $users_count = User::DateUser($start_at, $end_at)->UserRegistered()->count();
        $all_users_count = User::UserRegistered()->count();

        $products_count = Product::DateProduct($start_at, $end_at)->count();
        $all_products_count = Product::count();


        $orders_count = Order::DateOrder($start_at, $end_at)->count();
        $all_orders_count = Order::count();

        $orders_new_count = Order::NewOrder()->DateOrder($start_at, $end_at)->count();
        $orders_processing_count = Order::ProcessingOrder()->DateOrder($start_at, $end_at)->count();
        $orders_failed_count = Order::FailedOrder()->DateOrder($start_at, $end_at)->count();
        $orders_canceled_count = Order::CanceledOrder()->DateOrder($start_at, $end_at)->count();


        $orders_finished_count = Order::FinishedOrder()->DateOrder($start_at, $end_at)->count();
        $all_orders_finished_count = Order::DateOrder($start_at, $end_at)->count();

        $payment_waiting = Order::DateRawOrder($start_at, $end_at)->select(DB::raw('count(*)'))->whereRaw('status = 0');
        $processing = Order::DateRawOrder($start_at, $end_at)->select(DB::raw('count(*)'))->whereRaw('status = 1');
        $shipment = Order::DateRawOrder($start_at, $end_at)->select(DB::raw('count(*)'))->whereRaw('status = 2');
        $pending = Order::DateRawOrder($start_at, $end_at)->select(DB::raw('count(*)'))->whereRaw('status = 3');
        $finished = Order::DateRawOrder($start_at, $end_at)->select(DB::raw('count(*)'))->whereRaw('status = 4');
        $canceled = Order::DateRawOrder($start_at, $end_at)->select(DB::raw('count(*)'))->whereRaw('status = 5');
        $returned = Order::DateRawOrder($start_at, $end_at)->select(DB::raw('count(*)'))->whereRaw('status = 6');
        $failed = Order::DateRawOrder($start_at, $end_at)->select(DB::raw('count(*)'))->whereRaw('status = 7');



        $prodact_in_manufacturing = ProductVariation::select(DB::raw('count(*)'))->whereRaw('order_status = 0');
        $prodact_charged_up = ProductVariation::select(DB::raw('count(*)'))->whereRaw('order_status = 1');
        $prodact_charged_at_sea = ProductVariation::select(DB::raw('count(*)'))->whereRaw('order_status = 2');
        $prodact_at_the_harbour = ProductVariation::select(DB::raw('count(*)'))->whereRaw('order_status = 3');
        $prodact_in_the_warehouse = ProductVariation::select(DB::raw('count(*)'))->whereRaw('order_status = 4');
        $prodact_delivered = ProductVariation::select(DB::raw('count(*)'))->whereRaw('order_status = 5');




        $order_status = $this->order->select(
            getSubQuerySql($payment_waiting, 'payment_waiting_count'),
            getSubQuerySql($processing, 'processing_count'), getSubQuerySql($shipment, 'shipment_count'),
            getSubQuerySql($pending, 'pending_count'), getSubQuerySql($finished, 'finished_count'),
            getSubQuerySql($canceled, 'canceled_count'), getSubQuerySql($returned, 'returned_count'),
            getSubQuerySql($failed, 'failed_count'))
            ->limit(1)->first();

        $product_status =  $this->order->select(
            getSubQuerySql($prodact_in_manufacturing, 'prodact_in_manufacturing'),
            getSubQuerySql($prodact_charged_up, 'prodact_charged_up'),
            getSubQuerySql($prodact_charged_at_sea, 'prodact_charged_at_sea'),
            getSubQuerySql($prodact_at_the_harbour, 'prodact_at_the_harbour'),
            getSubQuerySql($prodact_in_the_warehouse, 'prodact_in_the_warehouse'),
            getSubQuerySql($prodact_delivered, 'prodact_delivered')
          )
            ->limit(1)->first();
        return [
            'users_count' => $users_count,
            'all_users_count' => $all_users_count,
            'user_count_percentage' => $all_users_count == 0 ? 0 : round(($users_count / $all_users_count) * 100) . "%",


            'products_count' => $products_count,
            'all_products_count' => $all_products_count,
            'products_count_percentage' =>$all_products_count == 0 ?0: round(($products_count / $all_products_count) * 100) . "%",


            'orders_count' => $orders_count,
            'all_orders_count' => $all_orders_count,
            'orders_count_percentage' =>$all_orders_count == 0 ? 0 : round(($orders_count / $all_orders_count) * 100) . "%",


            'orders_finished_count' => $orders_finished_count,
            'orders_new_count'=>$orders_new_count,

            'orders_processing_count'=>$orders_processing_count,
            'orders_failed_count'=>$orders_failed_count,
            'orders_canceled_count'=>$orders_canceled_count,

            'all_orders_finished_count' => $all_orders_finished_count,
            'orders_finished_count_percentage' =>$all_orders_finished_count == 0 ? 0 : round(($orders_finished_count / $all_orders_finished_count) * 100) . "%",
            'orders_new_count_percentage' =>$orders_new_count == 0 ? 0 : round(($orders_new_count / $all_orders_finished_count) * 100) . "%",

            'orders_processing_count_percentage' =>$orders_processing_count == 0 ? 0 : round(($orders_processing_count / $all_orders_finished_count) * 100) . "%",
            'orders_failed_count_percentage' =>$orders_failed_count == 0 ? 0 : round(($orders_failed_count / $all_orders_finished_count) * 100) . "%",
            'orders_canceled_count_percentage' =>$orders_canceled_count == 0 ? 0 : round(($orders_canceled_count / $all_orders_finished_count) * 100) . "%",

            'order_status' => $order_status,
            'product_status' => $product_status

        ];
    }
    public function get_financial_orders($start_at, $end_at)
    {

        $diff_in_days = Carbon::parse($end_at)->diffInDays(Carbon::parse($start_at));

        $financial_orders = $this->order->FinancialStatisticOrder()->DateOrder($start_at, $end_at);

        if ($diff_in_days <= 31) {
            $day = true;
            $financial_orders = $financial_orders->select(DB::raw('year(created_at) as year'), DB::raw('month(created_at) as month'), DB::raw('day(created_at) as day'),
                DB::raw('sum(total_price) as total_price'), DB::raw('sum(shipping) as shipping'), DB::raw('(sum(coupon_price) + sum(coupon_automatic_price)) as coupon_price'),
                DB::raw('sum(tax) as tax'))
                ->groupBy(DB::raw('year(created_at)'), DB::raw('month(created_at)'), DB::raw('day(created_at)'));
        } else {
            $day = false;
            $financial_orders = $financial_orders->select(DB::raw('year(created_at) as year'), DB::raw('month(created_at) as month'),
                DB::raw('sum(total_price) as total_price'), DB::raw('sum(shipping) as shipping'), DB::raw('(sum(coupon_price) + sum(coupon_automatic_price)) as coupon_price'),
                DB::raw('sum(tax) as tax'))
                ->groupBy(DB::raw('year(created_at)'), DB::raw('month(created_at)'));
        }

        $financial_orders = $financial_orders->get();
        return [
            'all_total_price' => $financial_orders->sum('total_price'),
            'all_shipping' => $financial_orders->sum('shipping'),
            'all_coupon_price' => $financial_orders->sum('coupon_price'),
            'all_tax' => $financial_orders->sum('tax'),
            'xAxes' => $day ? 'اليوم' : 'الشهر',
            'yAxes' => 'القيمة',
            'chart_area' => $this->set_data_sets_chart_area($financial_orders, $day)
        ];
    }
    public function get_users_statistic($start_at, $end_at)
    {
        $diff_in_days = Carbon::parse($end_at)->diffInDays(Carbon::parse($start_at));

        $android_users = User::select(DB::raw('count(*)'))->DateRawUser($start_at, $end_at)->whereRaw('is_guest = 0')->whereRaw('platform = "android"');
        $ios_users = User::select(DB::raw('count(*)'))->DateRawUser($start_at, $end_at)->whereRaw('is_guest = 0')->whereRaw('platform = "ios"');
        $web_users = User::select(DB::raw('count(*)'))->DateRawUser($start_at, $end_at)->whereRaw('is_guest = 0')->whereRaw('platform = "web"');

        $users_type = User::select(getSubQuerySql($android_users, 'android_users'),
            getSubQuerySql($ios_users, 'ios_users'), getSubQuerySql($web_users, 'web_users'))
            ->limit(1)
            ->first();

        $users_statistic = User::UserRegistered()->DateUser($start_at, $end_at);
        if ($diff_in_days <= 31) {
            $day = true;
            $users_statistic = $users_statistic->select(DB::raw('count(*) as count_users'),
                DB::raw('year(created_at) as year'), DB::raw('month(created_at) as month'), DB::raw('day(created_at) as day'))
                ->groupBy(DB::raw('year(created_at)'), DB::raw('month(created_at)'), DB::raw('day(created_at)'));
        } else {
            $day = false;
            $users_statistic = $users_statistic->select(DB::raw('count(*) as count_users'),
                DB::raw('year(created_at) as year'), DB::raw('month(created_at) as month'))
                ->groupBy(DB::raw('year(created_at)'), DB::raw('month(created_at)'));
        }
        $users_statistics = $users_statistic->get();

        return [
            'all_count_users' => $users_statistics->sum('count_users'),
            'xAxes' => $day ? 'اليوم' : 'الشهر',
            'yAxes' => 'عدد العملاء',
            'chart_area' => $this->set_data_sets_users_statistic($users_statistics, $day),


            'count_users_type' => $this->set_data_sets_users_type($users_type),

        ];
    }
    public function get_orders_data($start_at, $end_at)
    {

        $orders_data = $this->order->DateOrder($start_at, $end_at);

        $all_orders = Order::select(DB::raw('count(*)'))->DateRawOrder($start_at, $end_at);

        $register_orders = Order::select(DB::raw('count(*)'))->DateRawOrder($start_at, $end_at)->whereRaw('is_guest = 0');
        $guest_orders = Order::select(DB::raw('count(*)'))->DateRawOrder($start_at, $end_at)->whereRaw('is_guest = 1');

        $orders_data = $orders_data->select(getSubQuerySql($all_orders, 'all_orders'), getSubQuerySql($register_orders, 'register_orders'),
            getSubQuerySql($guest_orders, 'guest_orders'))
            ->limit(1)
            ->first();

        return [
            'count_orders_type' => $this->set_data_sets_orders_data_type($orders_data),
        ];
    }
    public function get_orders_payment_types_data($start_at, $end_at)
    {

        $orders_data = $this->order->DateOrder($start_at, $end_at);

        $all_orders = Order::select(DB::raw('count(*)'))->DateRawOrder($start_at, $end_at);

        $knet_orders = Order::select(DB::raw('count(*)'))->DateRawOrder($start_at, $end_at)->whereRaw('payment_method_id = 1');
        $visa_orders = Order::select(DB::raw('count(*)'))->DateRawOrder($start_at, $end_at)->whereRaw('payment_method_id = 2');

        $orders_data = $orders_data->select(getSubQuerySql($all_orders, 'all_orders'), getSubQuerySql($knet_orders, 'knet_orders'),
            getSubQuerySql($visa_orders, 'visa_orders') )
            ->limit(1)
            ->first();

        return [
            'count_all_orders_type' => $this->set_data_sets_all_orders_data_type($orders_data),
        ];
    }
    public function get_orders_shipping_types_data($start_at, $end_at)
    {

        $orders_data = $this->order->DateOrder($start_at, $end_at);

        $all_orders = Order::select(DB::raw('count(*)'))->DateRawOrder($start_at, $end_at);

        $warehouse_orders = Order::select(DB::raw('count(orders.id)'))->DateRawOrder($start_at, $end_at)
            ->leftJoin('order_company_shipping' , 'order_company_shipping.order_id' , '=' , 'orders.id')
            ->whereRaw('order_company_shipping.shipping_company_id = 1');

        $home_delivery_orders = Order::select(DB::raw('count(orders.id)'))->DateRawOrder($start_at, $end_at)
            ->leftJoin('order_company_shipping' , 'order_company_shipping.order_id' , '=' , 'orders.id')
            ->whereRaw('order_company_shipping.shipping_company_id = 3');




        $orders_data = $orders_data->select(getSubQuerySql($all_orders, 'all_orders'), getSubQuerySql($warehouse_orders, 'warehouse_orders'),
            getSubQuerySql($home_delivery_orders, 'home_delivery_orders'))
            ->limit(1)
            ->first();

        return [
            'count_all_orders_type' => $this->set_data_sets_all_orders_shipping_data_type($orders_data),
        ];
    }

    public function get_orders_count_data($start_at, $end_at)
    {

        $diff_in_days = Carbon::parse($end_at)->diffInDays(Carbon::parse($start_at));

        $orders_count = $this->order->DateOrder($start_at, $end_at);
        if ($diff_in_days <= 31) {
            $day = true;
            $orders_count = $orders_count->select(DB::raw('count(orders.id) as count_orders'),
                DB::raw('year(created_at) as year'), DB::raw('month(created_at) as month'), DB::raw('day(created_at) as day'))
                ->groupBy(DB::raw('year(created_at)'), DB::raw('month(created_at)'), DB::raw('day(created_at)'));
        } else {
            $day = false;
            $orders_count = $orders_count->select(DB::raw('count(orders.id) as count_orders'),
                DB::raw('year(created_at) as year'), DB::raw('month(created_at) as month'))
                ->groupBy(DB::raw('year(created_at)'), DB::raw('month(created_at)'));
        }

        $orders_count = $orders_count->get();
        return [

            'all_orders_count' => $orders_count->sum('count_orders'),
            'xAxes' => $day ? 'اليوم' : 'الشهر',
            'yAxes' => 'القيمة',
            'chart_area' => $this->set_data_sets_orders_count($orders_count, $day)
        ];
    }


    // charts
    public function set_data_sets_chart_area($financial_orders, $day)
    {
        $labels = [];
        $datasets = [];
        foreach ($financial_orders as $financial_order) {
            $labels[] = $day ? $financial_order->day . "/" . $financial_order->month : $financial_order->month;
        }
        $datasets[] = [
            'label' => 'المبيعات',
            'borderColor' => 'rgb(54, 162, 235)',
            'backgroundColor' => 'rgb(54, 162, 235)',
            'data' => $financial_orders->pluck('total_price')->toArray()
        ];
        $datasets[] = [
            'label' => 'تكلفة شحن الطلبات',
            'borderColor' => 'rgb(255, 205, 86)',
            'backgroundColor' => 'rgb(255, 205, 86)',
            'data' => $financial_orders->pluck('shipping')->toArray()
        ];
        $datasets[] = [
            'label' => 'تكلفة الضرائب',
            'borderColor' => 'rgb(75, 192, 192)',
            'backgroundColor' => 'rgb(75, 192, 192)',
            'data' => $financial_orders->pluck('tax')->toArray()
        ];
        $datasets[] = [
            'label' => 'قيمة القسائم الشرائية',
            'borderColor' => 'rgb(255, 99, 132)',
            'backgroundColor' => 'rgb(255, 99, 132)',
            'data' => $financial_orders->pluck('coupon_price')->toArray()
        ];
        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }
    public function set_data_sets_users_statistic($users_statistics, $day)
    {
        $labels = [];
        $datasets = [];
        foreach ($users_statistics as $users_statistic) {
            $labels[] = $day ? $users_statistic->day . "/" . $users_statistic->month : $users_statistic->month;
        }
        $datasets[] = [
            'label' => 'عدد العملاء',
            'borderColor' => 'rgb(54, 162, 235)',
            'backgroundColor' => '#9ad0f5',
            'data' => $users_statistics->pluck('count_users')->toArray()
        ];

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }
    public function set_data_sets_users_type($users_type)
    {

        $count_android_users = optional($users_type)->android_users;
        $count_ios_users = optional($users_type)->ios_users;
        $count_web_users = optional($users_type)->web_users;

        $labels = [
            'web',
            'android',
            'ios'
        ];
        $datasets = [];

        $datasets[] = [
            'data' => [
                $count_web_users,
                $count_android_users,
                $count_ios_users
            ],
            'backgroundColor' => [
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(255, 99, 132)'
            ],
            'label' => 'منصة تسجيل العملاء',
        ];

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }
    public function set_data_sets_orders_data_type($orders_type)
    {

        $register_orders = $orders_type ? $orders_type->register_orders : 0;
        $guest_orders = $orders_type ? $orders_type->guest_orders : 0;


        $labels = [
            'العملاء',
            'الزوار'
        ];
        $datasets = [];

        $datasets[] = [
            'data' => [
                $register_orders,
                $guest_orders,
            ],
            'backgroundColor' => [
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
            ],
            'label' => 'الطلبات',
        ];

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }
    public function set_data_sets_all_orders_data_type($orders_type)
    {

        $knet_orders = $orders_type ? $orders_type->knet_orders : 0;
        $visa_orders = $orders_type ? $orders_type->visa_orders : 0;


        $labels = [
            'عدد الطلبات كي نت',
            'عدد الطلبات البطاقة الائتمانية',
        ];
        $datasets = [];

        $datasets[] = [
            'data' => [
                $knet_orders,
                $visa_orders,
            ],
            'backgroundColor' => [
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
            ],
            'label' => 'الطلبات',
        ];

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }
    public function set_data_sets_all_orders_shipping_data_type($orders_type)
    {



        $warehouse_orders = $orders_type ? $orders_type->warehouse_orders : 0;
        $home_delivery_orders = $orders_type ? $orders_type->home_delivery_orders : 0;


        $labels = [
            'الاستلام من المستودع',
            'التوصيل للمنزل',
        ];
        $datasets = [];

        $datasets[] = [
            'data' => [
                $warehouse_orders,
                $home_delivery_orders,
            ],
            'backgroundColor' => [
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
            ],
            'label' => 'الطلبات',
        ];

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }
    public function set_data_sets_orders_count($financial_orders, $day)
    {
        $labels = [];
        $datasets = [];
        foreach ($financial_orders as $financial_order) {
            $labels[] = $day ? $financial_order->day . "/" . $financial_order->month : $financial_order->month;
        }
        $datasets[] = [
            'label' => 'عدد الطلبات',
            'borderColor' => '#0000ffc4',
            'backgroundColor' => '#0000ffc4',
            'data' => $financial_orders->pluck('count_orders')->toArray()
        ];

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }

    // coupons
    public function show_coupon_in_home() {
        $coupons = Coupon::where('show_in_home' , '=' , 1)->get();
        $coupons_data = [];
        foreach ($coupons as $coupon) {

            if(Carbon::parse($coupon->end_at) >= Carbon::now()) {
                $count_down = Carbon::parse($coupon->end_at)->diffInSeconds(Carbon::now());
            }else {
                $count_down = 0;
            }
            $coupons_data[] = [
                'id' => $coupon->id ,
                'coupon' => $coupon->coupon ,
                'count_down' =>$count_down ,
            ];
        }
        return json_encode($coupons_data);
    }

}