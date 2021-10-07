<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MedicineTypeResource;
use App\Http\Resources\Cart\CartAttributeValueResource;

class CartProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $get_product_price_data = get_helper_product_variation_price($this->product_variation , false);

        $product_price = $get_product_price_data['price_after'];
        $product_price_after = $get_product_price_data['price_after'];

        $product_total_price = $product_price * $this->quantity;
        $product_total_price_after = $product_price_after * $this->quantity;

        $discount_price = $product_price - $product_price_after;

        $unit_tax = $this->product_variation->product->tax_status->key == "taxable" ? round($request->get_tax / 100 * $product_price_after, round_digit()) : 0;
        $tax      = $this->product_variation->product->tax_status->key == "taxable" ? round($request->get_tax / 100 * $product_total_price_after, round_digit()) : 0;

        $price = $request->price_tax_in_cart ? $product_price + $unit_tax : $product_price;
        $price_after = $request->price_tax_in_cart ? $product_price_after + $unit_tax : $product_price_after;


        $price_without_tax = convert_currency($product_price , $request->get_currency_data);
        $final_total_price = $request->price_tax_in_cart ? $product_total_price + $tax : $product_total_price;
        $final_total_price_after = $request->price_tax_in_cart ? $product_total_price_after + $tax :$product_total_price_after;
        $total_discount_price = ($product_price - $product_price_after) * $this->quantity;


        $total_price = convert_currency($product_total_price ,$request->get_currency_data );
        $final_total_price = convert_currency($final_total_price , $request->get_currency_data);
        $final_total_price_after = convert_currency($final_total_price_after , $request->get_currency_data);

        // $discount_price = $this->discount_price;
        $is_discount = $discount_price != 0 ? true : false ;
        return [

            'id' => $this->product_variation->product_id,
            'cart_product_id' => $this->id,
            'product_variation_id' => $this->product_variation->id,
            'product' => $this->product ,
            'key' => $this->product_variation->key,
            'name' => $this->product_variation->product->name,
            'image' => $this->product_variation->product->image,
            'thumb_image' => $this->product_variation->product->thumb_image,

            'min_quantity' => $this->product_variation->min_quantity,
            'max_quantity' => $this->product_variation->max_quantity,
            'quantity' => $this->quantity,

            'price' => convert_currency($price , $request->get_currency_data),
            'price_after' => convert_currency($price_after , $request->get_currency_data),
            'discount_price' => convert_currency($discount_price ,$request->get_currency_data ),
            'discount_total_price' => round(($discount_price / $product_price) * 100 , round_digit()) ,
            'total_price' => $total_price,
            'total_price_after' =>  convert_currency($product_total_price_after , $request->get_currency_data) ,
            'price_without_tax' => $price_without_tax ,



            'is_discount' => $is_discount ,

            'final_total_price' => $final_total_price ,
            'final_total_price_after' => $final_total_price_after ,
            'total_discount_price' => convert_currency($total_discount_price ,$request->get_currency_data ) ,
            'tax' => convert_currency($tax ,$request->get_currency_data )  ,
            'attribute_values' => CartAttributeValueResource::collection($this->attribute_values),
            'currency' => $request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency(),
            'is_trashed' => $this->product_variation->trashed() ? true : false,
            'can_gift' => $this->product_variation->product->can_gift,
        ];
    }
}
