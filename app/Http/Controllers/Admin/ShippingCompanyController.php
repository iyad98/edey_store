<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Attribute;
use App\Models\AttributeType;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

/*  Models */

use App\Models\FilterData;
use App\Models\ShippingCompany;


/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use App\Services\PublicOrderDataService;

use DB;

use Illuminate\Validation\Rule;

use App\Validations\ShippingCompanyValidation;

class ShippingCompanyController extends HomeController
{


    public $validation;

    public function __construct(ShippingCompanyValidation $validation)
    {

        $this->middleware('check_role:view_shipping_companies|add_shipping_companies|edit_shipping_companies|delete_shipping_companies', ['only' => ['index']]);
        $this->middleware('check_role:add_shipping_companies', ['only' => ['create' ,'store' ]]);
        $this->middleware('check_role:edit_shipping_companies', ['only' => ['edit','update' ]]);
        $this->middleware('check_role:delete_shipping_companies', ['only' => ['delete' ]]);


        parent::__construct();
        parent::$data['active_menu'] = 'shipping_companies';
        parent::$data['route_name'] = trans('admin.shipping_companies');
        parent::$data['route_uri'] = route('admin.shipping_companies.index');
        $this->validation = $validation;

    }


    public function index()
    {
        $countries = Country::Active()->get();
        parent::$data['countries'] = $countries;
        return view('admin.shipping_companies.index', parent::$data);
    }

    public function store(Request $request)
    {

        $check_data = $this->validation->check_add_shipping_company($request->toArray());
        if ($check_data['status']) {

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $shipping_countries = $request->shipping_countries != "" ? explode(",", $request->shipping_countries) : [];
            $phone = $request->phone;
            $tracking_url = $request->tracking_url;
            $accept_user_shipping_address = $request->accept_user_shipping_address;
            $note = $request->note;

            $billing_national_address = $request->billing_national_address;
            $billing_building_number = $request->billing_building_number;
            $billing_postalcode_number = $request->billing_postalcode_number;
            $billing_unit_number = $request->billing_unit_number;
            $billing_extra_number = $request->billing_extra_number;



            if ($request->hasFile('image')) {
                $path = (new StoreFile($request->image))->store_local('shipping_companies');
            } else {
                $path = get_default_image();
            }

            if ($request->hasFile('image_web')) {
                $path_web = (new StoreFile($request->image))->store_local('shipping_companies');
            } else {
                $path_web = get_default_image();
            }

            $shipping_company = ShippingCompany::create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'image' => $path,
                'image_web' => $path_web,

                'phone' => $phone,
                'tracking_url' => $tracking_url,
                'billing_national_address' => $billing_national_address ,
                'billing_building_number' => $billing_building_number,
                'billing_postalcode_number' => $billing_postalcode_number,
                'billing_unit_number' => $billing_unit_number ,
                'billing_extra_number' => $billing_extra_number ,
                'note'=>$note,
            ]);
            if(!empty($shipping_countries)) {
                $shipping_company->countries()->sync($shipping_countries);
            }
            $this->add_action("add_shipping_company" ,'shipping_company', json_encode($shipping_company));
            return general_response(true, true, trans('admin.success'), "", "", []);

        } else {
            return general_response(false, true, "", $check_data['message'], "", []);
        }


    }

    public function update(Request $request)
    {

        $id = $request->id;

        $check_data = $this->validation->check_add_shipping_company($request->toArray());
        if ($check_data['status']) {

            $shipping_company = ShippingCompany::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $shipping_countries = $request->shipping_countries != "" ? explode(",", $request->shipping_countries) : [];
            $cash = $request->cash;
            $cash_value = $request->cash_value;

            $phone = $request->phone;
            $tracking_url = $request->tracking_url;
            $accept_user_shipping_address = $request->accept_user_shipping_address;

            $billing_national_address = $request->billing_national_address;
            $billing_building_number = $request->billing_building_number;
            $billing_postalcode_number = $request->billing_postalcode_number;
            $billing_unit_number = $request->billing_unit_number;
            $billing_extra_number = $request->billing_extra_number;
            $note = $request->note;


            if ($request->hasFile('image')) {

                if($shipping_company->getOriginal('image') != get_default_image()) {
                    File::delete(public_path('')."/uploads/shipping_companies/".$shipping_company->getOriginal('image'));

                }
                $path = (new StoreFile($request->image))->store_local('shipping_companies');
            } else {
                $path = $shipping_company->getOriginal('image');
            }

            if ($request->hasFile('image_web')) {

                if($shipping_company->getOriginal('image_web') != get_default_image()) {
                    File::delete(public_path('')."/uploads/shipping_companies/".$shipping_company->getOriginal('image_web'));

                }
                $path_web = (new StoreFile($request->image_web))->store_local('shipping_companies');
            } else {
                $path_web = $shipping_company->getOriginal('image_web');
            }



            $shipping_company->update([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'phone' => $phone,
                'tracking_url' => $tracking_url,
                'image' => $path,
                'image_web' => $path_web,

                'can_cash' => $cash == 1 ? 1 : 0,
                'cash_value' => $cash == 1 ? $cash_value : 0 ,
                'billing_national_address' => $billing_national_address ,
                'billing_building_number' => $billing_building_number,
                'billing_postalcode_number' => $billing_postalcode_number,
                'billing_unit_number' => $billing_unit_number ,
                'billing_extra_number' => $billing_extra_number ,
                'accept_user_shipping_address'=>$accept_user_shipping_address,
                'note'=>$note,
            ]);
            $shipping_company->countries()->sync($shipping_countries);
            $this->add_action("update_shipping_company" ,'shipping_company', json_encode($shipping_company));
            return general_response(true, true, trans('admin.success'), "", "", []);

        } else {
            return general_response(false, true, "", $check_data['message'], "", []);
        }
    }

    public function change_show_for_user(Request $request)
    {
        $shipping_company = ShippingCompany::find($request->id);
        if ($shipping_company->show_for_user == 1) {
            $shipping_company->show_for_user = 0;
        } else {
            $shipping_company->show_for_user = 1;
        }
        $shipping_company->update();

        return general_response(true, true, "", "", "", []);

    }
    public function delete(Request $request)
    {
        $shipping_company = ShippingCompany::find($request->id);

        try {
         //   $shipping_company->cities()->detach();
            $shipping_company->countries()->detach();
            $shipping_company->delete();

            $this->add_action("delete_shipping_company" ,'shipping_company', json_encode($shipping_company));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }


    }

    public function get_shipping_companies_ajax(Request $request)
    {
        $country_id = $request->filled('country_id') ? $request->country_id : -1;

        $shipping_company_data = ShippingCompany::with('countries');
        if ($country_id != -1) {
            $shipping_company_data = $shipping_company_data->InCountry($country_id);
        }

        return DataTables::of($shipping_company_data)
            ->editColumn('show_status', function ($model) {
                return view('admin.shipping_companies.parts.status', ['status' => $model->show_for_user])->render();
            })
            ->editColumn('show_image', function ($model) {
                return view('admin.shipping_companies.parts.image', ['image' => $model->image])->render();
            })->addColumn('actions', function ($model) {
                return view('admin.shipping_companies.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


    public function get_shipping_companies_by_city_id($city_id) {
        return response()->json(PublicOrderDataService::get_shipping_companies($city_id , true));
    }

}
