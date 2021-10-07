<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Order\OrderConfirmPhoneService;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Self_;

// services

class OrderConfirmPhoneController extends Controller
{

    public function send_code(Request $request)
    {
        $result = OrderConfirmPhoneService::send_code($request);
        return response_api($result['status'], $result['message'], $result['data']);
    }

    public function confirm_code(Request $request)
    {
        $result = OrderConfirmPhoneService::confirm($request);
        return response_api($result['status'], $result['message'], $result['data']);
    }

}
