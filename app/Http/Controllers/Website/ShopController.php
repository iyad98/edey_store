<?php

namespace App\Http\Controllers\Website;

use App\Http\Resources\CategoryDataResourceDFT;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;

// Repository
use App\Repository\ProductRepository;

// models
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Country;

use Illuminate\Support\Facades\Cache;

// Resources
use App\Http\Resources\Product\ProductSimpleResource;
use Illuminate\Support\Facades\Input;

// services
use App\Services\SWWWTreeTraversal;
use Illuminate\Support\Facades\Auth;

use DB;

class ShopController extends Controller
{


    public $Product;


    public function __construct(ProductRepository $Product)
    {
        $this->product = $Product;

        parent::__construct();
    }

    public function index(Request $request)
    {

$par_page =  $request->per_page ?$request->per_page : 16 ;
        //update_all_category_with_parents();
       $get_products_data = $this->get_products($request);
        $products = $get_products_data['products'];
        $orderBy = $get_products_data['orderBy'];
        $parPage = $get_products_data['parPage'];
        $category = $get_products_data['category'];
        $search = $get_products_data['search'];
        $in_selected_category = $get_products_data['in_selected_category'];
        $brand = $get_products_data['brand'];
        $category_image = $get_products_data['category_image'];

        $min_price = $get_products_data['min_price'];
        $max_price = $get_products_data['max_price'];


        $products_count    = $products->count();



        $products = $products->paginate($par_page);

        $product_min_price =  $products->min('min_price');
        $product_max_price =  $products->max('max_price');


//      return  $result = array_unique($products->pluck('brand_id'));

//       $category_shop =  Category::where('id',$category)->with('children')->get();

//        return  CategoryDataResourceDFT::collection($category_shop);


        $category_brand_id = $products->pluck('brand_id');

        $products_ids = $products->pluck('id');


       $category_brands =  Brand::whereIn('id',$category_brand_id)->withCount('products')->get();



        $get_products = ProductSimpleResource::collection($products);


        $breadcrumb_home = ['name' => trans('website.home'), 'url' => "/"];
        $breadcrumb_arr = count($get_products_data['breadcrumb_arr']) > 0 ? $get_products_data['breadcrumb_arr'] : [['name' => trans('website.store') , 'url' => url('shop')]];
        array_unshift($breadcrumb_arr ,$breadcrumb_home );

        $except_data_from_product = except_data_from_product();
        $except_data_from_product[] = 'user';


        parent::$data['products_count'] = $products_count;
        parent::$data['products'] = json_decode(collect($get_products), true);
        parent::$data['links'] = $products->appends(Input::except($except_data_from_product))->links();
        parent::$data['orderBy'] = $orderBy;
        parent::$data['parPage'] = $parPage;

        parent::$data['category'] = $category;

       $cat = Category::find($category);
        if ($cat != null){
            $cat_name = $cat->name;
        }else{
            $cat_name ='';

        }
        parent::$data['category_name_title'] = $cat_name ;

        parent::$data['brand'] = $brand;
        parent::$data['category_brands'] = $category_brands;
        parent::$data['min_price'] = $min_price;
        parent::$data['max_price'] = $max_price;

        parent::$data['product_min_price'] = $product_min_price;
        parent::$data['product_max_price'] = $product_max_price;


        parent::$data['search'] = $search;
        parent::$data['category_image'] = $category_image;
        parent::$data['in_selected_category'] = $in_selected_category;

        parent::$data['breadcrumb_title'] = trans('website.home');
        parent::$data['breadcrumb_arr'] = [];
        parent::$data['breadcrumb_last_item'] = trans('website.store');
        $all_categories = get_all_category_with_parents();

        parent::$data['category_shop'] =    $all_categories->where('parent', '=', $category)->values();;
//        return  parent::$data;
//        return view('website_v2.shop.category', parent::$data);
        return view('website_v3.shop.category', parent::$data);
    }
    public function brands(Request $request) {

        $breadcrumb_arr = [
            ['name' => trans('website.home'), 'url' => "/"] ,
            ['name' => trans('website.brands') , 'url' => ""]
        ];

        parent::$data['breadcrumb_title'] = trans('website.home');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.store');
        return view('website.brands' , parent::$data);
    }
    // helper
    public function get_products(Request $request)
    {

        $user =Auth::guard('web')->user();
        $user_id = $user ? $user->id : -1;

        $get_id_data_from_slug = $this->get_id_from_slug($request);
        $orderBy = $request->has('orderby') ? $request->orderby : "menu_order";
        $parPage = $request->has('per_page') ? $request->per_page : "16";
        $search = $request->filled('search') ? $request->search : "";
        $category = $request->filled('category') ? $request->category : "";
        $brand = $request->filled('brand') ? $request->brand : "";
        $min_price = $request->filled('min_price') ? $request->min_price : 0;
        $max_price = $request->filled('max_price') ? $request->max_price : 1000;

        if ($request->get_country_data) {
            $country = $request->get_country_data;
        } else {
            $country = null;
        }

        $brand_id = $get_id_data_from_slug['brand_id'];
        $category_ids = $get_id_data_from_slug['category_ids'];
        $breadcrumb_arr = $get_id_data_from_slug['breadcrumb_arr'];
        $in_selected_category = $get_id_data_from_slug['in_selected_category'];
        $category_image = $get_id_data_from_slug['category_image'];
        $category_website_image = $get_id_data_from_slug['category_website_image'];

        $subQuery1 = ProductVariation::select(DB::raw('discount_price'))
            ->whereRaw('product_id = products.id')
            ->whereRaw('is_default_select = 1');


        $products = $this->product->GetGeneralDataProduct($user_id);



        $products = $products->filter([
            'category' => $category_ids,
            'name' => $search ,
            'brand' => $brand_id ,
            'country' => $country ? $country->id : null ,
            'price_range' => ['min_price' => $min_price ,'max_price' => $max_price]
        ]);

        if ($orderBy == "date") {
            $products = $products->orderBy('created_at', 'desc');
        } else if ($orderBy == "price") {
            $products = $products->orderBy(getSubQuerySql($subQuery1), 'asc');
        } else if ($orderBy == "price_desc") {
            $products = $products->orderBy(getSubQuerySql($subQuery1), 'desc');
        }else if ($orderBy == "most_sales") {
            $products = $products->orderBy('orders_count', 'desc');
        }


        return ['products' => $products,'search' => $search , 'orderBy' => $orderBy ,'parPage'=>$parPage ,'min_price' => $min_price ,'max_price' => $max_price,
            'in_selected_category' => $in_selected_category ,'category' => $category ,
            'brand' => $brand, 'category_image' => $category_website_image ? $category_website_image : url('')."/website_v2/images/banner1.jpg",
            'breadcrumb_arr' => $breadcrumb_arr,'category_ids'=>$category_ids];
    }


