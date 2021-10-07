<?php

namespace App\Http\Controllers\Api;

use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Traits */
use App\Traits\PaginationTrait;

/*  Resources  */

use App\Http\Resources\BrandResource;
use App\Http\Resources\Rate\RateResource;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// models
use App\Models\Rate;
use App\Models\Comment;
use App\Models\Product;

// validations
use App\Validations\ProductRateValidation;

// jobs
use App\Jobs\UpdateCategoriesBannersAppJob;


class ProductRateController extends Controller
{
    use PaginationTrait;

    public $validation;

    public function __construct(ProductRateValidation $validation)
    {
        $this->validation = $validation;
    }


    public function store(Request $request)
    {
        $check_data = $this->validation->check_add_rate($request->toArray());

        if ($check_data['status']) {

            $check_if_already_rated = Rate::where('user_id' , '=' , $request->user->id)
                 ->where('product_id' , '=' , $request->product_id)
                 ->exists();

            if($check_if_already_rated) {
                return response_api(false, trans('api.already_rated'), "");
            }
            Rate::create([
                'user_id' => $request->user->id,
                'product_id' => $request->product_id,
                'rate' => $request->rate,
            ]);

            $product = Product::ProductRate()->find($request->product_id);
            $product_rate = $product->rates_count > 0 ? ($product->rate_sum / $product->rates_count) : 0;
            $response['data'] = ['product_rate' => round($product_rate , 2)];

            // update update categories banners app
            $update_categories_banners_app = (new UpdateCategoriesBannersAppJob());
            dispatch($update_categories_banners_app);


            return response_api(true, trans('api.success_rated'), $response);
        } else {
            return response_api(false, $check_data['message'], "");
        }
    }
}
