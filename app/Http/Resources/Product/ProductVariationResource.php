<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

use  App\Http\Resources\BrandResource;
use App\Http\Resources\Product\StockStatusResource;

use Carbon\Carbon;

class ProductVariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $get_helper_product_price = get_helper_product_variation_price($this , $request->price_tax_in_products);
        $get_images =  $this->images->pluck('image')->toArray();
        if($this->images->count() <= 0) {
            $get_images = $this->product->images->pluck('image')->toArray();
            array_unshift($get_images , $this->product->image);
        }

        return [
            'id' => $this->id ,
            'product_id' => $this->product_id ,
            'key' => $this->key ,
            'sku' => $this->sku ,
            'description' => $this->description ,
            'description_text' => strip_tags($this->description) ,
            'price' =>number_format(convert_currency($get_helper_product_price['price'] , $request->get_currency_data) , round_digit(),'.','') ,
            'price_after' =>number_format(convert_currency($get_helper_product_price['price_after'] ,$request->get_currency_data ), round_digit(),'.','') ,
            'currency' => $request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency(),
            'is_discount' => $get_helper_product_price['discount_rate'] == 0 ? false : true ,
            'discount_rate' => $get_helper_product_price['discount_rate']."%" ,
            'min_quantity' => $this->min_quantity ,
            'max_quantity' => $this->max_quantity ,
            'in_cart' => $this->cart_products_count && $this->cart_products_count > 0 ? true : false ,
            'quantity_cart' => $this->cart_products && count($this->cart_products) > 0 ?  $this->cart_products[0]->quantity : 1  ,
            'variation_key' => $this->key ,
            'on_sale' => $this->on_sale == 1 ? true : false ,
            'in_stock' => $this->stock_status && $this->stock_status->key == "available" ? true : false ,
            'stock_status' => new StockStatusResource($this->stock_status),
            'images' => $get_images,
            'is_finish_quantity' => $this->stock_quantity <= 0,
            'available_text' => $this->stock_quantity > 0 && $this->stock_status && $this->stock_status->key == "available" ? trans('api.in_stock') :trans('api.out_of_stock') ,
        ];
    }
}