    public function get_id_from_slug($request) {


        $category_name = get_category_lang();
        $category_slug_name = get_category_slug_lang();
        $in_selected_category = [];
        $category_ids = [];
        $breadcrumb_arr = [];

        $brand = Brand::SearchSlug($request->brand)->first();
        $category = $request->category;
        $category_image = null;
        $category_website_image = null;
        if($request->filled('category')) {

            $get_all_category_with_parents = get_all_category_with_parents();

            $tree = get_categories_cache();

            $get_category = get_category_from_slug($get_all_category_with_parents , $category);


            $get_category_parent = $get_category&& $get_category->parent ? get_category_slug_data_from_id($get_all_category_with_parents ,$get_category->parent) : null;
            $category_image = $get_category ? $get_category->image : null;
            $category_website_image = $get_category ? $get_category->guide_image : null;

            if($get_category) {
                $in_selected_category[] = $get_category->slug_en_data;
                $in_selected_category[] = $get_category->slug_ar_data;
            }
            if($get_category_parent) {
                $in_selected_category[] = $get_category_parent->slug_en_data;
                $in_selected_category[] = $get_category_parent->slug_ar_data;
            }

            $parents = $get_category ? $get_category->get_parents : [];


            $tree = json_decode(collect( $tree)->where('id', '=', $get_category ? $get_category->id : -1), true);
            foreach ($parents as $parent) {
                $breadcrumb_arr[] = ['name' => $parent->$category_name, 'url' => url('shop') . "?category=" . $parent->$category_slug_name];
            }


            $conf = array('tree' => $tree);
            $instance = new SWWWTreeTraversal($conf);
            $category_ids = $instance->get();

        }

        return ['brand_id' => $brand ? $brand->id : -1 , 'category_ids' => $category_ids ,
            'in_selected_category' => $in_selected_category ,'category_image' => $category_image,'category_website_image'=>$category_website_image,
            'breadcrumb_arr' => $breadcrumb_arr ];
    }
}
