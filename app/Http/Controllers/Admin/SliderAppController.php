<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\Neighborhood;
use App\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
/*  Models */

use App\Models\FilterData;
use App\Models\Slider;

/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;

use Illuminate\Validation\Rule;

class SliderAppController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_application');


        parent::__construct();
        parent::$data['active_menu'] = 'app';
        parent::$data['route_name'] = trans('admin.sliders');
        parent::$data['route_uri'] = route('admin.sliders.index');
        parent::$data['sub_menu'] = 'sliders';
    }


    public function index()
    {

        $sliders = $this->get_home_sliders();
        $categories = Category::all();

        parent::$data['categories'] = $categories;
        parent::$data['sliders'] = $sliders;

        return view('admin.sliders.index', parent::$data);
    }

    public function store(Request $request)
    {

        $parent_id = $request->parent_id;
        $select_pointer = $request->select_pointer;
        $rules = [
            'name_ar' => [
                'required',
            ],

        ];
        if($parent_id != -1 && $select_pointer == 1) {
            $rules['category_id'] = [
                'required',
                Rule::exists('categories', 'id')->whereNull('deleted_at')
            ];
        }else if($parent_id != -1 && $select_pointer == 2) {
            $rules['product_id'] = [
                'required',
                Rule::exists('products', 'id')->whereNull('deleted_at')
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $category_id = $request->category_id;
            $product_id = $request->product_id;


            $path_ar = $this->store_file_service($request->image_ar , 'sliders' , null , null ,true);
            $path_en = $this->store_file_service($request->image_en , 'sliders' , null , null ,true);
            $path_website_ar = $this->store_file_service($request->image_website_ar , 'sliders' , null , null ,true);
            $path_website_en = $this->store_file_service($request->image_website_en , 'sliders' , null , null ,true);


            $slider = Slider::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'category_id' => $parent_id != -1 && $select_pointer == 1 ?$category_id :  null  ,
                'product_id' => $parent_id != -1 && $select_pointer == 2 ? $product_id : null  ,
                'parent_id' => $parent_id == -1 ? null : $parent_id,
                'image_ar' => $path_ar ,
                'image_en' => $path_en ,
                'image_website_ar' => $path_website_ar ,
                'image_website_en' => $path_website_en ,
            ]);
            $this->add_action("add_slider" ,'slider', json_encode($slider));

            return general_response(true, true, trans('admin.success'), "", "", [
                'sliders' => $this->get_home_sliders()
            ]);
        }


    }

    public function update(Request $request)
    {

        try {
            $id = $request->id;
            $parent_id = $request->parent_id;
            $select_pointer = $request->select_pointer;

            $rules = [
                'name_ar' => [
                    'required',
                    Rule::unique('neighborhoods', 'name_ar')->ignore($id)->whereNull('deleted_at')
                ],
            ];
            if($parent_id != -1 && $select_pointer == 1) {
                $rules['category_id'] = [
                    'required',
                    Rule::exists('categories', 'id')->whereNull('deleted_at')
                ];
            }else if($parent_id != -1 && $select_pointer == 2) {
                $rules['product_id'] = [
                    'required',
                    Rule::exists('products', 'id')->whereNull('deleted_at')
                ];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->errors();
                $get_one_message = get_error_msg($rules, $messages);
                return general_response(false, true, "", $get_one_message, "", []);
            } else {
                $slider = Slider::find($id);

                $path_ar = $this->store_file_service($request->image_ar, 'sliders', $slider, 'image_ar', false);
                $path_en = $this->store_file_service($request->image_en, 'sliders', $slider, 'image_en', false);
                $path_website_ar = $this->store_file_service($request->image_website_ar, 'sliders', $slider, 'image_website_ar', false);
                $path_website_en = $this->store_file_service($request->image_website_en, 'sliders', $slider, 'image_website_en', false);



                $name_ar = $request->name_ar;
                $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
                $category_id = $request->category_id;
                $product_id = $request->product_id;
                $parent_id = $request->parent_id;

                $slider->update([
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'category_id' => $parent_id != -1 && $select_pointer == 1 ?$category_id :  null  ,
                    'product_id' => $parent_id != -1 && $select_pointer == 2 ? $product_id : null  ,
                    'image_ar' => $path_ar ,
                    'image_en' => $path_en ,
                    'image_website_ar' => $path_website_ar ,
                    'image_website_en' => $path_website_en ,
                    'parent_id' => $parent_id == -1 ? null : $parent_id,
                ]);
                $this->add_action("update_slider" ,'slider', json_encode($slider));
                return general_response(true, true, trans('admin.success'), "", "", [
                    'sliders' => $this->get_home_sliders()
                ]);
            }
        }catch (\Exception $e) {
            return general_response(false, true, $e->getMessage(), "", "", []);
        }catch (\Error $e) {
            return general_response(false, true, $e->getMessage(), "", "", []);
        }

    }

    public function change_status(Request $request)
    {
        $slider = Slider::find($request->id);
        $slider_copy = clone $slider;
        $from_status = status_user()[$slider->status]['title'];

        if ($slider->status == 1) {
            $slider->status = 0;
        } else {
            $slider->status = 1;
        }
        $slider->update();

        if(is_null($slider->parent_id)) {
            $slider->children()->update([
                'status' => $slider->status
            ]);
        }else {
            $parent = $slider->parent;
            if($slider->status == 1) {
                $parent->status = 1;
            }else {
                if(!$parent->children()->where('status' , '=' , 1)->exists()) {
                    $parent->status = 0;
                }
            }
            $parent->update();
        }
        $to_status = status_user()[$slider->status]['title'];
        /********************************************************************/
        $slider_copy->from_status = $from_status;
        $slider_copy->to_status = $to_status;
        $this->add_action("change_status_slider" ,'slider', json_encode($slider_copy));
        /********************************************************************/
        return general_response(true, true, "", "", "", []);

    }

    public function delete(Request $request)
    {
        $slider = Slider::find($request->id);

        try {
            $this->decrement_num_used_gallery($slider);
            $slider->delete();
            $this->add_action("delete_slider" ,'slider', json_encode($slider));
            return general_response(true, true, "", "", "", [
                'sliders' => $this->get_home_sliders()
            ]);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_sliders_ajax(Request $request)
    {

        $slider_id = $request->filled('slider_id') ? $request->slider_id : -1;
        $category_id = $request->filled('category_id') ? $request->category_id : -1;

        $category_data = Slider::with(['children', 'parent'])
            ->leftJoin('categories', 'categories.id', '=', 'sliders.category_id')
            ->leftJoin('products', 'products.id', '=', 'sliders.product_id');

        if ($slider_id != -1) {
            $category_data->where('sliders.parent_id', '=', $slider_id);
        } else {
            $category_data = $category_data->whereNull('parent_id');
        }

        if ($category_id != -1) {
            $category_data->where('sliders.category_id', '=', $category_id);
        }

        $category_data = $category_data->select('sliders.*', 'categories.name_ar as category_name' , 'products.name_ar as product_name');

        return DataTables::of($category_data)
            ->editColumn('show_image', function ($model) {
                return view('admin.sliders.parts.image', ['image' => $model->image])->render();

            })->editColumn('show_image_web', function ($model) {
                return view('admin.sliders.parts.image', ['image' => $model->image_website])->render();

            })->addColumn('display_name_en', function ($model) {
                if ($model->children->count() > 0) {
                    return view('admin.sliders.parts.show_slider', ['id' => $model->id, 'name' => $model->name_en])->render();
                } else {
                    return $model->name_en;
                }
            })->addColumn('display_name_ar', function ($model) {
                if ($model->children->count() > 0) {
                    return view('admin.sliders.parts.show_slider', ['id' => $model->id, 'name' => $model->name_ar])->render();
                } else {
                    return $model->name_ar;
                }
            })->addColumn('pointer', function ($model) {
                if(is_null($model->category_id) && is_null($model->product_id)) {
                    $pointer = "";
                    $pointer_type = "";
                }else if(!is_null($model->category_id)) {
                    $pointer = $model->category_name;
                    $pointer_type = trans('admin.category');
                }else {
                    $pointer = $model->product_name;
                    $pointer_type = trans('admin.product');
                }
                return view('admin.sliders.parts.pointer', ['pointer' => $pointer , 'pointer_type' => $pointer_type])->render();

            })
            ->editColumn('status', function ($model) {
                return view('admin.sliders.parts.status', ['status' => $model->status])->render();

            })
            ->addColumn('actions', function ($model) {
                return view('admin.sliders.parts.actions', ['id' => $model->id , 'parent_id' => $model->parent_id])->render();
            })->escapeColumns(['*'])->make(true);
    }


    public function get_home_sliders()
    {
        return Slider::Parents()->get();
    }
}
