<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Package;
use App\Models\Product;

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
use Illuminate\Support\Facades\File;

use Illuminate\Validation\Rule;

class PackageController extends HomeController
{


    public function __construct()
    {

        $this->middleware('check_role:view_packages|add_packages|edit_packages|delete_packages', ['only' => ['index']]);
        $this->middleware('check_role:add_packages', ['only' => ['store' ]]);
        $this->middleware('check_role:edit_packages', ['only' => ['update' ]]);
        $this->middleware('check_role:delete_packages', ['only' => ['delete' ]]);


        parent::__construct();

        parent::$data['route_name'] = trans('admin.packages');
        parent::$data['route_uri'] = route('admin.packages.index');

        parent::$data['active_menu'] = 'settings';
        parent::$data['sub_menu'] = 'packages';

    }


    public function index(Request $request)
    {

        return view('admin.packages.index', parent::$data);
    }

    public function store(Request $request)
    {

        try {
            $rules = [
                'name_ar' => [
                    'required',
                    Rule::unique('packages', 'name_ar')->whereNull('deleted_at')
                ],
                /* 'name_en' => [
                     'required',
                     Rule::unique('packages', 'name_en')->whereNull('deleted_at')
                 ],*/
                'price_from' => [
                    'required', 'numeric'
                ],
                'price_to' => [
                    'required', 'numeric' , 'gt:'. $request->price_from,
                ],
                'discount_rate' => [
                    'required', 'numeric' , 'min:0'
                ],
                'replace_hours' => [
                    'required', 'integer' , 'min:1'
                ],

            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->errors();
                $get_one_message = get_error_msg($rules, $messages);
                return general_response(false, true, "", $get_one_message, "", []);
            } else {


                $name_ar = $request->name_ar;
                $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
                $price_from = $request->price_from;
                $price_to = $request->price_to;
                $discount_rate = $request->discount_rate;
                $replace_hours = $request->replace_hours;
                $free_shipping = (int)$request->free_shipping;

                if ($request->hasFile('image')) {
                    $path = (new StoreFile($request->image))->store_local('packages');
                } else {
                    $path = get_default_image();
                }
                Package::create([
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'price_from' => $price_from,
                    'price_to' => $price_to,
                    'discount_rate' => $discount_rate,
                    'replace_hours' => $replace_hours,
                    'free_shipping' => $free_shipping,
                    'image' => $path,
                ]);
                return general_response(true, true, trans('admin.success'), "", "", []);


            }
        } catch (\Exception $e) {
            return general_response(false, true, $e->getMessage(), $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, $e->getMessage(), $e->getMessage(), "", []);

        }
    }

    public function update(Request $request , $id)
    {

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('packages', 'name_ar')->ignore($id)->whereNull('deleted_at')
            ],
            /* 'name_en' => [
                 'required',
                 Rule::unique('packages', 'name_en')->ignore($id)->whereNull('deleted_at')
             ],*/
            'price_from' => [
                'required', 'numeric'
            ],
            'price_to' => [
                'required', 'numeric' , 'gt:'.$request->price_from  ,
            ],
            'discount_rate' => [
                'required', 'numeric' , 'min:0'
            ],
            'replace_hours' => [
                'required', 'integer' , 'min:1'
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $package = Package::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $price_from = $request->price_from;
            $price_to = $request->price_to;
            $discount_rate = $request->discount_rate;
            $replace_hours = $request->replace_hours;
            $free_shipping = (int)$request->free_shipping;

            if ($request->hasFile('image')) {
                if ($package->getOriginal('image') != get_default_image()) {
                    File::delete(public_path() . "/uploads/packages/" . $package->getOriginal('image'));
                }
                $path = (new StoreFile($request->image))->store_local('packages');
            } else {
                $path = $package->getOriginal('image');
            }

            $package->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'price_from' => $price_from,
                'price_to' => $price_to,
                'discount_rate' => $discount_rate,
                'replace_hours' => $replace_hours,
                'free_shipping' => $free_shipping,
                'image' => $path,
            ]);
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function destroy($id)
    {
        $package = Package::find($id);

        try {
            $package->delete();
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_packages_ajax(Request $request)
    {

        $packages = Package::select('*');
        return DataTables::of($packages)
            ->editColumn('show_image', function ($model) {
                return view('admin.packages.parts.image', ['image' => $model->image])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.packages.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}
