<?php

namespace App\Http\Controllers\Api;

use App\Repository\CategoryRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*  Resources  */

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceDFT;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// services
use App\Services\SWWWTreeTraversal;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function get_categories(Request $request)
    {

        $request->request->add(['is_nickname' => true]);
        $categories = $this->category->withCount(['app_children as children_count'])
            ->whereNull('parent_app')
            ->where('in_sidebar' , '=' , 1)
            ->orderBy('in_sidebar_order')
            ->get();




//        $response['name'] = trans('api.application_menu');
        $response['count'] = $categories->count();
        $response['data'] = CategoryResource::collection($categories);

        return response_api(true, trans('api.success'), $response);
    }

    public function get_sub_category(Request $request ,$category_id)
    {

        $data = [
            'category_id' => $category_id
        ];
        $rules = [
            'category_id' => ['required', Rule::exists('categories', 'id')->whereNull('deleted_at')],
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);

            return response_api(false, $get_one_message, []);
        } else {
            $request->request->add(['is_nickname' => true]);
            $filters = ['parent' => $category_id];


            $categories = $this->category->withCount(['app_children as children_count'])
                ->where('in_sidebar' , '=' ,1)
                ->where('parent_app' , '=' ,$category_id)
                ->orderBy('in_sidebar_order')


                ->get();


            $defult =  json_decode( json_encode( array('id'=>$category_id,
                'nickname'=>trans('api.all_products'),
                'parent'=>-1,
                'parent_app'=>-1,
                'image'=>'',
                'have_children'=>false,
                'children_count'=>0,
                )));

            $categories->prepend($defult);


            $response['data'] = CategoryResource::collection($categories);
            return response_api(true, trans('api.success'), $response);
        }

    }


    /*** DFS  **/
    public function tree_traversal()
    {

        $tree = array(
            'id' => 'a',
            'children' => array(
                array(
                    'id' => 'b',
                    'children' => array(
                        'id' => 'd',
                        'children' => array()
                    )
                ),
                array(
                    'id' => 'e',
                    'children' => array(
                        'id' => 'f',
                        'children' => array()
                    )
                ),
                array(
                    'id' => 'c',
                    'children' => array()
                )
            )
        );

        $categories = $this->category->with('children')
            ->filter(['parent' => null])
            ->select('id')
            ->get();
        $tree = CategoryResourceDFT::collection($categories);
        $tree = json_decode(collect($tree), true);


        $conf = array('tree' => $tree);
        $instance = new SWWWTreeTraversal($conf);
        return $instance->get();

    }

    /***************************************/
    public function all_products()
    {
        $products = [];
        $categories = [$this];
        while (count($categories) > 0) {
            $nextCategories = [];
            foreach ($categories as $category) {
                $products = array_merge($products, $category->products->all());
                $nextCategories = array_merge($nextCategories, $category->children->all());
            }
            $categories = $nextCategories;
        }
        return new Collection($products); //Illuminate\Database\Eloquent\Collection
    }

    public function test_cache()
    {
        /*
        $categories = $this->category->with('children')
            ->select('id')
            ->get();
        $tree = CategoryResourceDFT::collection($categories);
        $tree = Cache::forever('categories_tree' , $tree);
        */
        $tree = get_categories_cache();
        return $tree;
    }
    /*****************************************/
}


