<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\Neighborhood;
use App\Models\Category;

use App\Models\AppHome;
use App\Models\WebsiteHome;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
/*  Models */

use App\Models\FilterData;
use App\Models\Banner;

/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;

use Illuminate\Validation\Rule;
// jobs
use App\Jobs\UpdateCategoriesBannersAppJob;

class BannerController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_banners|add_banners|edit_banners|delete_banners', ['only' => ['index']]);
        $this->middleware('check_role:add_banners', ['only' => ['store' , 'store_banner_value']]);
        $this->middleware('check_role:edit_banners', ['only' => ['update' ,'change_status' , 'update_banner_value']]);
        $this->middleware('check_role:delete_banners', ['only' => ['delete' , 'delete_banner_value']]);

        parent::__construct();
        parent::$data['active_menu'] = 'banners';
        parent::$data['route_name'] = trans('admin.banners');
        parent::$data['route_uri'] = route('admin.banners.index');

    }


    public function index(Request $request)
    {
       
        if ($request->filled('banner_id')) {
            $banner = Banner::find($request->banner_id);
            $categories = Category::all();

            parent::$data['categories'] = $categories;
            parent::$data['banner'] = $banner;

            return view('admin.banners.banner_values', parent::$data);

        } else {
            return view('admin.banners.index', parent::$data);
        }

    }

    public function store(Request $request)
    {

        $rules = [
            'name_ar' => [
                'required',
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

            $banner = Banner::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'category_id' => null,
                'parent_id' => null,
                'image' => null
            ]);
            $this->add_action("add_banner" ,'banner', json_encode($banner));

            return general_response(true, true, trans('admin.success'), "", "", [
                'banners' => $this->get_home_banners()
            ]);
        }


    }

    public function update(Request $request)
    {

        $id = $request->id;
        $parent_id = $request->parent_id;

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('neighborhoods', 'name_ar')->ignore($id)->whereNull('deleted_at')
            ],

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $banner = banner::find($id);


            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;


            $banner->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
            ]);
            $this->add_action("update_banner" ,'banner', json_encode($banner));
            // update update categories banners app
