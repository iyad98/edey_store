<?php

namespace App\Http\Controllers\Admin;


use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Widget;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;

// models
use App\User;
use App\Models\Banner;
use App\Models\WebsiteHome;
use App\Models\Setting;
use App\Models\WebsiteTopBanner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Services\StoreFile;
use Illuminate\Validation\Rule;

use App\Http\Resources\CategoryDataResourceDFT;

// jobs
use App\Jobs\UpdateCategoriesBannersAppJob;


class WebsiteHomeController extends HomeController
{

    public $category;

    public function __construct(CategoryRepository $category)
    {

        $this->middleware('check_role:view_website');
        
        parent::__construct();
        parent::$data['active_menu'] = 'website';
        parent::$data['sub_menu'] = 'website_home';
        parent::$data['route_name'] = trans('admin.website_home');
        parent::$data['route_uri'] = route('admin.website-home.index');

        $this->category = $category;
    }


    // app
    public function website_home()
    {
        $app_home = WebsiteHome::with('banner')->get();
        $website_note = WebsiteTopBanner::leftJoin('products', 'products.id', '=', 'website_top_banner.product_id')
            ->select('website_top_banner.*' , 'products.name_ar as product_name' , 'products.id as product_id')->first();

        $website_note_text_first = WebsiteTopBanner::leftJoin('products', 'products.id', '=', 'website_top_banner.product_id')
            ->select('website_top_banner.*' , 'products.name_ar as product_name' , 'products.id as product_id')->find(2);


        $website_note_text_second = WebsiteTopBanner::leftJoin('products', 'products.id', '=', 'website_top_banner.product_id')
            ->select('website_top_banner.*' , 'products.name_ar as product_name' , 'products.id as product_id')->find(3);



        $app_home_data = [];

        $categories_with_parent = get_all_category_with_parents();
        foreach ($app_home as $type) {

            switch ($type->type) {
                case 1 :
                    $category = $categories_with_parent->where('id', '=', $type->type_id)->first();
                    $name = $category->category_with_parents_text;
                    break;
                case 5 :
                    $name = trans('api.latest_product');
                    break;
                case 6 :
                    $name = trans('api.most_sales_products');
                    break;
                default :
                    $name = $type->banner ? $type->banner->name : "";
                    break;
            }
            $app_home_data[] = [
                'id' => $type->type_id,
                'name' => $name,
                'name_ar' => $type->name_ar,
                'name_en' => $type->name_en,
                'in_home_order' => $type->order,
                'type' => $type->type,
                'product_counts' => $type->product_counts,
            ];
        }


        $app_home_banner_categories = collect($app_home_data)->sortBy('in_home_order')->values();
        $sidebar_categories = $categories_with_parent->where('in_website_sidebar', '=', 1)->sortBy('in_website_sidebar_order')->values();
        $banners = Banner::Parents()->get();


        parent::$data['categories'] = $categories_with_parent;
        parent::$data['app_home_banner_categories'] = json_encode($app_home_banner_categories);
        parent::$data['sidebar_categories'] = json_encode($sidebar_categories);

        parent::$data['banners'] = $banners;

        parent::$data['website_note'] = $website_note;
        parent::$data['website_note_text_first'] = $website_note_text_first;
        parent::$data['website_note_text_second'] = $website_note_text_second;

        return view('admin.website_home.website', parent::$data);

    }

