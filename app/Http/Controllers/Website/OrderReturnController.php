<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;

// models

use App\Models\Order;


use Illuminate\Support\Facades\Cache;

use App\Services\Order\OrderReturnService;

class OrderReturnController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        parent::$data['breadcrumb_title'] = trans('website.my_account');
        parent::$data['breadcrumb_arr'] = [];
        parent::$data['breadcrumb_last_item'] = trans('website.my_account');

        return view('website.check_return_order' , parent::$data);
    }
    public function check_return_order(Request $request) {
        return response()->json(OrderReturnService::check_return_order($request));
    }
    public function return_order_product(Request $request , Order $order) {
        return response()->json(OrderReturnService::return_order_product($order , $request->return_products));
    }


}
