<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ActionLog;

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

class BrandController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_brands|add_brands|edit_brands|delete_brands', ['only' => ['index']]);
        $this->middleware('check_role:add_brands', ['only' => ['store']]);
        $this->middleware('check_role:edit_brands', ['only' => ['update']]);
        $this->middleware('check_role:delete_brands', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.brands');
        parent::$data['route_uri'] = route('admin.brands.index');

        parent::$data['active_menu'] = 'brands';

    }


    public function index(Request $request)
    {

        return view('admin.brands.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('brands', 'name_ar')->whereNull('deleted_at')
            ],
           /* 'name_en' => [
                'required',
                Rule::unique('brands', 'name_en')->whereNull('deleted_at')
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


            $path = $this->store_file_service($request->image , 'brands' , null , null ,true , false);

            $brand = Brand::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'slug_ar' => get_slug($name_ar),
                'slug_en' => get_slug($name_en),
                'image' => $path,
            ]);
            $this->add_action("add_brand" ,'brand', json_encode($brand));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }

    }

    public function update(Request $request)
    {

        $id = $request->id;

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('brands', 'name_ar')->ignore($id)->whereNull('deleted_at')
            ],
          /*  'name_en' => [
                'required',
                Rule::unique('brands', 'name_en')->ignore($id)->whereNull('deleted_at')
            ],*/

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $brand = Brand::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $path = $this->store_file_service($request->image, 'brands', $brand, 'image', false , false);

            $brand->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'slug_ar' => get_slug($name_ar),
                'slug_en' => get_slug($name_en),
                'image' => $path,
            ]);
            $this->add_action("update_brand",'brand', json_encode($brand));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function delete(Request $request)
    {
        $brand = Brand::find($request->id);

        try {
            if($brand->products()->count() > 0) {
                return general_response(false, true, "", trans('admin.cant_delete_because_have_products'), "", []);
            }
            $this->decrement_num_used_gallery($brand);
            $brand->delete();
            $this->add_action("delete_brand",'brand' , json_encode($brand));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_brands_ajax(Request $request)
    {

        $brands = Brand::select('*');
        return DataTables::of($brands)
            ->editColumn('show_image', function ($model) {
                return view('admin.brands.parts.image', ['image' => $model->image])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.brands.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}