    public function add_home_data(Request $request)
    {

        try {
            $categories = json_decode($request->categories);
            $arr = [];
            WebsiteHome::select('*')->delete();
            Widget::select('*')->delete();
            foreach ($categories as $key => $category) {

                $arr[] = [
                    'type_id' => $category->id,
                    'name_ar' => $category->name_ar,
                    'name_en' => $category->name_en,
                    'type' => $category->type,
                    'product_counts' => $category->type == 2 ? 0 : ($category->in_home_products_count >= 1 ? $category->in_home_products_count : 1),
                    'order' => $key + 1
                ];
            }
            WebsiteHome::insert($arr);

           $webhome =  WebsiteHome::all();

           foreach ($webhome as $item){
               if ($item->type == 1){
                   Widget::create(['website_home_id'=>$item->id,'widget_type'=>mt_rand(1,4)]);
               }
           }

            $this->add_action("update_website_category" ,'website_category', json_encode([]));
            return general_response(true, true, trans('admin.success'), "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }

    }

    public function add_sidebar_categories(Request $request)
    {
        $categories = json_decode($request->categories, true);
        $categories = convert_from_tree_to_list($categories);
        Category::select('*')->update([
            'in_website_sidebar' => 0,
            'in_website_sidebar_order' => 0,
            'parent_website' => null,
        ]);
        foreach ($categories as $key => $category) {
            Category::where('id', '=', $category['id'])->update([
                'in_website_sidebar' => 1,
                'in_website_sidebar_order' => $key + 1,
                'website_nickname_ar' => $category['nickname_ar'],
                'website_nickname_en' => $category['nickname_en'],
                'parent_website' => $category['parent']
            ]);
        }
        $this->add_action("update_sidebar_website_category" ,'website_category', json_encode([]));
        update_all_category_with_parents();
        return general_response(true, true, trans('admin.success'), "", "", []);
    }

    public function update_note_in_website_home(Request $request)
    {

        try {
            $website_note = WebsiteTopBanner::first();
            $select_pointer = $request->select_pointer;
            $rules = [];
            if ($select_pointer == 1) {
                $rules['category_id'] = [
                    'required',
                    Rule::exists('categories', 'id')->whereNull('deleted_at')
                ];
            } else if ($select_pointer == 2) {
                $rules['product_id'] = [
                    'required',
                    Rule::exists('products', 'id')->whereNull('deleted_at')
                ];
            } else if ($select_pointer == 3) {
                $rules['url'] = [
                    'required'
                ];
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->errors();
                $get_one_message = get_error_msg($rules, $messages);
                return general_response(false, true, "", $get_one_message, "", []);
            } else {
                if ($request->hasFile('image_ar')) {
                    $path_ar = (new StoreFile($request->image_ar))->store_local('website_top_banner');
                } else {
                    $path_ar = $website_note->getOriginal('image_ar');
                }
                if ($request->hasFile('image_en')) {
                    $path_en = (new StoreFile($request->image_en))->store_local('website_top_banner');
                } else {
                    $path_en = $website_note->getOriginal('image_en');
                }
                $product_id = $request->product_id;
                $category_id = $request->category_id;
                $url = $request->url;

                $status = $request->status;
                $website_note->update([
                    'image_ar' => $path_ar,
                    'image_en' => $path_en,
                    'category_id' => $select_pointer == 1 ? $category_id : null,
                    'product_id' => $select_pointer == 2 ? $product_id : null,
                    'url' => $select_pointer == 3 ? $url : null,
                    'status' => $status
                ]);
                $this->add_action("update_website_note" ,'website_note', json_encode([]));
                return general_response(true, true, trans('admin.success'), "", "", []);
            }
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }


    }

    public function update_note_text_first_in_website_home(Request $request){

        try {
            $website_note = WebsiteTopBanner::find(2);
            $select_pointer = $request->select_pointer;
            $rules = [];
            if ($select_pointer == 1) {
                $rules['category_id'] = [
                    'required',
                    Rule::exists('categories', 'id')->whereNull('deleted_at')
                ];
            } else if ($select_pointer == 2) {
                $rules['product_id'] = [
                    'required',
                    Rule::exists('products', 'id')->whereNull('deleted_at')
                ];
            } else if ($select_pointer == 3) {
                $rules['url'] = [
                    'required'
                ];
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->errors();
                $get_one_message = get_error_msg($rules, $messages);
                return general_response(false, true, "", $get_one_message, "", []);
            } else {

                $text_ar = $request->text_ar;
                $text_en = $request->text_en;
                $text_color = $request->text_color;
                $background_color = $request->background_color;
                $product_id = $request->product_id;
                $category_id = $request->category_id;
                $url = $request->url;

                $status = $request->status;
                $website_note->update([
                    'text_ar' => $text_ar,
                    'text_en' => $text_en,
                    'text_color' => $text_color,
                    'background_color' => $background_color,
                    'category_id' => $select_pointer == 1 ? $category_id : null,
                    'product_id' => $select_pointer == 2 ? $product_id : null,
                    'url' => $select_pointer == 3 ? $url : null,
                    'status' => $status
                ]);
                $this->add_action("update_website_note_text_first" ,'website_note', json_encode([]));
                return general_response(true, true, trans('admin.success'), "", "", []);
            }
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }
    }

    public function update_note_text_second_in_website_home(Request $request){
        try {
            $website_note = WebsiteTopBanner::find(3);
            $select_pointer = $request->select_pointer;
            $rules = [];
            if ($select_pointer == 1) {
                $rules['category_id'] = [
                    'required',
                    Rule::exists('categories', 'id')->whereNull('deleted_at')
                ];
            } else if ($select_pointer == 2) {
                $rules['product_id'] = [
                    'required',
                    Rule::exists('products', 'id')->whereNull('deleted_at')
                ];
            } else if ($select_pointer == 3) {
                $rules['url'] = [
                    'required'
                ];
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->errors();
                $get_one_message = get_error_msg($rules, $messages);
                return general_response(false, true, "", $get_one_message, "", []);
            } else {

                $text_ar = $request->text_ar;
                $text_en = $request->text_en;

                $text_color = $request->text_color;
                $background_color = $request->background_color;

                $product_id = $request->product_id;
                $category_id = $request->category_id;
                $url = $request->url;

                $status = $request->status;
                $website_note->update([
                    'text_ar' => $text_ar,
                    'text_en' => $text_en,
                    'text_color' => $text_color,
                    'background_color' => $background_color,
                    'category_id' => $select_pointer == 1 ? $category_id : null,
                    'product_id' => $select_pointer == 2 ? $product_id : null,
                    'url' => $select_pointer == 3 ? $url : null,
                    'status' => $status
                ]);
                $this->add_action("update_website_note_text_first" ,'website_note', json_encode([]));
                return general_response(true, true, trans('admin.success'), "", "", []);
            }
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }
    }

    /*   helpers functions */
    public function get_category_parent()
    {
        // return response()->json($this->category->get_category_parent());
        return response()->json($this->category->all());
    }

    public function get_tree_of_parent(Request $request)
    {
        $id = $request->category_id;
        $category = Category::find($id);

        /*
         if($category) {
             $parent = $category->parent_;

             while($parent) {
                 $parents[] = $parent;
                 $parent = $parent->parent_;
             }
             if($category) {
                 $parents[] = $category;
             }

         }*/
        if ($category) {
            $parents = $category->getParentsAttribute();
        }
        $parents[] = ['id' => -1, 'name' => trans('admin.main_category')];
        $parents = array_reverse(collect($parents)->toArray());
        return response()->json($parents);
    }

}
