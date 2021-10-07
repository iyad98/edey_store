<?php

namespace App\Http\Controllers\Admin\Order;


use App\Http\Controllers\Admin\HomeController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/*  Models */

use App\Models\Order;

// Repository
use App\Repository\OrderRepository;

// Services
use Carbon\Carbon;

// requests
use App\Http\Requests\Admin\Order\AddInvoiceRequest;

class OrderInvoiceController extends HomeController
{


    public $order;
    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

   public function store(AddInvoiceRequest $request , Order $order) {
       $order->update(['invoice_number' => $request->invoice_number]);
       $this->add_action("add_invoice_number" ,'order', json_encode($order));
       return general_response(true, true, trans('admin.added_invoice_number_success'), "", "", [
           'invoice_number' => $request->invoice_number
       ]);
   }
}
