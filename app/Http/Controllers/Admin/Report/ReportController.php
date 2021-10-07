<?php

namespace App\Http\Controllers\Admin\Report;


use App\Exports\ProductExport;
use App\Http\Resources\Product\ProductExcelResource;
use App\Http\Resources\Product\ProductSimpleExcelResource;
use App\Http\Resources\Product\ProductSimpleResource;
use App\Imports\ProductImport;
use App\Models\AttributeValue;
use App\Models\Country;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\HomeController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\FilterData;
use App\Models\TaxStatus;
use App\Models\StockStatus;
use App\Models\City;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVariation;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariationImage;
use App\Models\ProductVariationShipping;
use App\Models\Order;
use App\Models\PaymentMethod;
/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use App\Services\SWWWTreeTraversal;
use Illuminate\Support\Facades\File;

use DB;

use Illuminate\Validation\Rule;

// validations
use App\Validations\ProductValidation;

// Repository
use App\Repository\OrderRepository;

use Carbon\Carbon;

// exports
use Excel;
use App\Exports\StoreStatisticsExport;
use App\Exports\InvoiceExport;
use App\Exports\Invoice2Export;
use App\Exports\CouponExport;
use App\Exports\ProductCountryExport;

class ReportController extends HomeController
{


    public $order;

