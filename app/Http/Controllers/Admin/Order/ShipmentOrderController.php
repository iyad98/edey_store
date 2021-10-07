<?php

namespace App\Http\Controllers\Admin\Order;


use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\AddPickUpRequest;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Services\ShippingService\AramexShipping\Aramex;
use App\Services\ShippingService\SAMSAShipping\SAMSALibrary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/*  Request */


class ShipmentOrderController extends HomeController
{


    public $order;

    public function __construct(OrderRepository $order)
    {
        $this->middleware('check_role:view_orders');

        parent::__construct();
        parent::$data['active_menu'] = 'store';
        parent::$data['sub_menu'] = 'orders';

        parent::$data['route_name'] = trans('admin.orders');
        parent::$data['route_uri'] = route('admin.orders.index');
        $this->order = $order;
    }


    public function shipping_policy(Request $request)
    {
        $order = Order::with(['company_shipping', 'order_user_shipping.shipping_city'])->find($request->order_id);
        $shipping_policy = $order->shipping_policy;
        $shipping_policy_return = $order->shipping_policy_return;

        $is_return = $request->is_return;

        if (!$order || !$order->company_shipping) {
            return general_response(false, true, "", trans('admin.some_error_occured'), "", [
                'shipping_policy' => $shipping_policy ,
                'shipping_policy_return' => $shipping_policy_return
            ]);
        }

        if ($request->add == 1) {
            if($is_return  == 1) {
                $order->shipping_policy_return = $request->shipping_policy_return;
            }else {
                $order->shipping_policy = $request->shipping_policy;
            }

            $order->update();

        } else {

            $add_shipment = null;
            switch ($order->company_shipping->shipping_company_id) {
                case 1 :
                    $add_shipment = (new SAMSALibrary())->add_shipment($order , $is_return == 1);
                    break;
                case 3 :
                    $add_shipment = (new Aramex())->add_shipment($order , $is_return == 1);
                    break;


            }
            if (is_null($add_shipment) || !$add_shipment['status']) {
                return general_response(false, true, "", $add_shipment['message'], "", [
                    'shipping_policy' => $shipping_policy ,
                    'shipping_policy_return' => $shipping_policy_return
                ]);
            }
            $shipping_policy = $add_shipment['data']['shipping_policy'];
            if($is_return == 1) {
                $order->shipping_policy_return = $shipping_policy;
                if (array_key_exists('foreignHAWB', $add_shipment['data'])) {
                    $order->foreign_HAWB_return = $add_shipment['data']['foreignHAWB'];
                }
            }else {
                $order->shipping_policy = $shipping_policy;
                if (array_key_exists('foreignHAWB', $add_shipment['data'])) {
                    $order->foreign_HAWB = $add_shipment['data']['foreignHAWB'];
                }
            }

            $order->update();

//            if ($order->company_shipping->shipping_company_id == 1) {
//                $samsa_library = new SAMSALibrary();
//                $total_price = $order->payment_method_id == 1 ? $order->total_price : 0;
//                $add_shipment = $samsa_library->add_shipment($total_price, $order->order_user_shipping);
//                if (!$add_shipment['status']) {
//                    return general_response(false, true, "", $add_shipment['message'], "", [
//                        'shipping_policy' => $shipping_policy
//                    ]);
//                }
//                $shipping_policy = $add_shipment['data'];
//                $order->shipping_policy = $shipping_policy;
//                $order->update();
//            }
        }
        $this->add_action($is_return == 1 ? "add_shipping_policy_return" : "add_shipping_policy", 'shipping_policy', json_encode($order));

        return general_response(true, true, trans('admin.add_shipping_policy_success'), "", "", [
            'shipping_policy' => $order->shipping_policy ,
            'shipping_policy_return' => $order->shipping_policy_return ,
        ]);


    }
    public function print_shipping_policy(Request $request)
    {

        $order = Order::find($request->order_id);
        $is_return = $request->is_return;
        $this->add_action($is_return == 1 ? "print_shipping_policy_return" : "print_shipping_policy", 'shipping_policy', json_encode($order));

        if($is_return == 1) {
            if (empty($order->shipping_policy_return)) {
                return general_response(false, true, "", trans('admin.you_must_add_shipping_policy'), "", []);
            }
        }else {
            if (empty($order->shipping_policy)) {
                return general_response(false, true, "", trans('admin.you_must_add_shipping_policy'), "", []);
            }
        }

        if($is_return == 1) {
            $shipping_policy = $order->shipping_policy_return;
        }else {
            $shipping_policy = $order->shipping_policy;
        }
        switch ($order->company_shipping->shipping_company_id) {
            case 1 :
                $samsa_library = new SAMSALibrary();
                return $samsa_library->print_awb($order->id, $shipping_policy);
                break;
            case 3 :
                $aramex = new Aramex();
                return $aramex->print_awb($order->id, $shipping_policy);
                break;
        }

    }
    public function cancel_shipping_policy(Request $request)
    {
        $order = Order::find($request->order_id);
        $is_return = $request->is_return;
        if($is_return == 1) {
            if (empty($order->shipping_policy_return)) {
                return general_response(false, true, "", trans('admin.you_must_add_shipping_policy'), "", []);
            }
        }else {
            if (empty($order->shipping_policy)) {
                return general_response(false, true, "", trans('admin.you_must_add_shipping_policy'), "", []);
            }
        }

        if($is_return == 1) {
            $shipping_policy = $order->shipping_policy_return;
        }else {
            $shipping_policy = $order->shipping_policy;
        }
        $cancel_shipment = null;
        switch ($order->company_shipping->shipping_company_id) {
            case 1 :
                $samsa_library = new SAMSALibrary();
                $cancel_shipment = $samsa_library->cancel_order($shipping_policy);
                break;
        }
        if (!$cancel_shipment) {
            return general_response(false, true, "", trans('admin.shipping_company_deosnt_supported'), "", [
             'shipping_policy' => $order->shipping_policy ,
            'shipping_policy_return' => $order->shipping_policy_return ,
            ]);
        }
        if (!$cancel_shipment['status']) {
            return general_response(false, true, "", $cancel_shipment['message'], "", [
                'shipping_policy' => $order->shipping_policy ,
                'shipping_policy_return' => $order->shipping_policy_return ,
            ]);
        }

        if($is_return == 1) {
            $order->shipping_policy_return = null;
            $order->foreign_HAWB_return	 = null;
        }else {
            $order->shipping_policy = null;
            $order->foreign_HAWB = null;
        }

        $order->update();
       // $order->pickup()->delete();
        $this->add_action($is_return == 1 ? "cancel_shipping_policy_return" : "cancel_shipping_policy", 'shipping_policy', json_encode($order));
        return general_response(true, true, trans('admin.cancel_shipment_success'), "", "", [
            'shipping_policy' => $order->shipping_policy ,
            'shipping_policy_return' => $order->shipping_policy_return ,
        ]);


    }
}
