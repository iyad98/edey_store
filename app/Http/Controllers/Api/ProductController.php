<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Product\ProductsCategoryResource;
use App\Http\Resources\Product\ProductsFavoritesResource;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Traits */

use App\Traits\PaginationTrait;

/*  Resources  */

use App\Http\Resources\CategoryResource;
use App\Http\Resources\Product\ProductSimpleResource;
use App\Http\Resources\CategoryResourceDFT;
use App\Http\Resources\Product\ProductDetailsResource;
use App\Http\Resources\Product\ProductVariationResource;
use App\Http\Resources\Product\ProductVariationDetailsResource;
use App\Http\Resources\Comment\CommentResource;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// models
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariationImage;
use App\Models\ProductAttributeValue;
use App\Models\ProductVariation;
use App\Models\CartProduct;
use App\Models\Setting;

// services
use App\Services\SWWWTreeTraversal;

// validations
use App\Validations\ProductValidation;

class ProductController extends Controller
{
    use PaginationTrait;

    public $Product;
    public $validation;

    public function __construct(ProductRepository $Product, ProductValidation $validation)
    {
        $this->product = $Product;
        $this->validation = $validation;
    }


    public function products(Request $request)
    {

        $user = $request->user;
        $user_id = $user ? $user->id : -1;

        $get_filter_arr = $this->product->get_filter_data($request);
        $products = $this->product
            ->GetGeneralDataProduct($user_id)
            ->filter($get_filter_arr);

        $products = $this->product->set_order_by_product($request , $products);
        $products = $products->paginate(10);

        if ($request->has('page')) {
            $filters = $request->except(['user', 'page', 'price_tax_in_products', 'get_currency_data']);
        } else {
            $filters = $request->except(['user', 'price_tax_in_products', 'get_currency_data']);
        }


        $filter_option = "&" . http_build_query($filters);
        $response['data'] = ProductsCategoryResource::collection($products);
        $pagination_options = $this->get_options_v2($products, $filter_option);
        $response = $response + $pagination_options;
        return response_api(true, trans('api.success'), $response);
    }

    public function product_details(Request $request, $id)
    {

        $product_details_note1 = Setting::where('key','product_details_note1')->first();
        $product_details_note2 = Setting::where('key','product_details_note2')->first();
        $product_details_note_image = Setting::where('key','product_details_note_image')->first();

        $note_discount_product_details = Setting::where('key','note_discount_product_details')->first();


        $user = $request->user;
        $user_id = $user ? $user->id : -1;
        $cart_product_id = $request->filled('cart_product_id') ? $request->cart_product_id : -1;

        $product = $this->product->get_product_details($id, $user_id);

        if (!$product) {
            return response_api(false, trans('api.product_not_found'), []);

        }

        $related_products = $this->product->related_products($product , $user_id);
        $comments = $product->comments()->GetGeneralData()->latest('comments.created_at')->limit(3)->get();

        $marketing_products = $this->product->marketing_products($product , $user_id);


        $cart_product = CartProduct::find($cart_product_id);
        $product_id = $product->id;

        $attribute_values = [];

        if ($cart_product) {
            $product_variation = ProductVariation::where('id', '=', $cart_product->product_variation_id)
                ->where('product_id', '=', $product_id)->first();

            $attribute_values = $product_variation ? $product_variation->attribute_values()->pluck('attribute_values.id')->toArray() : [];

        } else if (!$cart_product || count($attribute_values) <= 0) {
            $attribute_values = ProductAttributeValue::whereHas('attribute_product', function ($query) use ($product_id) {
                $query->where('product_id', '=', $product_id);
            })->where('is_selected', '=', 1)
                ->pluck('attribute_value_id')
                ->toArray();
        }


        $this->product->get_product_details_note($request);
        //  $attribute_values = $cart_product ?$attribute_values : [] ;
        $request->request->add(['attribute_values' => $attribute_values ]);
        $product->attribute_values = $attribute_values;
        $product->share_url = url('products') . "/" . $product->id;


            $response['data'] =  new ProductDetailsResource($product);

        $response['data']=  collect(['product' => new ProductDetailsResource($product),
          'related_products' => ProductsCategoryResource::collection($related_products),
          'marketing_products' => ProductsCategoryResource::collection($marketing_products),
          'comments' => CommentResource::collection($comments),
          'product_details_note1' => $product_details_note1->value,
          'product_details_note2' => $product_details_note2->value,
          'product_details_note_image' => add_full_path($product_details_note_image->value, 'ads'),
      ]);



//
//        $product_categories = $product->categories;
//        $response['guide_images'] = $product_categories->pluck('guide_image')->toArray();



        return response_api(true, trans('api.success'), $response);
    }

    public function get_data_product_variation(Request $request)
    {

        $user = $request->user;
        $user_id = $user ? $user->id : -1;

        $product_id = $request->product_id;
        $attribute_values = $request->filled('attribute_values') ? $request->attribute_values : [];

        $key = $this->product->get_key_product($product_id, $attribute_values);

        if ($key == '*') {
            $product_variation = ProductVariation::GetGeneralDataProduct($user_id)
                ->where('product_id', '=', $product_id)
                ->with('stock_status', 'images')
                ->where('is_default_select', '=', 1)->first();
        } else {
            $product_variation = ProductVariation::GetGeneralDataProduct($user_id)
                ->where('product_id', '=', $product_id)
                ->with('stock_status', 'images')
                ->where('key', '=', $key)->first();
        }



        if (!$product_variation) {
            return response_api(false, trans('api.product_not_found'), []);
        }
        $response['data'] = new ProductVariationResource($product_variation);
        return response_api(true, trans('api.success'), $response);
    }

