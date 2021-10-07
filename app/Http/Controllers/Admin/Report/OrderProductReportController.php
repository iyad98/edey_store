<?php

namespace App\Http\Controllers\Admin\Report;


use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Controller;

use App\Models\ShippingCompany;
use App\Repository\OrderRepository;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\PaymentMethod;
use App\Models\Country;

class OrderProductReportController extends HomeController
{

    public $order;

    public function __construct(OrderRepository $order)
    {
        $this->middleware('check_role:order_product_reports');
        parent::__construct();
        parent::$data['route_name'] = trans('admin.orders');
        parent::$data['route_uri'] = route('admin.orders.index');
        parent::$data['active_menu'] = 'statistics';
        parent::$data['sub_menu'] = 'order_product';
        $this->order = $order;
    }

    public function index(Request $request)
    {
        $product_variation_id = $request->product_variation_id;
        $product_id = $request->product_id;
        $start_at = $request->filled('start_at') ? $request->start_at : Carbon::now()->subDays(29)->format('Y-m-d');
        $end_at = $request->filled('end_at') ? $request->end_at : Carbon::now()->format('Y-m-d');

        $id = 0;
        $type = 0;
        $product = json_encode("");
        $product_variation = json_encode("");

        if($request->filled('product_id')) {
            $product = Product::find($product_id);
            $id = $product->id;
            $type = 1;
        }else if($request->filled('product_variation_id')) {
            $product_variation = ProductVariation::with(['product' , 'attribute_values.attribute'])->find($product_variation_id);
            $id = $product_variation->id;
            $type = 2;
        }

        $chart_orders = $this->get_chart_orders($id, $type,$start_at,$end_at);
        $shipping_companies = ShippingCompany::Active()->get();

        parent::$data['shipping_companies'] = $shipping_companies;
        parent::$data['start_at'] = $start_at;
        parent::$data['end_at'] = $end_at;
        parent::$data['type_product_id'] = $id;
        parent::$data['type_product'] = $type;
        parent::$data['product'] = $product;
        parent::$data['product_variation'] = $product_variation;
        parent::$data['payment_methods'] = PaymentMethod::Active()->get();
        parent::$data['order_status'] = array_chunk($this->get_order_product_status($id, $type,$start_at,$end_at) ,3);
        parent::$data['chart_orders'] = json_encode($chart_orders);
        parent::$data['count_orders'] = $chart_orders['orders_count'];
        parent::$data['orders_payment_type'] = json_encode($this->get_orders_payment_type($id, $type,$start_at,$end_at));
        parent::$data['countries'] = Country::Active()->get();

        return view('admin.reports.order_product' , parent::$data);
    }


    public function get_orders($id,$type,$start_at , $end_at) {
        $orders = Order::with(['payment_method'])->DateOrder($start_at , $end_at);
        switch ($type) {
            case 1 :
                $orders = $orders->OrderProduct($id);
                break;
            default :
                $orders = $orders->OrderProductVariation($id);
                break;
        }
        return $orders;
    }

    // help function
    public function get_order_product_status($id , $type ,$start_at,$end_at) {
        $order_status = $this->get_orders($id , $type ,$start_at,$end_at);
        $order_status =  $order_status->select('orders.status' , DB::raw('count(*) as count_orders'))->groupBy('orders.status')->get();
        $get_order_status = [];
        foreach (orignal_order_status() as $key => $value) {
            $get_order_status[] = [
                'id'           => $value ,
                'text'         => trans_orignal_order_status()[$value] ,
                'count_orders' => optional($order_status->where('status' ,'=' ,$value)->first())->count_orders

            ];
        }
        return $get_order_status;


    }
    public function get_chart_orders($id , $type,$start_at, $end_at)
    {
        $diff_in_days = Carbon::parse($end_at)->diffInDays(Carbon::parse($start_at));
        $orders= $this->get_orders($id , $type ,$start_at,$end_at);

        if ($diff_in_days <= 31) {
            $day = true;
            $orders =$orders->select(DB::raw('year(created_at) as year'), DB::raw('month(created_at) as month'), DB::raw('day(created_at) as day'),
                DB::raw('count(*) as orders_count'))
                ->groupBy(DB::raw('year(created_at)'), DB::raw('month(created_at)'), DB::raw('day(created_at)'));
        } else {
            $day = false;
            $orders = $orders->select(DB::raw('year(created_at) as year'), DB::raw('month(created_at) as month'),
                DB::raw('count(*) as orders_count'))
                ->groupBy(DB::raw('year(created_at)'), DB::raw('month(created_at)'));
        }

        $orders = $orders->get();
        return [
            'xAxes'             => $day ? 'اليوم' : 'الشهر',
            'yAxes'             => 'القيمة',
            'chart_area'        => $this->set_data_sets_chart_area($orders, $day) ,
            'orders_count'  => $orders->sum('orders_count'),
        ];
    }
    public function get_orders_payment_type($id , $type,$start_at, $end_at)
    {
        $orders = $this->get_orders($id , $type ,$start_at,$end_at);
        $orders = $orders->select('payment_method_id',DB::raw('count(*) as count_orders'))->groupBy('payment_method_id')->get();

        return $this->set_data_sets_payment_type($orders);
    }

    // charts
    public function set_data_sets_chart_area($orders, $day)
    {
        $labels = [];
        $datasets = [];
        foreach ($orders as $order) {
            $labels[] = $day ? $order->day . "/" . $order->month : $order->month;
        }
        $datasets[] = [
            'label' => 'عدد الطلبات',
            'borderColor' => 'rgb(54, 162, 235)',
            'backgroundColor' => 'rgb(54, 162, 235)',
            'data' => $orders->pluck('orders_count')->toArray()
        ];

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }
    public function set_data_sets_payment_type($orders)
    {

        $complaint_categories = $orders->map(function ($value){
            $value->backgroundColor = $this->getColor($value->payment_method->id*55);
            return $value;
        });
        $labels = $orders->pluck('payment_method.name')->toArray();
        $data   = $orders->pluck('count_orders')->toArray();
        $backgroundColor = $complaint_categories->pluck('backgroundColor')->toArray();

        $datasets = [];

        $datasets[] = [
            'data' => $data,
            'backgroundColor' =>$backgroundColor ,
            'label' => 'الطلبات حسب طرق الدفع',
        ];

        $data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        return $data;
    }

    //
    function getColor($num)
    {
        $hash = md5('color' . $num);
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));
        return "rgb($r, $g, $b)";
    }
}

