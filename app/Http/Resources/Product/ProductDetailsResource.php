<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\MerchantResource;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\BrandResource;
use App\Http\Resources\TaxStatus;
use App\Http\Resources\Product\StockStatusResource;
use App\Http\Resources\Product\ProductVariationResource;

use Carbon\Carbon;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        // $request->request->add(['aaa' => [1 , 2 ,3]]);
        // $get_helper_product_price = get_helper_product_price($this);
        $get_helper_product_price = get_helper_product_variation_price($this->variation, $request->price_tax_in_products);
        $get_images = $this->images->pluck('image')->toArray();
        array_unshift($get_images ,$this->image );

        return [
            'id' => $this->id,
            'product_id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
//            'description' => $this->description,
            'description' => $this->description , //strip_tags($this->description)
            'price' => number_format(convert_currency($get_helper_product_price['price'], $request->get_currency_data),round_digit(),'.',''),
            'price_after' => number_format(convert_currency($get_helper_product_price['price_after'], $request->get_currency_data),round_digit(),'.',''),
            'currency' => $request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency(),
            'is_discount' => $get_helper_product_price['discount_rate'] == 0 ? false : true,
            'discount_rate' => $get_helper_product_price['discount_rate'] . "%",
            'min_quantity' => $this->variation->min_quantity,
            'max_quantity' => $this->variation->max_quantity,
            'variation_key' => $this->variation->key,
            'is_variation' => $this->is_variation == 1 ? true : false,
            'in_favorite' => $this->favorites_count && $this->favorites_count > 0 ? true : false,
            'in_cart' => $this->variation->cart_products_count && $this->cart_products_count > 0 ? true : false,
            'quantity_cart' => $this->variation->cart_products && count($this->variation->cart_products) > 0 ? $this->variation->cart_products[0]->quantity : 1,
            'images' => $get_images,
            'categories' => implode(" , ", $this->categories->pluck('name')->toArray()),
            'brand' => new BrandResource($this->brand),
            'merchant' => new MerchantResource($this->merchant),
            'tax_status' => new TaxStatus($this->tax_status),
            'on_sale' => $this->variation->on_sale == 1 ? true : false,
            'sku' => $this->variation->sku,
            'in_stock' => $this->variation->stock_status && $this->variation->stock_status->key == "available" ? true : false,
//            'stock_status' => new StockStatusResource($this->variation->stock_status),
            'attributes' => $this->is_variation == 0 ? [] : ProductAttributeResource::collection($this->attributes),

            'share_url' => $this->share_url,
            'is_new' => $this->created_at >= Carbon::now()->subDays(10),
            'in_offer' => $this->in_offer == 1,
            'in_day_deal' => $this->in_day_deal == 1,
            'is_exclusive' => $this->is_exclusive == 1,
            'is_finish_quantity' => $this->variation->stock_quantity <= 0,
            'stock_quantity' => $this->variation->stock_quantity,

            'note1' => $request->product_details_note1 ,
            'note2' => $request->product_details_note2 ,
            'can_gift'=>$this->can_gift == 1,
            'rate_sum' => $this->rates_count,
            'rate' => round($this->rates_count > 0 ? ($this->rate_sum / $this->rates_count) : 0, 2),


//              'variations' => ProductVariationResource::collection($this->variations),
        ];
    }
}
