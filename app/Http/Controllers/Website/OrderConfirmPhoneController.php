<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;

// services
use App\Services\Order\OrderConfirmPhoneService;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderConfirmPhoneController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function send_code(Request $request) {
       $result = OrderConfirmPhoneService::send_code($request);

       return response()->json($result);
    }
    public function confirm_code(Request $request) {
        $result = OrderConfirmPhoneService::confirm($request);
        return response()->json($result);
    }

}
