<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\Types\Self_;

// models

use App\Models\Order;


use Illuminate\Support\Facades\Cache;

use App\Services\Order\OrderReturnService;

class OrderReturnController extends Controller
{




    public function return_order_product(Request $request , Order $order) {

       return  $result = OrderReturnService::return_order_product($order , $request->return_products);

        return response_api($result['status'], $result['message'], $result['data']);
    }


}
