<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

use  App\Http\Resources\BrandResource;
use App\Http\Resources\Product\StockStatusResource;
use App\Http\Resources\TaxStatus;

use Carbon\Carbon;

class ProductVariationDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
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
            'id' => $this->id,
            'product_id' => $this->product_id ,
            'image' => $this->product->image,
            'name' => $this->product->name,
            'key' => $this->key,
            'description' => $this->product->description,
            'description_text' => strip_tags($this->product->description) ,
            'price' => convert_currency($get_helper_product_price['price'] , $request->get_currency_data),
            'price_after' => convert_currency($get_helper_product_price['price_after'] ,$request->get_currency_data ),
            'currency' => $request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency(),
            'is_discount' => $get_helper_product_price['discount_rate'] == 0 ? false : true,
            'discount_rate' => $get_helper_product_price['discount_rate'] . "%",
            'min_quantity' => $this->min_quantity,
            'max_quantity' => $this->max_quantity,
            'in_cart' => $this->cart_products_count && $this->cart_products_count > 0 ? true : false,
            'quantity_cart' => $this->cart_products && count($this->cart_products) > 0 ? $this->cart_products[0]->quantity : 1,
            'variation_key' => $this->key,
            'on_sale' => $this->on_sale == 1 ? true : false,
            'in_stock' => $this->stock_status && $this->stock_status->key == "available" ? true : false,
            'stock_status' => new StockStatusResource($this->stock_status),
            'images' => $get_images,

            'categories' => implode(" , ", $this->product->categories->pluck('name')->toArray()),
            'brand' => new BrandResource($this->product->brand),
            'tax_status' => new TaxStatus($this->product->tax_status),
            'attributes' => $this->product->is_variation == 0 ? [] : ProductAttributeResource::collection($this->product->attributes),
            'attribute_values' => $this->attribute_values,
            'share_url' => $this->share_url,

            'is_new' => $this->product->created_at >= Carbon::now()->subDays(10),
            'in_offer' => $this->product->in_offer == 1,
            'in_day_deal' => $this->product->in_day_deal == 1 ,
            'is_exclusive' => $this->product->is_exclusive == 1,
            'is_finish_quantity' => $this->stock_quantity <= 0 ,

            'note1' => $request->product_details_note1 ,
            'note2' => $request->product_details_note2 ,


            'rate_sum' => $this->product->rates_count ,
            'rate' => round($this->product->rates_count > 0 ? ($this->product->rate_sum / $this->product->rates_count) : 0 , 2),


        ];
    }
}
