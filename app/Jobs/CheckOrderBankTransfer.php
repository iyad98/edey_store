<?php

namespace App\Jobs;

use Illuminate\Http\Request;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
/*  Models */
use App\User;
use App\Models\Order;
use App\Models\Cart;

/* Repository */

use App\Http\Controllers\Admin\OrderController;
use App\Repository\OrderRepository;
use App\Repository\CartRepository;


class CheckOrderBankTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    public $order;
    public function __construct($order)
    {
        $this->order = $order;
    }


    public function handle()
    {

        $order_controller = app()->make('change-status-order-controller');
        $order = $this->order;
        $order_bank = $this->order->bank;
        if($order->status ==order_status()['payment_waiting'] &&  ((!$order_bank) || ($order_bank && $order_bank->status != 1))) {

            $request = new Request();
            $request->replace(['order_id' => $order->id , 'order_status' => order_status()['failed'] , 'shipping_policy' => null]);
            $order_controller->change_status($request);
        }
    }
}
