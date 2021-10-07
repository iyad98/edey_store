<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Attribute;
use App\Models\AttributeType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

/*  Models */

use App\Models\FilterData;
use App\Models\ShippingCompanyCity;
use App\Models\ShippingCompanyCountry;
use App\Models\OrderCompanyShipping;


/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;

use Illuminate\Validation\Rule;

use App\Validations\ShippingCompanyValidation;

class ShippingCompanyCityController extends HomeController
{


    public $validation;

    public function __construct(ShippingCompanyValidation $validation)
    {

        $this->middleware('check_role:edit_shipping_companies');


        parent::__construct();
        parent::$data['active_menu'] = 'shipping_companies';
        parent::$data['route_name'] = trans('admin.shipping_companies');
        parent::$data['route_uri'] = route('admin.shipping_companies.index');
        $this->validation = $validation;

    }


    public function index(Request $request, $shipping_company_country_id)
    {
        $shipping_company_country = ShippingCompanyCountry::with(['shipping_company' , 'country'])
            ->find($shipping_company_country_id);

        if(!$shipping_company_country) {
            abort(404);
        }
        $cities = City::Active()->InCountry($shipping_company_country->country_id)->get();

        parent::$data['cities'] = $cities;
        parent::$data['city_ids_not_in_shipping_company'] = json_encode($this->get_city_ids_not_in_shipping_company($shipping_company_country ));
        parent::$data['shipping_company_country'] = $shipping_company_country;
        parent::$data['shipping_company_country_id'] = $shipping_company_country_id;

        return view('admin.shipping_company_cities.index', parent::$data);
    }

    public function store(Request $request)
    {


        $shipping_company_country_id = $request->shipping_company_country_id;
        $shipping_company_country = ShippingCompanyCountry::find($shipping_company_country_id);

        $get_shipping_cash_prices = [];
        $shipping_cities = explode(",", $request->shipping_cities);
        $cash = $request->cash;
        $calculation_type = $request->calculation_type;


        $prices = json_decode($request->prices, true);
        $cash_prices = json_decode($request->cash_prices, true);


        $check_shipping_cities = $this->validation->check_shipping_cities(['cities' => $shipping_cities]);
        if (!$check_shipping_cities['status']) {
            return general_response(false, true, "", $check_shipping_cities['message'], "", []);
        }

        $check_shipping_company_country_cities = $shipping_company_country->shipping_company_country_cities()->whereIn('city_id' ,$shipping_cities );
        if($check_shipping_company_country_cities->count() > 0) {
            $cities_exists = $check_shipping_company_country_cities->with('city')->get()->pluck('city.name')->toArray();
            return general_response(false, true, "",trans('admin.cities_already_exists_in_shipping_company' , ['cities' => implode(' , ', $cities_exists)]) , "", []);

        }
        if ($cash == 1) {
            $check_shipping_cash_value = $this->validation->check_shipping_cash_value($cash_prices);
            if (!$check_shipping_cash_value['status']) {
                return general_response(false, true, "", $check_shipping_cash_value['message'], "", []);
            }
            $get_shipping_cash_prices = $check_shipping_cash_value['data'];
        }

        if ($calculation_type == 'piece'){

            $check_shipping_prices = $this->validation->check_shipping_piece($prices);

            if (!$check_shipping_prices['status']) {

                return general_response(false, true, "", $check_shipping_prices['message'], "", []);
            }
        }elseif($calculation_type == 'price'){

            $check_shipping_prices = $this->validation->check_shipping_prices($prices);

            if (!$check_shipping_prices['status']) {
                return general_response(false, true, "", $check_shipping_prices['message'], "", []);
            }

        }


        $get_shipping_prices = $check_shipping_prices['data'];

        foreach ($shipping_cities as $shipping_city) {
            $shipping_company_country_city = $shipping_company_country->shipping_company_country_cities()->create([
                'city_id' => $shipping_city,
                'cash' => $cash == 1 ? 1 : 0,
                'calculation_type'=>$calculation_type

            ]);
            if ($cash == 1) {
                $shipping_company_country_city->shipping_company_cash_prices()->createMany($get_shipping_cash_prices);
            }
            $shipping_company_country_city->shipping_company_prices()->createMany($get_shipping_prices);

        }

        /*************************************************************************************/
        $shipping_company = $shipping_company_country->shipping_company;
        $this->add_action("add_shipping_company_city" ,'shipping_company_city', json_encode([
            'company_name_ar' =>  $shipping_company->name_ar,
            'company_name_en' =>  $shipping_company->name_en,
            'cities'          => implode(' - ' , $shipping_company_country->shipping_company_country_cities()->with('city')->get()->pluck('city.name')->toArray())
        ]));
        /*************************************************************************************/
        return general_response(true, true, trans('admin.success'), "", "", [
            'city_ids_not_in_shipping_company' => $this->get_city_ids_not_in_shipping_company($shipping_company_country )
        ]);


    }

