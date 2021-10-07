<?php

namespace App\Http\Controllers\Admin\Report;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\HomeController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\OrderProduct;
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

class SkuReportController extends HomeController
{


    public $order;

    public function __construct(OrderRepository $order)
    {

        parent::__construct();
        $this->middleware('check_role:sku_reports');

        parent::$data['route_name'] = trans('admin.sku_reports');
        parent::$data['route_uri'] = route('admin.sku_report.index');
        parent::$data['active_menu'] = 'statistics';
        parent::$data['sub_menu'] = 'report_sku';
        $this->order = $order;
    }



    // store_bill
    public function index()
    {
        $payment_methods = PaymentMethod::Active()->get();
        parent::$data['payment_methods'] = $payment_methods;
        return view('admin.reports.store_sku', parent::$data);
    }
    public function get_report_sku_ajax(Request $request)
    {
        $orders = $this->get_report_sku_query($request);
        return DataTables::of($orders)
            ->editColumn('show_image', function ($model) {
                return view('admin.reports.parts.image', ['image' => $model->product->image])->render();

            }) ->editColumn('sku_product_name', function ($model) {
                return view('admin.reports.parts.sku_product_name', ['name' => $model->product->name , 'id' => $model->product->id])->render();
            }) ->editColumn('sku_product', function ($model) {
                return view('admin.reports.parts.sku_report', ['sku' => $model->product_variation->sku , 'id' => $model->product_variation->id])->render();
            })
            ->editColumn('order_status', function ($model) {
                return trans_order_status()[$model->order->status];
            })->editColumn('payment_name', function ($model) {
                return $model->order->payment_method->name;

            })->escapeColumns(['*'])->make(true);
    }
    public function download_excel_sku_report(Request $request)
    {

        $get_print_invoice_data = $this->get_print_sku_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $file_name = $get_print_invoice_data['file_name'];
        $this->add_action("export_product_report_sku", "report" , json_encode([]));
        return Excel::download(new StoreStatisticsExport($excel_orders),  "$file_name.xlsx");
    }
    public function print_sku_report(Request $request) {

        $get_print_invoice_data = $this->get_print_sku_data($request);
        $excel_orders = $get_print_invoice_data['excel_orders'];
        $date_from = $get_print_invoice_data['date_from'];
        $date_to = $get_print_invoice_data['date_to'];

        $title = trans('admin.sku_report');
        $sub_title = is_null($date_from) ? "" :trans('admin.result_date' , ['date_from' => $date_from , 'date_to' => $date_to]);
        $this->add_action("print_product_report_sku", "report" , json_encode([]));
        return view('admin.reports.print.sku_report' , ['excel_orders' => $excel_orders ,'title' => $title , 'sub_title' => $sub_title]);
    }
    public function get_print_sku_data(Request $request) {

        $date_from  = $request->date_from;
        $date_to  = $request->date_to;
        $orders = $this->get_report_sku_query($request)->get();
        $excel_orders = [];
        foreach ($orders as $order) {
            $excel_orders[] = [
                'sku'          => $order->product_variation->sku,
                'product_name' => $order->product->name_ar,
                'order_id'     => $order->order_id,
                'quantity'     => $order->quantity,
                'order_status' => trans_order_status()[$order->order->status],
                'date'         => $order->order->created_at,
                'payment_name' => $order->order->payment_method->name,
            ];
        }
        $file_name = "sku_reports_orders";
        if(!is_null($date_from)) {
            $file_name = "sku_reports_orders ($date_from to $date_to)";
        }
        $excel_orders = collect($excel_orders);
        return ['excel_orders' => $excel_orders , 'file_name' => $file_name , 'date_from' => $date_from , 'date_to' => $date_to];
    }

    // help functions
    public function get_report_sku_query($request) {
        $order_products = OrderProduct::whereHas('order')->with(['product' , 'product_variation' , 'order.payment_method']);
        $get_date_filter = $this->order->get_date_filter($request->date_from, $request->date_to);
        $status = $request->filled('status') ? $request->status : -1;
        $payment_method = $request->filled('payment_method') ? $request->payment_method : -1;
        if ($get_date_filter['date_from'] != -1 && $get_date_filter['date_to'] != -1) {
            $order_products = $order_products->OrderDate($get_date_filter['date_from'] ,$get_date_filter['date_to']);
        }
        if($status != -1) {
            $order_products = $order_products->OrderStatus($status);
        }
        if($payment_method != -1) {
            $order_products = $order_products->OrderPaymentMethod($payment_method);
        }
        return $order_products;

    }
}

