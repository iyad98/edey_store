<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\Neighborhood;

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

class NeighborhoodController extends HomeController
{


    public function __construct()
    {
        // $this->middleware('check_admin');
        parent::__construct();
        parent::$data['active_menu'] = 'neighborhoods';

    }


    public function index()
    {
        $cities = City::Active()->get();
        parent::$data['cities'] = $cities;
        return view('admin.neighborhoods.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('neighborhoods', 'name_ar')->whereNull('deleted_at')
            ],
            'name_en' => [
                'required',
                Rule::unique('neighborhoods', 'name_en')->whereNull('deleted_at')
            ],
            'city_id' => [
                'required',
                Rule::exists('cities', 'id')->whereNull('deleted_at')
            ],

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $name_ar = $request->name_ar;
            $name_en = $request->name_en;
            $city_id = $request->city_id;

            Neighborhood::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'city_id' => $city_id
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
                Rule::unique('neighborhoods', 'name_ar')->ignore($id)->whereNull('deleted_at')
            ],
            'name_en' => [
                'required',
                Rule::unique('neighborhoods', 'name_en')->ignore($id)->whereNull('deleted_at')
            ],
            'city_id' => [
                'required',
                Rule::exists('neighborhoods', 'id')->whereNull('deleted_at')
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $neighborhood = Neighborhood::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->name_en;
            $city_id = $request->city_id;

            $neighborhood->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'city_id' => $city_id
            ]);
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function delete(Request $request)
    {
        $neighborhood = Neighborhood::find($request->id);

        try {
            $neighborhood->delete();
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_neighborhoods_ajax(Request $request)
    {
        $city_id = $request->filled('city_id') ? $request->city_id : -1;

        $city_data = Neighborhood::leftJoin('cities', 'cities.id', '=', 'neighborhoods.city_id');
        if ($city_id != -1) {
            $city_data = $city_data->where('city_id', '=', $city_id);
        }
        $city_data = $city_data->select('neighborhoods.*', 'cities.name_ar as city_name');

        return DataTables::of($city_data)
            ->addColumn('actions', function ($model) {
                return view('admin.neighborhoods.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}