    public function product_variation_details(Request $request) {
        if($request->has('cart_product_id')) {
            $response = $this->get_all_data_product_variation($request ,$request->cart_product_id );
        }else {
            $response = $this->get_all_data_product_variation($request );
        }
        return $response;
    }
    public function get_all_data_product_variation(Request $request , $cart_product_id = null)
    {

        $user = $request->user;
        $user_id = $user ? $user->id : -1;

        $product_id = $request->product_id;
        $attribute_values = $request->filled('attribute_values') ? $request->attribute_values : [];

        $product_variation = ProductVariation::with('product.attributes.attribute_values')->GetGeneralDataProduct($user_id)
            ->where('product_id', '=', $product_id)
            ->with('stock_status', 'images');


        if(!is_null($cart_product_id)) {
            $cart_product = CartProduct::with('attribute_values')->find($cart_product_id);
            $attribute_values = $cart_product ? $cart_product->attribute_values->pluck('id')->toArray() : [];
            $product_variation = $product_variation->find($cart_product ? $cart_product->product_variation_id : -1);
        }else {
            $key = $this->product->get_key_product($product_id, $attribute_values);
            if ($key == '*') {
                $product_variation = $product_variation->where('is_default_select', '=', 1)->first();
            } else {
                $product_variation = $product_variation->where('key', '=', $key)->first();
            }
        }


        if (!$product_variation) {
            return response_api(false, trans('api.product_not_found'), []);
        }

        $this->product->get_product_details_note($request);
        $request->request->add(['attribute_values' => $attribute_values]);
        $product_variation->attribute_values = $attribute_values;
        $product_variation->share_url = url('products') . "/" . $product_variation->product_id;

        ////////////////////////////////////////////////////////
        $product =$product_variation->product;
        $related_products = $product->recommended_products();
        if ($related_products->count() <= 0) {
            $category_ids = $product->categories()->pluck('categories.id')->toArray();
            $related_products = $product->filter(['category' => $category_ids]);
        }
        $related_products = $related_products->limit(10)->GetGeneralDataProduct($user_id)->get();
        $comments = $product->comments()->GetGeneralData()->latest('comments.created_at')->limit(3)->get();
        ///////////////////////////////////////////////////////////////

        $response['data'] = new ProductVariationDetailsResource($product_variation);
        $response['related_products'] = ProductSimpleResource::collection($related_products);
        $response['comments'] = CommentResource::collection($comments);
        return response_api(true, trans('api.success'), $response);
    }

    public function compare_products(Request $request)
    {
        $user = $request->user;
        $user_id = $user ? $user->id : -1;
        $first_product_id = $request->first_product;
        $second_product_id = $request->second_product;


        $first_product = $this->product->get_product_details($first_product_id, $user_id);
        $second_product = $this->product->get_product_details($second_product_id, $user_id);


        if (!$first_product || !$second_product) {
            return response_api(false, trans('api.product_not_found'), []);
        }
        $attribute_values = [];
        $request->request->add(['attribute_values' => $attribute_values]);

        $first_product->attribute_values = $attribute_values;
        $first_product->share_url = url('products') . "/" . $first_product->id;

        $second_product->attribute_values = $attribute_values;
        $second_product->share_url = url('products') . "/" . $second_product->id;

        $response['first_product'] = new ProductsCategoryResource($first_product);
        $response['second_product'] = new ProductsCategoryResource($second_product);

        return response_api(true, trans('api.success'), $response);
    }

    // favorites
    public function favorites(Request $request)
    {

        $user = $request->user;
        $user_id = $user ? $user->id : -1;
        $products = $user->favorites()
            ->GetGeneralDataProduct($user_id)
            ->paginate(10);

        $pagination_options = $this->get_options_v2($products);
        $response['data'] = ProductsFavoritesResource::collection($products);
        $response = $response + $pagination_options;
        return response_api(true, trans('api.success'), $response);
    }

    public function add_product_to_favorites(Request $request, $product_id)
    {

        $user = $request->user;

        $data['product_id'] = $product_id;
        $check_data = $this->validation->check_add_to_favorite($data);
        if ($check_data['status']) {

            if ($user->favorites()->where('product_id', '=', $product_id)->exists()) {
                return response_api(false, trans('api.already_in_favorite'), []);
            }
            $user->favorites()->syncWithoutDetaching($product_id);

            /***************  notification **************************/

            return response_api(true, trans('api.added_to_favorite'), []);
        } else {
            return response_api(false, $check_data['message'], []);
        }
    }

    public function remove_product_from_favorites(Request $request, $product_id)
    {
        $user = $request->user;
        $data['product_id'] = $product_id;
        $check_data = $this->validation->check_add_to_favorite($data);
        if ($check_data['status']) {

            if (!$user->favorites()->where('product_id', '=', $product_id)->exists()) {
                return response_api(false, trans('api.not_in_favorite'), []);
            }

            $user->favorites()->detach($product_id);
            return response_api(true, trans('api.remove_from_favorite'), []);
        } else {
            return response_api(false, $check_data['message'], []);
        }
    }

}
