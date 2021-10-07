<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\Filter;
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

class CityController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_cities|add_cities|edit_cities|delete_cities', ['only' => ['index']]);
        $this->middleware('check_role:add_cities', ['only' => ['store']]);
        $this->middleware('check_role:edit_cities', ['only' => ['update']]);
        $this->middleware('check_role:delete_cities', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.cities');
        parent::$data['route_uri'] = route('admin.cities.index');
        parent::$data['active_menu'] = 'settings';
        parent::$data['sub_menu'] = 'cities';

    }


    public function index()
    {
        /*
        $cities = public_path() . "/cities.json";
        $get_cities = json_decode(file_get_contents($cities), true);

        foreach ($get_cities as $city) {

            $country = null;
            if (array_key_exists('country_ar', $city)) {
                $country = Country::where('name_ar', '=', $city['country_ar'])->first();
            }

            if (array_key_exists('city_ar', $city) && array_key_exists('city_en', $city)) {
                $city_ = City::where('name_ar', '=', $city['city_ar'])->first();
                if (!$city_ && $country) {
                    $insert_cities[] = [
                        'name_ar' => $city['city_ar'],
                        'name_en' => $city['city_en'],
                        'country_id' => $country->id,
                        'status' => 1
                    ];
                }

            }

        }

        City::insert($insert_cities);
        return "done";
        */
        $countries = Country::Active()->get();

        parent::$data['countries'] = $countries;
        return view('admin.cities.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('cities', 'name_ar')->whereNull('deleted_at')
            ],
            'country_id' => [
                'required', Rule::exists('countries', 'id')->whereNull('deleted_at')
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
            $city = City::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'country_id' => $country_id
            ]);
            $this->add_action("add_city" ,'city', json_encode($city));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }

    }

    public function update(Request $request)
    {

        $id = $request->id;

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('cities', 'name_ar')->ignore($id)->whereNull('deleted_at')
            ],
            'country_id' => [
                'required', Rule::exists('countries', 'id')->whereNull('deleted_at')
            ]
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
            $city = City::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $country_id = $request->country_id;


            $city->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'country_id' => $country_id
            ]);
            $this->add_action("update_city" ,'city', json_encode($city));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function delete(Request $request)
    {
        $city = City::find($request->id);
        if($city->order_shipping()->count() > 0) {
            return general_response(false, true, "", trans('admin.cant_because_have_orders'), "", []);
        }

        try {
            $city->delete();
            $this->add_action("delete_city" ,'city', json_encode($city));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    // execute options
    public function execute_option(Request $request)
    {


        $city_ids = json_decode($request->city_ids);
        $option = $request->option;

        if (empty($city_ids) || count($city_ids) <= 0) {
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
        $to_status = status_user()[$option]['title'];
        City::whereIn('id', $city_ids)->update([
            'status' => $option
        ]);

        $this->add_action("change_status_city" ,'city', json_encode([
            'cities'    => implode(" , " , City::whereIn('id', $city_ids)->pluck('name_ar')->toArray()) ,
            'to_status' => $to_status
        ]));
        return general_response(true, true, trans('admin.success'), "", "", [
            'title' => trans('admin.done'),
            'order' => null
        ]);

    }


    public function get_cities_ajax(Request $request)
    {
        $city_data = City::leftJoin('countries', 'countries.id', '=', 'cities.country_id')
            ->select('cities.*', 'countries.name_ar as country_name');
        return DataTables::of($city_data)
            ->addColumn('options', function ($model) {
                return view('admin.cities.parts.options', ['id' => $model->id])->render();
            })
            ->addColumn('show_status', function ($model) {
                return view('admin.cities.parts.status', ['status' => $model->status])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.cities.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


    public function get_city_by_country_id($country_id) {
        $cities = City::Active()->where('country_id' , '=' , $country_id)->get();
        return response()->json($cities);
    }
}
