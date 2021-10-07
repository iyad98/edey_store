<?php

namespace App\Http\Controllers\Admin;


use App\Models\Category;
use App\Models\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;

// models
use App\User;
use App\Models\Banner;
use App\Models\AppHome;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Services\StoreFile;

use App\Http\Resources\CategoryDataResourceDFT;

// jobs
use App\Jobs\UpdateCategoriesBannersAppJob;


class AppCategoryController extends HomeController
{

    public $category;

    public function __construct(CategoryRepository $category)
    {
        $this->middleware('check_role:view_application');

        parent::__construct();
        parent::$data['active_menu'] = 'app';
        parent::$data['sub_menu'] = 'app_categories';
        parent::$data['route_name'] = trans('admin.categories');
        parent::$data['route_uri'] = route('admin.categories.index');

        $this->category = $category;
    }

    public function index()
    {
        return view('admin.categories.index', parent::$data);
    }




    // app
    public function app_categories()
    {
        $app_home = AppHome::with('banner')->get();
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
                'id' => $type->type_id ,
                'name' => $name ,
                'name_ar' => $type->name_ar ,
                'name_en' => $type->name_en ,
                'in_home_order' => $type->order,
                'type' => $type->type ,
                'product_counts' => $type->product_counts,
            ];
        }



        $app_home_banner_categories = collect($app_home_data)->sortBy('in_home_order')->values();
        $sidebar_categories =$categories_with_parent->where('in_sidebar', '=', 1)->sortBy('in_sidebar_order')->values();
        $banners = Banner::Parents()->get();


        parent::$data['categories'] = $categories_with_parent;
        parent::$data['app_home_banner_categories'] = json_encode($app_home_banner_categories);
        parent::$data['sidebar_categories'] = json_encode($sidebar_categories);

        parent::$data['banners'] = $banners;

        return view('admin.categories.app', parent::$data);

    }
    public function add_home_categories(Request $request)
    {
        try {
            $categories = json_decode($request->categories);
            $arr = [];
            AppHome::select('*')->delete();
            foreach ($categories as $key => $category) {
                $arr[] = [
                    'type_id' => $category->id,
                    'name_ar' => $category->name_ar ,
                    'name_en' => $category->name_en ,
                    'type' => $category->type,
                    'product_counts' => $category->type == 2 ? 0 : ($category->in_home_products_count >= 1 ? $category->in_home_products_count : 1),
                    'order' => $key + 1
                ];
            }
            AppHome::insert($arr);

            // update update categories banners app
//            $update_categories_banners_app = (new UpdateCategoriesBannersAppJob());
//            dispatch($update_categories_banners_app);

            $this->add_action("update_app_category" ,'app_category', json_encode([]));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }

    }
    public function add_sidebar_categories(Request $request)
    {
        $categories = json_decode($request->categories, true);
        $categories = convert_from_tree_to_list($categories);

        Category::select('*')->update([
            'in_sidebar' => 0,
            'in_sidebar_order' => 0,
            'parent_app' => null,
        ]);
        foreach ($categories as $key => $category) {
            Category::where('id', '=', $category['id'])->update([
                'in_sidebar' => 1,
                'in_sidebar_order' => $key + 1,
                'nickname_ar' => $category['nickname_ar'],
                'nickname_en' => $category['nickname_en'],
                'parent_app' => $category['parent']
            ]);
        }

        update_all_category_with_parents();
        $this->add_action("update_app_sidebar_category" ,'app_sidebar_category', json_encode([]));
        return general_response(true, true, trans('admin.success'), "", "", []);
    }
    
    public function update_website_note(Request $request) {
        
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
