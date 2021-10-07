<?php

namespace App\Http\Controllers\Admin\Order;


use App\Http\Controllers\Admin\HomeController;
use App\Models\WalletLog;
use App\Services\Payment\Myfatoorah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/*  Models */

use App\Models\Order;
use App\User;
// Repository
use App\Repository\OrderRepository;

// Services
use App\Services\CartService;
use App\Services\PointService;
use App\Services\NotificationService\ChangeOrderStatusNotification;
use App\Services\Order\OrderLogService;
use Carbon\Carbon;

// notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendChangeOrderStatusNotification;

class ChangeOrderStatusController extends HomeController
{


    public $order;
    public function __construct(OrderRepository $order)
    {
        $this->middleware('check_role:change_status_orders');

        parent::__construct();
        parent::$data['active_menu'] = 'store';
        parent::$data['sub_menu'] = 'orders';

        parent::$data['route_name'] = trans('admin.orders');
        parent::$data['route_uri'] = route('admin.orders.index');
        $this->order = $order;
    }

    public function change_status(Request $request , $order = null ,$status= null )
    {
        $order_id = $request->order_id;
        $status = !is_null($status) ? $status : $request->order_status ;
        $order = !is_null($order) ?$order :$this->order->find($order_id);
        $order_status_point_to_failed = [orignal_order_status()['failed'],orignal_order_status()['canceled']];

        if(!$order) {
            return general_response(false, true, "", trans('admin.order_not_found'), "", [
                'order' => $order
            ]);
        }
        $previous_status = $order->status;

        if($previous_status == $status) {
            return general_response(false, true, "", trans('admin.order_is_same_status'), "", [
                'order' => $order
            ]);
        }

        try {
            $get_date_order_status = get_date_orignal_order_status()[$status];
        } catch (\Exception $e) {
            $get_date_order_status = 0;
        } catch (\Error $e) {
            $get_date_order_status = 0;
        }

        $order->status = $status;
//        if ($status != 0) {
//            $order->$get_date_order_status = Carbon::now();
//        }


        if ($status == orignal_order_status()['finished']){
           $is_take_point =  WalletLog::where('order_id',$order->id)->first();
                if (!$is_take_point){

                    $order->wallet_logs()->create([
                        'user_id'=>$order->user_id,
                        'order_id'=>$order->id,
                        'points'=>get_order_points($order->total_price),
                        'type'=>1,
                        'pricepoints'=>0,

                    ]);
                }
        }else{
             WalletLog::where('order_id',$order->id)->delete();
        }




        $order->update();
        if (in_array($order->status, $order_status_point_to_failed) && !in_array($previous_status, $order_status_point_to_failed)) {
            CartService::update_order_product_quantity($order, "+");
            $order->load('order_payment');
            $myFatoorah = new Myfatoorah();
            $myFatoorah->refund('invoiceid',$order->order_payment->payment_reference,$order->total_price);

        } else if (!in_array($order->status, $order_status_point_to_failed) && in_array($previous_status, $order_status_point_to_failed)) {
            CartService::update_order_product_quantity($order, "-");
        }



        $order->can_edit = $this->order->can_edit_order($order->status);
        $order->status_text = trans_order_status()[$order->status];
        $order->status_class = order_status_class()[$order->status];

        /************* send sms and email ***********************************/



        if ($order->status != orignal_order_status()['processing']){
            Notification::route('test', 'test')->notify(new SendChangeOrderStatusNotification($order, $order->shipping_policy, $status) );
        }

        $this->add_action("change_order_status" ,'order', json_encode([
            'order'       => $order,
            'from_status' =>  trans_order_status()[$previous_status],
            'to_status'   =>  trans_order_status()[$status],
        ]));

        return general_response(true, true, trans('admin.change_order_status_success'), "", "", [
            'order' => $order
        ]);

    }
    public function change_status_by_admin(Request $request) {
        $admin = Auth::guard('admin')->user();
        $order_id = $request->order_id;
        $status = $request->order_status;
        $order = $this->order->find($order_id);
        if($admin->super_admin != 1 && $status != $order->status && $admin->order_statuses()->count() > 0 && !$admin->order_statuses()->where('key' , '=' ,$order->status."-".$status )->exists()) {
            return general_response(false, false, "", trans('admin.no_auth'), "", [
                'order' => $order
            ]);
        }
        return $this->change_status($request ,$order, $status);
    }
    // execute options
    public function execute_option(Request $request)
    {


        $order_ids = json_decode($request->order_ids);
        $option = $request->option;

        if (empty($order_ids) || count($order_ids) <= 0) {
            return general_response(false, true, "", trans('admin.please_select_orders'), "", [
                'title' => trans('admin.error'),
                'order' => []
            ]);
        }
        if ($option == -1) {
            return general_response(false, true, "", trans('admin.please_select_option'), "", [
                'title' => trans('admin.error'),
                'order' => []
            ]);
        }

        if(in_array($option , [-2,-3]) && !check_role('delete_orders')) {
            return general_response(false, false, "", trans('admin.no_auth'), "", []);
        }
        if ($option == -4) {

            return general_response(true, true, trans('admin.success'), "", "", [
                'title' => trans('admin.done'),
                'order' => [],
                'order_ids' => $order_ids,
                'type' => -4
            ]);
        }

        switch ($option) {
            case -2 :
                Order::withTrashed()->whereIn('id', $order_ids)->restore();
                break;
            case -3 :
                Order::whereIn('id', $order_ids)->delete();
                break;

            default :
                foreach ($order_ids as $order_id) {
                    $request = new Request();
                    $request->replace(['order_id' => $order_id, 'order_status' => $option, 'shipping_policy' => null]);
                    $response = collect($this->change_status_by_admin($request))->toArray()['original'];
                    if (!$response['status']) {
                        return general_response(false, true, "", $response['error_msg'], "", [
                            'title' => trans('admin.error_in_order', ['order_id' => $order_id]),
                            'order_id' => $order_id
                        ]);
                    }

                }
        }

        return general_response(true, true, trans('admin.success'), "", "", [
            'title' => trans('admin.done'),
            'order' => null
        ]);

    }


}
