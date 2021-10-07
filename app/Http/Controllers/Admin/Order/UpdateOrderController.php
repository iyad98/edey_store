<?php

namespace App\Http\Controllers\Admin\Order;


use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ShippingCompany;
use App\Models\ShippingCompanyCity;
use App\Repository\OrderRepository;
use App\Validations\OrderValidation;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

/*  Models */
// Repository

/* service */
use App\Services\PointService;

/*  validations */

class UpdateOrderController extends OrderController
{


    public $validation;
    public $order;

    public function __construct(OrderRepository $order, OrderValidation $validation)
    {
        $this->middleware('check_role:edit_orders');
        $this->order = $order;
        $this->validation = $validation;
    }

    public function update_order_form_data(Request $request)
    {
        $check_data = $this->validation->check_update_order_data($request->toArray());

        if ($check_data['status']) {

            $order = $this->order->find($request->id);

            $can_edit = $this->order->can_edit_order($order->status);
            if ($can_edit == 0) {
                return general_response(false, true, "", trans('admin.cant_edit'), "", []);
            }
            
            $order_user_shipping = $order->order_user_shipping;
            $order_company_shipping = $order->company_shipping;
            $order_company_shipping_data = [];
            $shipping_company_city = null;

            if($request->extra_data == 1) {
                $city = City::find($request->city_id);
                $shipping_company = ShippingCompany::find($request->shipping_company_id);
                $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company, $city)->first();
                $get_payment_method = PaymentMethod::find($request->payment_method_id);

                if (!$shipping_company_city ) {
                    return general_response(false, true, "", trans('admin.shipping_company_city_not_found'), "", []);
                }

            }


            $order_user_shipping_data = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,

                'gift_target_phone' => $request->gift_target_phone ,
                'gift_first_name' => $request->gift_first_name ,
                'gift_last_name' => $request->gift_last_name ,
                'gift_target_email' => $request->gift_target_email ,
                'gift_text' => $request->gift_text ,

                'address' => $request->address,
                'billing_national_address' => $request->billing_national_address,
                'billing_building_number' => $request->billing_building_number,
                'billing_postalcode_number' => $request->billing_postalcode_number,
                'billing_extra_number' => $request->billing_extra_number,
                'billing_unit_number' => $request->billing_unit_number,
            ];
            if ($request->extra_data == 1) {
                $order_user_shipping_data['city'] = $request->city_id;
                $order_user_shipping_data['billing_shipping_type'] = $request->shipping_company_id;

                $order_company_shipping_data = [
                    'shipping_company_id' => $request->shipping_company_id,
                    'shipping_company_city_id' => $shipping_company_city->id,
                    'shipping_company_cash_prices' => json_encode($shipping_company_city->shipping_company_cash_prices) ,
                    'shipping_company_prices' => json_encode($shipping_company_city->shipping_company_prices) ,

                ];

            }
            DB::beginTransaction();

            try {

                $order_user_shipping->update($order_user_shipping_data);
                if ($request->extra_data == 1) {
                    $order_company_shipping->update($order_company_shipping_data);
                }

                $order->user_name = $request->first_name . " " . $request->last_name;
                $order->user_phone = $request->phone;
                $order->user_email = $request->email;
                if ($request->extra_data == 1) {
                    $order->payment_method_id = $request->payment_method_id;
                    $order->cash_fees = $request->payment_method_id == 1 ? get_cash_value() : 0;
                }
                $order->update();
                if ($request->extra_data == 1) {
                    $this->order->update_order($order);
                }
                $order_details = $this->get_order_details($order->id);

            } catch (\Exception $e) {
                DB::rollback();
                return general_response(false, true, "", $e->getMessage(), "", []);

            } catch (\Error $e2) {
                DB::rollback();
                return general_response(false, true, "", $e2->getMessage(), "", []);
            }
            DB::commit();

            $this->add_action("update_order_data" ,'order', json_encode($order));
            return general_response(true, true, trans('admin.success'), "", "", [
                'order' => $order_details
            ]);

        } else {
            return general_response(false, true, "", $check_data['message'], "", []);
        }
    }

}
