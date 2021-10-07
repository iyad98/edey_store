<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*  Models */
use App\Models\Payment;

/* Resources */

use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{

    public function get_payments() {
        $payments = Payment::all();
        return response_api(true, trans('api.success'), PaymentResource::collection($payments) );
    }
}