    public function update(Request $request)
    {

        $id = $request->id;
        $shipping_company = ShippingCompanyCity::find($id);

        $get_shipping_cash_prices = [];
        $cash = $request->cash;
        $calculation_type = $request->calculation_type;

        $prices = json_decode($request->prices, true);
        $cash_prices = json_decode($request->cash_prices, true);


        if ($cash == 1) {
            $check_shipping_cash_value = $this->validation->check_shipping_cash_value($cash_prices);
            if (!$check_shipping_cash_value['status']) {
                return general_response(false, true, "", $check_shipping_cash_value['message'], "", []);
            }
            $get_shipping_cash_prices = $check_shipping_cash_value['data'];
        }




        if ($calculation_type == 'piece'){

             $check_shipping_prices = $this->validation->check_shipping_piece($prices);

            if (!$check_shipping_prices['status']) {

                return general_response(false, true, "", $check_shipping_prices['message'], "", []);
            }
        }elseif($calculation_type == 'price'){

            $check_shipping_prices = $this->validation->check_shipping_prices($prices);
            if (!$check_shipping_prices['status']) {
                return general_response(false, true, "", $check_shipping_prices['message'], "", []);
            }

        }
        $shipping_company->shipping_company_prices()->delete();


        $get_shipping_prices = $check_shipping_prices['data'];

        $shipping_company->update([
            'cash' => $cash == 1 ? 1 : 0,
            'calculation_type'=>$calculation_type
        ]);
        if ($cash == 1) {
            $shipping_company->shipping_company_cash_prices()->delete();
            $shipping_company->shipping_company_cash_prices()->createMany($get_shipping_cash_prices);
        }
        $shipping_company->shipping_company_prices()->createMany($get_shipping_prices);


        /*************************************************************************************/
        $shipping_company___ = $shipping_company->shipping_company_country->shipping_company;
        $this->add_action("update_shipping_company_city" ,'shipping_company_city', json_encode([
            'company_name_ar' =>  $shipping_company___->name_ar,
            'company_name_en' =>  $shipping_company___->name_en,
            'cities'          => $shipping_company->city->name_ar
        ]));
        /*************************************************************************************/

        return general_response(true, true, trans('admin.success'), "", "", []);


    }

    public function delete(Request $request)
    {
        $shipping_company = ShippingCompanyCity::find($request->id);

        try {
            if(OrderCompanyShipping::where('shipping_company_city_id' , '=' , $request->id)->exists()) {
                return general_response(false, true, "", trans('admin.cant_because_have_orders'), "", []);
            }
            $shipping_company_country = $shipping_company->shipping_company_country;
            $shipping_company->delete();

            /*************************************************************************************/
            $shipping_company___ = $shipping_company_country->shipping_company;
            $this->add_action("delete_shipping_company_city" ,'shipping_company_city', json_encode([
                'company_name_ar' =>  $shipping_company___->name_ar,
                'company_name_en' =>  $shipping_company___->name_en,
                'cities'          => $shipping_company->city->name_ar
            ]));
            /*************************************************************************************/

            return general_response(true, true, "", "", "", [
                'city_ids_not_in_shipping_company' => $this->get_city_ids_not_in_shipping_company($shipping_company_country )
            ]);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    // execute options
    public function execute_option(Request $request)
    {

        $shipping_city_ids = json_decode($request->shipping_city_ids);
        $option = $request->option;

        if (empty($shipping_city_ids) || count($shipping_city_ids) <= 0) {
            return general_response(false, true, "", trans('admin.please_select_cities'), "", [
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

        switch ($option) {
            case 1 :
                ShippingCompanyCity::whereIn('id' ,$shipping_city_ids )->update(['cash' => 1]);
                break;

            case 2 :
                ShippingCompanyCity::whereIn('id' ,$shipping_city_ids )->update(['cash' => 0]);
                break;

        }

        return general_response(true, true, trans('admin.success'), "", "", [
            'title' => trans('admin.done'),
            'order' => null
        ]);

    }


    public function get_shipping_company_cities_ajax(Request $request)
    {
        $shipping_company_country_id = $request->shipping_company_country_id;
        $shipping_company_cities_data = ShippingCompanyCity::select('*', 'shipping_company_cities.id as id')
            ->where('shipping_company_country_id', '=', $shipping_company_country_id)
            ->with(['city', 'shipping_company_prices', 'shipping_company_cash_prices']);

        return DataTables::of($shipping_company_cities_data)
            ->addColumn('options', function ($model) {
                return view('admin.shipping_company_cities.parts.options', ['id' => $model->id ,  'city_ar' => $model->city->name_ar])->render();

            })->addColumn('cash_status', function ($model) {
                return view('admin.shipping_company_cities.parts.cash_status', ['cash' => $model->cash ])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.shipping_company_cities.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }



    public function get_city_ids_not_in_shipping_company($shipping_company_country) {

        $city_ids_not_in_shipping_company = City::Active()->InCountry($shipping_company_country->country_id)
            ->NotInShippingCompanyCountry($shipping_company_country->id)
            ->pluck('id')->toArray();

        return $city_ids_not_in_shipping_company;
    }
}
