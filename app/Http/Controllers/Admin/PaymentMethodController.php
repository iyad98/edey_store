<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Bank;
use App\Models\Product;
use App\Models\PaymentMethod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\FilterData;
use App\Models\ShippingCompany;


/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use App\Services\PublicOrderDataService;

use DB;
use Illuminate\Support\Facades\File;

use Illuminate\Validation\Rule;

class PaymentMethodController extends HomeController
{


    public function __construct()
    {

        $this->middleware('check_role:view_payment_methods|add_payment_methods|edit_payment_methods|delete_payment_methods', ['only' => ['index']]);
        $this->middleware('check_role:add_payment_methods', ['only' => ['store']]);
        $this->middleware('check_role:edit_payment_methods', ['only' => ['update' , 'change_status']]);
        $this->middleware('check_role:delete_payment_methods', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.payment_methods');
        parent::$data['route_uri'] = route('admin.payment_methods.index');
        parent::$data['active_menu'] = 'settings';
        parent::$data['sub_menu'] = 'payment_methods';

    }


    public function index(Request $request)
    {

        return view('admin.payment_methods.index', parent::$data);
    }


    public function update(Request $request)
    {
        $id = $request->id;

        $rules = [

            'name_ar' => [
                'required',
                Rule::unique('payment_methods', 'name_ar')->ignore($id)
            ],
            'name_en' => [
                'required',
                Rule::unique('payment_methods', 'name_en')->ignore($id)
            ],
            'note_ar' => [
                'required'
            ],
            'note_en' => [
                'required'
            ],

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $payment_method = PaymentMethod::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->name_en;
            $note_ar = $request->note_ar;
            $note_en = $request->note_en;

            if ($request->hasFile('image')) {
                if( $payment_method->getOriginal('image') != get_default_image()) {
                    File::delete(public_path()."/uploads/payments/".$payment_method->getOriginal('image'));
                }
                $path = (new StoreFile($request->image))->store_local('payments');
            } else {
                $path = $payment_method->getOriginal('image');
            }

            $payment_method->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'note_ar' => $note_ar,
                'note_en' => $note_en,
                'image' => $path,
            ]);
            $this->add_action("update_payment_method" ,'payment_method', json_encode($payment_method));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function change_status(Request $request)
    {
        $payment_method = PaymentMethod::find($request->id);
        $from_status = status_user()[$payment_method->status]['title'];
        $payment_method_copy = clone $payment_method;
        if ($payment_method->status == 1) {
            $payment_method->status = 0;
        } else {
            $payment_method->status = 1;
        }
        $payment_method->update();

        $to_status = status_user()[$payment_method->status]['title'];
        /***************************************************************************************************/
        $payment_method_copy->from_status = $from_status;
        $payment_method_copy->to_status = $to_status;
        $this->add_action("change_status_payment_method" ,'payment_method', json_encode($payment_method_copy));
        /*******************************************************************************************************/
        return general_response(true, true, "", "", "", []);

    }

    public function get_payment_methods_ajax(Request $request)
    {

        $payment_method = PaymentMethod::select('*');
        return DataTables::of($payment_method)
            ->editColumn('status', function ($model) {
                return view('admin.payment_methods.parts.status', ['status' => $model->status])->render();
            })
            ->editColumn('show_image', function ($model) {
                return view('admin.payment_methods.parts.image', ['image' => $model->image])->render();
            })->addColumn('actions', function ($model) {
                return view('admin.payment_methods.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


    public function get_payment_methods_by_shipping_company($shipping_company_id, $city_id) {
        $shipping_company = ShippingCompany::find($shipping_company_id);
        return response()->json(PublicOrderDataService::get_payment_methods($shipping_company ,$city_id));

    }

}
