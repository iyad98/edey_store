<?php

namespace App\Http\Controllers\Admin\Order;


use App\Http\Controllers\Admin\HomeController;
use App\Services\StoreFile;
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

// notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendApproveOrRejectOrderReturnNotification;

class OrderReturnController extends HomeController
{


    public $order;
    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    public function approve(Order $order) {
        if(!$order) {
            return general_response(false, true, trans('admin.order_not_found'), "", "", []);
        }
        if(!in_array($order->status , [6,9,10])) {
            return general_response(false, true, trans('admin.order_status_not_in_return'), "", "", []);
        }
        if($order->returned_status == 1 ) {
            return general_response(false, true, trans('admin.order_is_already_approved'), "", "", []);
        }
        $order->returned_status = 1;
        $order->update();

        $title = trans('notification.approved_order_return_title');
        $sub_title = trans('notification.approved_order_return_message' , ['order_id' => $order->id]);
        Notification::route('test', 'test')->notify(new SendApproveOrRejectOrderReturnNotification($order, $title , $sub_title , 'approve_return_order') );

        $this->add_action("approve_order_return", "order_return", json_encode($order));

        return general_response(true, true, trans('admin.order_returned_approved_success'), "", "", [
            'returned_status' => 1
        ]);
    }

    public function reject(Order $order) {
        if(!$order) {
            return general_response(false, true, trans('admin.order_not_found'), "", "", []);
        }
        if(!in_array($order->status , [6,9,10])) {
            return general_response(false, true, trans('admin.order_status_not_in_return'), "", "", []);
        }
        if($order->returned_status == 2 ) {
            return general_response(false, true, trans('admin.order_is_already_rejected'), "", "", []);
        }
        $order->returned_status = 2;
        $order->update();

        $title = trans('notification.reject_order_return_title');
        $sub_title = trans('notification.reject_order_return_message' , ['order_id' => $order->id]);
        Notification::route('test', 'test')->notify(new SendApproveOrRejectOrderReturnNotification($order, $title , $sub_title , 'reject_return_order') );

        $this->add_action("reject_order_return", "order_return", json_encode($order));
        return general_response(true, true, trans('admin.order_returned_rejected_success'), "", "", [
            'returned_status' => 2
        ]);
    }

    public function send_return_order_note(Order $order , Request $request){

        if(!$order) {
            return general_response(false, true, trans('admin.order_not_found'), "", "", []);
        }
        if(!in_array($order->status , [6,9,10])) {
            return general_response(false, true, trans('admin.order_status_not_in_return'), "", "", []);
        }


        if ($request->hasFile('return_order_note_file')) {

            $return_order_note_file = (new StoreFile($request->return_order_note_file))->store_local('ads');
        } else {
            $return_order_note_file = '';
        }


        $order->return_order_note_text = $request->return_order_note_text;
        $order->return_order_note_file = $return_order_note_file;
        $order->update();

        $this->add_action("return_order_note_text", "order_return", json_encode($order));
        return general_response(true, true, trans('admin.return_order_note_text_send_success'), "", "", [
            'returned_status' => 2
        ]);

    }
}
