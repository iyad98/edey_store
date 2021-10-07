<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\BrandResource;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $get_helper_product_price = get_helper_product_price($this, $request->price_tax_in_products);
//        $note_discount_product_details = Setting::where('key','note_discount_product_details')->first();

        $data = [
            'id' => $this->id,
            'product_id' => $this->id,
            'image' => $this->image,
            'thumb_image' => $this->thumb_image,
            'name' => $this->name,
            'description' => strip_tags($this->description) ,
            'price' => number_format(convert_currency($get_helper_product_price['price'], $request->get_currency_data), round_digit(),'.','') ,
            'price_after' => number_format(convert_currency($get_helper_product_price['price_after'], $request->get_currency_data), round_digit(),'.',''),
            'currency' => $request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency(),
            'is_discount' => $get_helper_product_price['discount_rate'] == 0 ? false : true,
            'discount_rate' => $get_helper_product_price['discount_rate'] . "%",


            'in_favorite' => $this->favorites_count && $this->favorites_count > 0 ? true : false,
            'in_cart' => $this->cart_products_count && $this->cart_products_count > 0 ? true : false,
            'in_stock' => $this->variation->stock_status && $this->variation->stock_status->key == "available" ? true : false,

            'is_new' => $this->created_at >= Carbon::now()->subDays(10),
            'in_offer' => $this->in_offer == 1,
//            'in_day_deal' => $this->in_day_deal == 1 ,
//            'is_exclusive' => $this->is_exclusive == 1,
//            'is_finish_quantity' => $this->variation->stock_quantity <= 0 ,
            'is_variation' => $this->is_variation == 1 ? true : false,

            'rate_sum' => $this->rates_count ,
            'rate' => round($this->rates_count > 0 ? ($this->rate_sum / $this->rates_count) : 0 , 2),
            'brand_name'=> $this->brand ? $this->brand->name : '',
            'categories' => implode(" , ", $this->categories->pluck('name')->toArray()),

            'price_tax_in_products' => convert_currency($request->price_tax_in_products, $request->get_currency_data),
            'note_discount_product_details' => "",
            'min_quantity' => $this->variation->min_quantity,
            'max_quantity' => $this->variation->max_quantity,

        ];
        if (isset($this->favorite_date)) {
            $data['favorite_date'] = $this->favorite_date;
        }
        return $data;
    }
}