//            $update_categories_banners_app = (new UpdateCategoriesBannersAppJob());
//            dispatch($update_categories_banners_app);

            return general_response(true, true, trans('admin.success'), "", "", [
                'banners' => $this->get_home_banners()
            ]);
        }
    }

    public function change_status(Request $request)
    {
        $banner = banner::find($request->id);
        $from_status = status_user()[$banner->status]['title'];
        if ($banner->status == 1) {
            $banner->status = 0;
        } else {
            $banner->status = 1;
        }
        $banner->update();

        if (is_null($banner->parent_id)) {
            $banner->children()->update([
                'status' => $banner->status
            ]);
        } else {
            $parent = $banner->parent;
            if ($banner->status == 1) {
                $parent->status = 1;
            } else {
                if (!$parent->children()->where('status', '=', 1)->exists()) {
                    $parent->status = 0;
                }
            }
            $parent->update();
        }
        $to_status = status_user()[$banner->status]['title'];
        /********************************************************************/
        $banner->from_status = $from_status;
        $banner->to_status = $to_status;
        if(is_null($banner->parent_id)) {
            $this->add_action("change_status_banner" ,'banner', json_encode($banner));
        }else {
            $this->add_action("change_status_banner_value" ,'banner', json_encode($banner->load('parent')));
        }

        /********************************************************************/
        return general_response(true, true, "", "", "", []);

    }

    public function delete(Request $request)
    {
        $banner = banner::find($request->id);

        try {
            $children = $banner->children;
            foreach ($children as $child) {
                $this->decrement_num_used_gallery($child);
                $child->delete();
            }

            AppHome::where('type_id' ,'=' , $banner->id )->where('type' , '=' ,2 )->delete();
            WebsiteHome::where('type_id' , '=' , $banner->id)->where('type' , '=' , 2)->delete();

            $banner->delete();
            $this->add_action("delete_banner" ,'banner', json_encode($banner));
            return general_response(true, true, "", "", "", [
                'banners' => $this->get_home_banners()
            ]);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    /************************************/
    public function store_banner_value(Request $request)
    {

        try {
            $parent_id = $request->parent_id;
            $select_pointer = $request->select_pointer;

            $rules = [
                'name_ar' => [
                    'required',
                ],
            ];

            if ($parent_id != -1 && $select_pointer == 1) {
                $rules['category_id'] = [
                    'required',
                    Rule::exists('categories', 'id')->whereNull('deleted_at')
                ];
            } else if ($parent_id != -1 && $select_pointer == 2) {
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


                $path_ar = $this->store_file_service($request->image_ar , 'banners' , null , null ,true);
                $path_en = $this->store_file_service($request->image_en , 'banners' , null , null ,true);
                $path_website_ar = $this->store_file_service($request->image_website_ar , 'banners' , null , null ,true);
                $path_website_en = $this->store_file_service($request->image_website_en , 'banners' , null , null ,true);


                $banner = Banner::create([
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'category_id' => $parent_id != -1 && $select_pointer == 1 ? $category_id : null,
                    'product_id' => $parent_id != -1 && $select_pointer == 2 ? $product_id : null,
                    'parent_id' => $parent_id == -1 ? null : $parent_id,
                    'image_ar' => $path_ar ,
                    'image_en' => $path_en ,
                    'image_website_ar' => $path_website_ar ,
                    'image_website_en' => $path_website_en ,
                ]);
                /***********************************************************************/
                $this->add_action("add_banner_value" ,'banner', json_encode($banner->load('parent')));
                /************************************************************************/
                return general_response(true, true, trans('admin.success'), "", "", []);
            }
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }


    }

    public function update_banner_value(Request $request)
    {

        try {
            $id = $request->id;
            $parent_id = $request->parent_id;
            $select_pointer = $request->select_pointer;

            $rules = [
                'name_ar' => [
                    'required',
                ],
            ];
            if ($parent_id != -1 && $select_pointer == 1) {
                $rules['category_id'] = [
                    'required',
                    Rule::exists('categories', 'id')->whereNull('deleted_at')
                ];
            } else if ($parent_id != -1 && $select_pointer == 2) {
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

                $banner = Banner::find($id);

                $name_ar = $request->name_ar;
                $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
                $category_id = $request->category_id;
                $product_id = $request->product_id;
                $parent_id = $request->parent_id;

                $path_ar = $this->store_file_service($request->image_ar, 'banners', $banner, 'image_ar', false);
                $path_en = $this->store_file_service($request->image_en, 'banners', $banner, 'image_en', false);
                $path_website_ar = $this->store_file_service($request->image_website_ar, 'banners', $banner, 'image_website_ar', false);
                $path_website_en = $this->store_file_service($request->image_website_en, 'banners', $banner, 'image_website_en', false);

                $banner->update([
                    'name_ar' => $name_ar,
                    'name_en' => $name_en,
                    'category_id' => $parent_id != -1 && $select_pointer == 1 ? $category_id : null,
                    'product_id' => $parent_id != -1 && $select_pointer == 2 ? $product_id : null,
                    'image_ar' => $path_ar ,
                    'image_en' => $path_en ,
                    'image_website_ar' => $path_website_ar ,
                    'image_website_en' => $path_website_en ,
                    'parent_id' => $parent_id == -1 ? null : $parent_id,
                ]);


                /***********************************************************************/
                $this->add_action("update_banner_value" ,'banner', json_encode($banner->load('parent')));
                /************************************************************************/

                return general_response(true, true, trans('admin.success'), "", "", []);
            }
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }

    }

    public function delete_banner_value(Request $request)
    {
        $banner = Banner::find($request->id);
        $copy_banner = clone $banner;
        try {
            $copy_banner->load('parent');

            $this->decrement_num_used_gallery($banner);
            $banner->delete();

            /***********************************************************************/
            $this->add_action("delete_banner_value" ,'banner', json_encode($copy_banner));
            /************************************************************************/
            return general_response(true, true, "", "", "", [
                'banners' => $this->get_home_banners()
            ]);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }


    public function get_banners_ajax(Request $request)
    {

        $banners = Banner::withCount('children')->Parents();

        return DataTables::of($banners)
            ->addColumn('display_name_en', function ($model) {
                return view('admin.banners.parts.show_banner', ['id' => $model->id, 'name' => $model->name_en])->render();

            })->addColumn('display_name_ar', function ($model) {
                return view('admin.banners.parts.show_banner', ['id' => $model->id, 'name' => $model->name_ar])->render();

            })->editColumn('status', function ($model) {
                if (is_null($model->parent_id)) {
                    return view('admin.banners.parts.status', ['status' => $model->status])->render();
                } else {
                    return "";
                }

            })->addColumn('type', function ($model) {
                return view('admin.banners.parts.type', ['children_count' => $model->children_count])->render();

            })
            ->addColumn('actions', function ($model) {
                return view('admin.banners.parts.actions', ['id' => $model->id, 'parent_id' => $model->parent_id])->render();
            })->escapeColumns(['*'])->make(true);
    }

    public function get_banner_values_ajax(Request $request)
    {

        $parent_id = $request->parent_id;
        $banners = Banner::where('banners.parent_id', '=',$parent_id)
            ->leftJoin('categories', 'categories.id', '=', 'banners.category_id')
            ->leftJoin('products', 'products.id', '=', 'banners.product_id')
            ->select('banners.*', 'categories.name_ar as category_name', 'products.name_ar as product_name');

        return DataTables::of($banners)
            ->editColumn('show_image', function ($model) {
                return view('admin.banners.parts.image', ['image' => $model->image])->render();

            }) ->editColumn('show_image_web', function ($model) {
                return view('admin.banners.parts.image', ['image' => $model->image_website])->render();

            })->editColumn('status', function ($model) {
                return view('admin.banners.parts.status', ['status' => $model->status])->render();

            })->addColumn('pointer', function ($model) {
                if (is_null($model->category_id) && is_null($model->product_id)) {
                    $pointer = "";
                    $pointer_type = "";
                } else if (!is_null($model->category_id)) {
                    $pointer = $model->category_name;
                    $pointer_type = trans('admin.category');
                } else {
                    $pointer = $model->product_name;
                    $pointer_type = trans('admin.product');
                }
                return view('admin.banners.parts.pointer', ['pointer' => $pointer, 'pointer_type' => $pointer_type])->render();

            })
            ->addColumn('actions', function ($model) {
                return view('admin.banners.parts.actions', ['id' => $model->id, 'parent_id' => $model->parent_id])->render();
            })->escapeColumns(['*'])->make(true);
    }


    public function get_home_banners()
    {
        return Banner::Parents()->get();
    }
}
