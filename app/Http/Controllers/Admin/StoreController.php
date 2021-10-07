<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Filter;
use App\Models\FilterData;
use App\Models\Store;
use App\Services\Firestore;
use App\Services\StoreFile;
use App\Validations\StoreValidation;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

/*  Models */


/* service */

class StoreController extends HomeController
{


    public function __construct(StoreValidation $validation)
    {
        $this->middleware('check_role:view_stores|add_stores|edit_stores|delete_stores', ['only' => ['index']]);
        $this->middleware('check_role:add_stores', ['only' => ['store']]);
        $this->middleware('check_role:edit_stores', ['only' => ['update']]);
        $this->middleware('check_role:delete_stores', ['only' => ['delete']]);
        parent::__construct();
        $this->validation = $validation;


        parent::$data['route_name'] = trans('admin.stores');
        parent::$data['route_uri'] = route('admin.stores.index');
        parent::$data['active_menu'] = 'stores';
        parent::$data['sub_menu'] = 'cities';

    }


    public function index()
    {
        parent::$data['cities'] = City::Active()->where('country_id' , '=' , 194)->get();
        return view('admin.stores.index', parent::$data);
    }

    public function store(Request $request)
    {
        $check_public_data = $this->validation->check_store_data($request->all());
        if (!$check_public_data['status']) {
            return general_response(false, true, "", $check_public_data['message'], "", []);
        } else {
            $name_ar = $request->name_ar;
            $name_en = $request->name_en;
            $address_ar = $request->address_ar;
            $address_en = $request->address_en;
            $lat = $request->lat;
            $lng = $request->lng;
            $phone = $request->phone;
            $city_id = $request->city_id;

//            if ($request->hasFile('image')) {
//                $path = (new StoreFile($request->image))->store_local('stores');
//            } else {
//                $path = get_default_image();
//            }

            $store = Store::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'address_ar' => $address_ar,
                'address_en' => $address_en,
                'lat' => $lat,
                'lng' => $lng,
                'phone' => $phone,
                'city_id' => $city_id,
                // 'image' => $path,

            ]);
            $this->add_action("add_store" ,"store", json_encode($store));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function update(Request $request)
    {

        $id = $request->id;
        $store = Store::find($id);
        $check_public_data = $this->validation->check_store_data($request->all());
        if (!$check_public_data['status']) {
            return general_response(false, true, "", $check_public_data['message'], "", []);
        } else {
            $name_ar = $request->name_ar;
            $name_en = $request->name_en;
            $address_ar = $request->address_ar;
            $address_en = $request->address_en;
            $lat = $request->lat;
            $lng = $request->lng;
            $phone = $request->phone;
            $city_id = $request->city_id;

//            if ($request->hasFile('image')) {
//                $path = (new StoreFile($request->image))->store_local('stores');
//            } else {
//                $path = $store->getOriginal('image');
//            }

            $store->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'address_ar' => $address_ar,
                'address_en' => $address_en,
                'lat' => $lat,
                'lng' => $lng,
                'phone' => $phone,
                'city_id' => $city_id,

                //'image' => $path,
            ]);
            $this->add_action("update_store","store" , json_encode($store));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function destroy(Request $request, $id)
    {
        $store = Store::find($id);

        try {
            $store->delete();
            $this->add_action("delete_store" ,"store", json_encode($store));

            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    //

    public function get_stores_ajax(Request $request)
    {
        $city_data = Store::with('city');
        return DataTables::of($city_data)
            ->addColumn('actions', function ($model) {
                return view('admin.stores.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}
