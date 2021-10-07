<?php

namespace App\Http\Resources\Product;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsFavoritesResource extends JsonResource
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

        $data = [
            'id' => $this->id,
            'product_id' => $this->id,
            'image' => $this->image,
            'thumb_image' => $this->thumb_image,
            'name' => $this->name,
            'price' => convert_currency($get_helper_product_price['price'], $request->get_currency_data),
            'price_after' => convert_currency($get_helper_product_price['price_after'], $request->get_currency_data),
            'currency' => $request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency(),
            'is_discount' => $get_helper_product_price['discount_rate'] == 0 ? false : true,
            'in_offer' => $this->in_offer == 1,
            'favorite_date' => Carbon::parse($this->favorite_date)->format('Y-m-d')
        ];

        return $data;
    }
}