    public function __construct(OrderRepository $order)
    {
        $this->middleware('check_role:store_statistics', ['only' => ['store_statistics']]);
        $this->middleware('check_role:store_bill', ['only' => ['store_bill']]);
        $this->middleware('check_role:invoice', ['only' => ['invoice']]);
        $this->middleware('check_role:invoice2', ['only' => ['invoice2']]);
        $this->middleware('check_role:coupon', ['only' => ['coupon_bill']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.orders');
        parent::$data['route_uri'] = route('admin.orders.index');
        parent::$data['active_menu'] = 'statistics';
        $this->order = $order;
    }

    public function statistics_data()
    {
        $order_status = $this->order->get_order_status_data();
        if ($order_status) {
            $order_status->all_count = $order_status->finished_count + $order_status->failed_count + $order_status->canceled_count;
        }

        $payment_methods = PaymentMethod::Active()->get();
        $shipping_companies = ShippingCompany::Active()->get();
        parent::$data['countries'] = Country::Active()->get();

        parent::$data['payment_methods'] = $payment_methods;
        parent::$data['shipping_companies'] = $shipping_companies;
        parent::$data['order_status'] = $order_status;
    }

    // store_statistics
    public function store_statistics()
    {
        $this->statistics_data();
        parent::$data['sub_menu'] = 'store_statistics';

        return view('admin.reports.store_statistics', parent::$data);
    }

    public function get_store_statistics_ajax(Request $request)
    {


        $orders = $this->order->get_store_statistics_ajax_data($request);

        return DataTables::of($orders)
            ->editColumn('order_status', function ($model) {
                return trans_orignal_order_status()[$model->order_status];
            })
            ->editColumn('payment_name', function ($model) {
                return $model->payment_name;

            })->editColumn('shipment_at', function ($model) {
                return Carbon::parse($model->shipment_at)->format('d/m/Y');

            })->addColumn('actions', function ($model) {
                return view('admin.reports.parts.actions', ['id' => $model->id])->render();
            })
            ->escapeColumns(['*'])->make(true);
    }

    public function download_excel_store_statistics(Request $request)
    {
        /*
         $request = new Request();
         $request->replace(['status' => 4 , 'aa' => 'sss']);
         return $request->all();
        */
        $get_print_invoice_data = $this->get_print_store_statistics_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $file_name = $get_print_invoice_data['file_name'];
        $this->add_action("export_store_statistics", "report", json_encode([]));
        return Excel::download(new StoreStatisticsExport($excel_orders), "$file_name.xlsx");

    }

    public function excel_test_product()
    {


        $products_resource = collect();

        $products = Product::with(['all_variations' => function ($q) {
            $q->with('attribute_values', 'product', 'images');
        }])->get();

        foreach ($products as $product) {
            $products_resource->add(new ProductExcelResource($product));
            foreach ($product->all_variations as $product_variation) {
                $products_resource->add(new ProductSimpleExcelResource($product_variation));
            }
        }

//        return  $products_resource;

//        $products = ProductVariation::with('attribute_values','product','images')->where('product_id','<',5)->get();

//        $products_resource = ProductSimpleExcelResource::collection($tttt);
        return Excel::download(new ProductExport($products_resource), "product.xlsx");
        return redirect('admin/products');

    }

    public function excel_test_import_product(Request $request){


        if ($request->hasFile('excel_file')) {
            $path_excel = (new StoreFile($request->excel_file))->store_local('product_excel');
        }else{
            return 'error';
        }

        Excel::import(new ProductImport, add_path_for_excel('product_excel',$path_excel));
        return redirect('admin/products');
    }


    public function get_print_store_statistics_data(Request $request)
    {

        $orders = $this->order->get_store_statistics_ajax_data($request)->get();
        $excel_orders = [];
        foreach ($orders as $order) {
            $excel_orders[] = [
                'created_at' => $order->created_at,
                'user_name' => $order->user_name,
                'user_phone' => $order->user_phone,
                'id' => $order->id,
                'shipping_policy' => $order->shipping_policy,
                'products_count' => $order->products_count,
                'price_after' => $order->price_after,
                'total_coupon_price' => $order->total_coupon_price,
                'price_after_discount_coupon' => $order->price_after_discount_coupon,
                'shipping' => $order->shipping,
                'tax' => $order->tax,
                'cash_fees' => $order->cash_fees,
                'total_price' => $order->total_price,
                'shipping_company_name' => $order->shipping_company_name,
                'shipment_at' => Carbon::parse($order->shipment_at)->format('d/m/Y'),
                'payment_name' => $order->payment_name,
            ];
        }

        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $file_name = "orders";
        if (!is_null($date_from)) {
            $file_name = "orders ($date_from to $date_to)";
        }
        $excel_orders = collect($excel_orders);
        return ['excel_orders' => $excel_orders, 'file_name' => $file_name, 'date_from' => $date_from, 'date_to' => $date_to];
    }

    public function print_store_statistics(Request $request)
    {

        $get_print_invoice_data = $this->get_print_store_statistics_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $date_from = $get_print_invoice_data['date_from'];
        $date_to = $get_print_invoice_data['date_to'];

        $title = trans('admin.store_statistics');
        $sub_title = is_null($date_from) ? "" : trans('admin.result_date', ['date_from' => $date_from, 'date_to' => $date_to]);
        $this->add_action("print_store_statistics", "report", json_encode([]));
        return view('admin.reports.print.store_statistics', ['excel_orders' => $excel_orders, 'title' => $title, 'sub_title' => $sub_title]);
    }


    // store_bill
    public function store_bill()
    {
         $this->statistics_data();
        parent::$data['sub_menu'] = 'store_bill';
        return view('admin.reports.store_bill', parent::$data);
    }

    public function get_store_bill_ajax(Request $request)
    {


        $orders = $this->order->get_store_bill_ajax_data($request);
        return DataTables::of($orders)
            ->editColumn('order_status', function ($model) {
                return trans_order_status()[$model->order_status];
            })->addColumn('sku_products', function ($model) {
                return view('admin.reports.parts.sku_products', ['order_products' => $model->order_products])->render();

            })->addColumn('name_products', function ($model) {
                return view('admin.reports.parts.name_products', ['order_products' => $model->order_products])->render();

            })->addColumn('address', function ($model) {
                if ($model->order_user_shipping) {
                    $city = $model->order_user_shipping->shipping_city ? $model->order_user_shipping->shipping_city->name : "";
                    return $city . " - " . $model->order_user_shipping->address;
                } else {
                    return "";
                }

            })->editColumn('created_at', function ($model) {
                return Carbon::parse($model->created_at)->format('Y-m-d');
            })->addColumn('time', function ($model) {
                return Carbon::parse($model->created_at)->format('h:i A');
            })
            ->editColumn('payment_name', function ($model) {
                return $model->payment_name;

            })->editColumn('shipment_at', function ($model) {
                return Carbon::parse($model->shipment_at)->format('d/m/Y');

            })
            ->escapeColumns(['*'])->make(true);
    }

    public function download_excel_store_bill(Request $request)
    {
        /*
         $request = new Request();
         $request->replace(['status' => 4 , 'aa' => 'sss']);
         return $request->all();
        */
        $get_print_invoice_data = $this->get_print_store_bill_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $file_name = $get_print_invoice_data['file_name'];
        $this->add_action("export_store_bill", "report", json_encode([]));
        return Excel::download(new StoreStatisticsExport($excel_orders), "$file_name.xlsx");
    }

    public function get_print_store_bill_data(Request $request)
    {

        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $orders = $this->order->get_store_bill_ajax_data($request)->get();
        $excel_orders = [];
        foreach ($orders as $order) {
            $excel_orders[] = [
                'created_at' => $order->created_at,
                'user_name' => $order->user_name,
                'id' => $order->id,
                'shipping_policy' => $order->shipping_policy,
                'products_count' => $order->products_count,
                'price_after' => $order->price_after,
                'total_coupon_price' => $order->total_coupon_price,
                'price_after_discount_coupon' => $order->price_after_discount_coupon,
                'shipping' => $order->shipping,
                'tax' => $order->tax,
                'cash_fees' => $order->cash_fees,
                'total_price' => $order->total_price,
                'shipping_company_name' => $order->shipping_company_name,
                'shipment_at' => Carbon::parse($order->shipment_at)->format('d/m/Y'),
                'payment_name' => $order->payment_name,
            ];
        }
        $file_name = "orders";
        if (!is_null($date_from)) {
            $file_name = "orders ($date_from to $date_to)";
        }
        $excel_orders = collect($excel_orders);
        return ['excel_orders' => $excel_orders, 'file_name' => $file_name, 'date_from' => $date_from, 'date_to' => $date_to];
    }

    public function print_store_bill(Request $request)
    {

        $get_print_invoice_data = $this->get_print_store_bill_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $date_from = $get_print_invoice_data['date_from'];
        $date_to = $get_print_invoice_data['date_to'];

        $title = trans('admin.store_bill');
        $sub_title = is_null($date_from) ? "" : trans('admin.result_date', ['date_from' => $date_from, 'date_to' => $date_to]);
        $this->add_action("print_store_bill", "report", json_encode([]));
        return view('admin.reports.print.store_bill', ['excel_orders' => $excel_orders, 'title' => $title, 'sub_title' => $sub_title]);
    }

    // invoice
    public function invoice()
    {
        $order_status = $this->order->get_order_status_data();
        if ($order_status) {
            $order_status->all_count = $order_status->finished_count + $order_status->returned_count;
        }
        $payment_methods = PaymentMethod::Active()->get();
        parent::$data['payment_methods'] = $payment_methods;
        parent::$data['order_status'] = $order_status;
        parent::$data['sub_menu'] = 'invoice';
        return view('admin.reports.invoice', parent::$data);
    }

    public function get_invoice_ajax(Request $request)
    {
        $orders = $this->order->get_invoice_ajax_data($request);
        return DataTables::of($orders)
            ->addColumn('line_num', function ($model) {
                return "";
            })->addColumn('currency', function ($model) {
                return trans('api.currency', [], 'en');
            })->addColumn('sku', function ($model) {
                return $model->product_variation->sku;
            })->addColumn('product_name', function ($model) {
                return $model->product_variation && $model->product_variation->product ? $model->product_variation->product->name : "";
            })->addColumn('WhsCode', function ($model) {
                return "023";
            })->addColumn('UseBaseUn', function ($model) {
                return "N";
            })->addColumn('VatGroup', function ($model) {
                return $model->tax != 0 ? "O1" : "";
            })->addColumn('UnitMsr', function ($model) {
                return "حبة";
            })->addColumn('NumPerMsr', function ($model) {
                return "1";
            })->addColumn('CogsAcct', function ($model) {
                return "C10023";
            })->addColumn('OcrCode2', function ($model) {
                return "";
            })
            ->escapeColumns(['*'])->make(true);
    }

    public function download_excel_invoice(Request $request)
    {


        $get_print_invoice_data = $this->get_print_invoice_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $file_name = $get_print_invoice_data['file_name'];
        $this->add_action("export_store_statistics", "report", json_encode([]));
        return Excel::download(new InvoiceExport($excel_orders), "$file_name.xlsx");
    }

    public function get_print_invoice_data(Request $request)
    {
        $orders = $this->order->get_invoice_ajax_data($request)->get();
        $excel_orders = [];
        foreach ($orders as $order) {
            $excel_orders[] = [
                'DocNum' => $order->order_id,
                'LineNum' => $order->line_num,
                'ItemCode' => $order->product_variation ? $order->product_variation->sku : "",
                'Description' => $order->product_variation && $order->product_variation->product ? $order->product_variation->product->name : "",
                'Quantity' => $order->quantity,
                'price' => $order->price,
                'Currency' => trans('api.currency', [], 'en'),
                'DiscPrcnt' => $order->discount_price,
                'WhsCode' => "023",
                'UseBaseUn' => "N",
                'VatGroup' => $order->tax != 0 ? "O1" : "",
                'UnitMsr' => "حبة",
                'NumPerMsr' => "1",
                'LineTotal' => $order->price_after,
                'CogsAcct' => "C10023",
                'OcrCode2' => "",
            ];
        }
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $file_name = "invoice";
        $result = null;
        if (!is_null($date_from)) {
            $file_name = "invoice ($date_from to $date_to)";
        }
        $excel_orders = collect($excel_orders);
        return ['excel_orders' => $excel_orders, 'file_name' => $file_name, 'date_from' => $date_from, 'date_to' => $date_to];
    }

    public function print_invoice(Request $request)
    {

        $get_print_invoice_data = $this->get_print_invoice_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $date_from = $get_print_invoice_data['date_from'];
        $date_to = $get_print_invoice_data['date_to'];

        $title = trans('admin.invoice');
        $sub_title = is_null($date_from) ? "" : trans('admin.result_date', ['date_from' => $date_from, 'date_to' => $date_to]);
        $this->add_action("export_store_statistics", "report", json_encode([]));
        return view('admin.reports.print.invoice', ['excel_orders' => $excel_orders, 'title' => $title, 'sub_title' => $sub_title]);
    }

    // invoice2
    public function invoice2()
    {

        $order_status = $this->order->get_order_status_data();
        if ($order_status) {
            $order_status->all_count = $order_status->finished_count + $order_status->returned_count;
        }
        $payment_methods = PaymentMethod::Active()->get();
        parent::$data['payment_methods'] = $payment_methods;
        parent::$data['order_status'] = $order_status;
        parent::$data['sub_menu'] = 'invoice2';
        return view('admin.reports.invoice2', parent::$data);
    }

    public function get_invoice2_ajax(Request $request)
    {
        //  return $request->all();
        $orders = $this->order->get_invoice2_ajax_data($request);
        return DataTables::of($orders)
            ->addColumn('DocNum', function ($model) {
                return "";
            })->addColumn('DocEntry', function ($model) {
                return $model->id;
            })->addColumn('DocType', function ($model) {
                return "dDocument_Items";
            })->addColumn('Handwrtten', function ($model) {
                return "N";
            })->addColumn('DocDate', function ($model) {
                return Carbon::parse($model->created_at)->format('Ymd');
            })->addColumn('DocDueDate', function ($model) {
                return Carbon::parse($model->shipment_at)->format('Ymd');
            })->addColumn('CardCode', function ($model) {
                return "C9999999";
            })->addColumn('DocTotal', function ($model) {
                return $model->total_price;
            })->addColumn('DocCur', function ($model) {
                return trans('api.currency', [], 'en');
            })->addColumn('Ref1', function ($model) {
                return $model->rownum;
            })->addColumn('Ref2', function ($model) {
                return "";
            })->addColumn('Comments', function ($model) {
                return "";
            })->addColumn('JrnlMemo', function ($model) {
                return "A/R Invoices - C9999999";
            })->addColumn('SlpCode', function ($model) {
                return -1;
            })->addColumn('DiscPrcnt', function ($model) {
                return 0;
            })
            ->escapeColumns(['*'])->make(true);
    }

    public function download_excel_invoice2(Request $request)
    {
        $get_print_invoice_data = $this->get_print_invoice2_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $file_name = $get_print_invoice_data['file_name'];

        return Excel::download(new Invoice2Export($excel_orders), "$file_name.xlsx");
    }

    public function get_print_invoice2_data(Request $request)
    {
        $orders = $this->order->get_invoice2_ajax_data($request)->get();
        $excel_orders = [];
        $rownum = 199000000;
        foreach ($orders as $order) {
            $excel_orders[] = [
                'DocNum' => "",
                'DocEntry' => $order->id,
                'DocType' => "dDocument_Items",
                'Handwrtten' => "N",
                'DocDate' => Carbon::parse($order->created_at)->format('Ymd'),
                'DocDueDate' => Carbon::parse($order->shipment_at)->format('Ymd'),
                'CardCode' => "C9999999",
                'DocTotal' => $order->total_price,
                'DocCur' => trans('api.currency', [], 'en'),
                'Ref1' => $rownum++,
                'Ref2' => "",
                'Comments' => "",
                'JrnlMemo' => "A/R Invoices - C9999999",
                'SlpCode' => -1,
                'DiscPrcnt' => "0",
            ];
        }
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $file_name = "invoice";
        $result = null;
        if (!is_null($date_from)) {
            $file_name = "invoice ($date_from to $date_to)";
        }
        $excel_orders = collect($excel_orders);
        return ['excel_orders' => $excel_orders, 'file_name' => $file_name, 'date_from' => $date_from, 'date_to' => $date_to];
    }

    public function print_invoice2(Request $request)
    {

        $get_print_invoice_data = $this->get_print_invoice2_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $date_from = $get_print_invoice_data['date_from'];
        $date_to = $get_print_invoice_data['date_to'];

        $title = trans('admin.invoice');
        $sub_title = is_null($date_from) ? "" : trans('admin.result_date', ['date_from' => $date_from, 'date_to' => $date_to]);
        $this->add_action("export_store_statistics", "report", json_encode([]));
        return view('admin.reports.print.invoice2', ['excel_orders' => $excel_orders, 'title' => $title, 'sub_title' => $sub_title]);
    }


    // coupon
    public function coupon_bill(Request $request)
    {

        parent::$data['sub_menu'] = 'coupon_bill';
        parent::$data['route_name'] = trans('admin.coupons');
        parent::$data['route_uri'] = route('admin.coupons.index');
        return view('admin.reports.coupon', parent::$data);

    }

    public function get_coupon_ajax(Request $request)
    {
        $coupons = $this->order->get_coupon_ajax_data($request);
        return DataTables::of($coupons)
            ->editColumn('pending_orders_price', function ($model) {
                return $model->pending_orders_price ? $model->pending_orders_price : "0";
            })->editColumn('confirm_orders_price', function ($model) {
                return $model->confirm_orders_price ? $model->confirm_orders_price : "0";
            })->escapeColumns(['*'])->make(true);
    }

    public function download_excel_coupon(Request $request)
    {
        $get_print_coupon_data = $this->get_print_coupon_data($request);
        $excel_coupons = $get_print_coupon_data['excel_coupons'];
        $file_name = $get_print_coupon_data['file_name'];
        $this->add_action("export_coupon_bill", "report", json_encode([]));
        return Excel::download(new CouponExport($excel_coupons), "$file_name.xlsx");
    }

    public function get_print_coupon_data(Request $request)
    {
        $coupons = $this->order->get_coupon_ajax_data($request)->get();
        $excel_coupons = [];
        foreach ($coupons as $coupon) {
            $excel_coupons[] = [
                'coupon_code' => $coupon->coupon,
                'discount_rate' => $coupon->value,
                'user_famous_rate' => $coupon->user_famous_rate ? $coupon->user_famous_rate : "0",
                'total_orders' => $coupon->orders_count ? $coupon->orders_count : "0",
                'checked_count' => $coupon->checked_count ? $coupon->checked_count : "0",
                'total_discounts' => $coupon->order_discount_price ? $coupon->order_discount_price : "0",
                'pending_orders' => $coupon->pending_orders ? $coupon->pending_orders : "0",
                'pending_orders_price' => $coupon->pending_orders_price ? $coupon->pending_orders_price : "0",
                'confirm_orders' => $coupon->confirm_orders ? $coupon->confirm_orders : "0",
                'confirm_orders_price' => $coupon->confirm_orders_price ? $coupon->confirm_orders_price : "0",
                'user_famous_total_price' => $coupon->user_famous_price ? $coupon->user_famous_price : "0",
            ];
        }
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $file_name = "coupon";
        $result = null;
        if (!is_null($date_from)) {
            $file_name = "invoice ($date_from to $date_to)";
        }
        $excel_coupons = collect($excel_coupons);
        return ['excel_coupons' => $excel_coupons, 'file_name' => $file_name, 'date_from' => $date_from, 'date_to' => $date_to];
    }

    public function print_coupon(Request $request)
    {

        $get_print_coupon_data = $this->get_print_coupon_data($request);
        $excel_coupons = $get_print_coupon_data['excel_coupons'];
        $date_from = $get_print_coupon_data['date_from'];
        $date_to = $get_print_coupon_data['date_to'];

        $title = trans('admin.coupon');
        $sub_title = is_null($date_from) ? "" : trans('admin.result_date', ['date_from' => $date_from, 'date_to' => $date_to]);
        $this->add_action("print_coupon_bill", "report", json_encode([]));
        return view('admin.reports.print.coupon', ['excel_coupons' => $excel_coupons, 'title' => $title, 'sub_title' => $sub_title]);
    }


}

