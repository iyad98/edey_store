<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\Filter;
use App\Models\PaymentMethod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\FilterData;


/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;

use Illuminate\Validation\Rule;

class CountryController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_countries|add_countries|edit_countries|delete_countries', ['only' => ['index']]);
        $this->middleware('check_role:add_countries', ['only' => ['store']]);
        $this->middleware('check_role:edit_countries', ['only' => ['update']]);
        $this->middleware('check_role:delete_countries', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.countries');
        parent::$data['route_uri'] = route('admin.countries.index');
        parent::$data['active_menu'] = 'settings';
        parent::$data['sub_menu'] = 'countries';

    }


    public function index()
    {
        $payment_methods = PaymentMethod::all();
        parent::$data['payment_methods'] = $payment_methods;
        return view('admin.countries.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('cities', 'name_ar')->whereNull('deleted_at')
            ],
            'country_id' => [
                'required' , Rule::exists('countries', 'id')->whereNull('deleted_at')
            ]
            /*  'name_en' => [
                  'required',
                  Rule::unique('cities', 'name_en')->whereNull('deleted_at')
              ],*/

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $country_id = $request->country_id;
            City::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'country_id' => $country_id
            ]);
            return general_response(true, true, trans('admin.success'), "", "", []);
        }

    }

    public function update(Request $request)
    {

        $id = $request->id;

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('countries', 'name_ar')->ignore($id)->whereNull('deleted_at')
            ],
            /*  'name_en' => [
                  'required',
                  Rule::unique('cities', 'name_en')->ignore($id)->whereNull('deleted_at')
              ],*/
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $country = Country::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $payment_methods = $request->payment_methods != "" ? explode(",", $request->payment_methods) : [];

            if ($request->hasFile('flag')) {
                $path = (new StoreFile($request->flag))->store_local('countries');
            } else {
                $path = $country->getOriginal('flag');
            }

            $country->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'flag' => $path
            ]);
            $country->payment_methods()->sync($payment_methods);
            $this->add_action("update_country" ,'country', json_encode($country));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    // execute options
    public function execute_option(Request $request)
    {


        $country_ids = json_decode($request->country_ids);
        $option = $request->option;

        if (empty($country_ids) || count($country_ids) <= 0) {
            return general_response(false, true, "", trans('admin.please_select_countries'), "", [
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
        $to_status = status_user()[$option]['title'];
        Country::whereIn('id', $country_ids)->update([
            'status' => $option
        ]);
        $this->add_action("change_status_country" ,'country', json_encode([
            'countries'    => implode(" , " , Country::whereIn('id', $country_ids)->pluck('name_ar')->toArray()) ,
            'to_status' => $to_status
        ]));
        return general_response(true, true, trans('admin.success'), "", "", [
            'title' => trans('admin.done'),
            'order' => null
        ]);

    }

    
    public function get_countries_ajax(Request $request)
    {
        $city_data = Country::leftJoin('currencies' , 'currencies.id' , '=' , 'countries.currency_id')
            ->select('countries.*' , 'currencies.symbol_ar as currency_symbol')
            ->with('payment_methods');

        return DataTables::of($city_data)
            ->addColumn('options', function ($model) {
                return view('admin.countries.parts.options', ['id' => $model->id])->render();
            })
            ->editColumn('show_image', function ($model) {
                return view('admin.countries.parts.image', ['image' => $model->flag])->render();
            })
            ->addColumn('show_status', function ($model) {
                return view('admin.countries.parts.status', ['status' => $model->status])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.countries.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}
