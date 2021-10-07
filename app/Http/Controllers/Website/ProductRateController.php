<?php

namespace App\Http\Controllers\Website;

use App\Jobs\UpdateCategoriesBannersAppJob;
use App\Models\Product;
use App\Models\Rate;
use App\Traits\PaginationTrait;
use App\Validations\ProductRateValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

//            $user = $request->user;
            $user = auth()->user();

            if (is_null($user)){
                $response['data'] = 'k';

                return response_api(true, trans('api.must_login'), $response);

            }

            $check_if_already_rated = Rate::where('user_id' , '=' , $user->id)
                ->where('product_id' , '=' , $request->product_id)
                ->exists();

            if($check_if_already_rated) {
                Rate::where('user_id',$user->id)->update([
                    'product_id' => $request->product_id,
                    'rate' => $request->rate,
                ]);
            }else{
                Rate::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'rate' => $request->rate,
                ]);
            }


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
