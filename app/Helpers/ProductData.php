<?php
use Carbon\Carbon;

function get_helper_product_price($product , $tax_in_product = true) {
    if($tax_in_product) {
        $tax = $product->tax_status && $product->tax_status->key == "taxable" ? get_tax() /100: 0;
    }else {
        $tax = 0;
    }

    $now_time = Carbon::now();
    $get_discount_price = 0;
    $original_price = $product->variation->regular_price;
    $original_price_after = $product->variation->discount_price;

    if(is_null($product->variation->discount_start_at) || ($now_time >= $product->variation->discount_start_at  && $now_time <= $product->variation->discount_end_at)) {
        $get_discount_price = $product->variation->regular_price - $product->variation->discount_price;
    }
    if($product->is_variation == 0 || true) {

        $price = $original_price;
        $price = $price + ($price*$tax);

        $price_after = $original_price - $get_discount_price;
        $price_after = $price_after + ($original_price_after*$tax);
        $discount_rate = ($get_discount_price / $original_price) * 100;
    }else {


        $min_price = $product->min_price;
        $min_price = $min_price + ($min_price*$tax);

        $max_price = $product->max_price;
        $max_price = $max_price + ($max_price*$tax);

        $min_after_price = $product->min_price - $get_discount_price;
        $min_after_price = $min_after_price + ($min_after_price*$tax);

        $max_after_price = $product->max_price - $get_discount_price;
        $max_after_price = $max_after_price + ($max_after_price*$tax);

        $min_discount_rate = ($get_discount_price / $product->min_price) * 100;
        $max_discount_rate = ($get_discount_price / $product->max_price) * 100;

        $price =$min_price != $max_price ? $min_price." - ".$max_price : $max_price;
        $price_after = $min_after_price != $max_after_price ? $min_after_price." - ".$max_after_price :$max_after_price ;
        $discount_rate = $min_discount_rate != $max_discount_rate ?  $min_discount_rate." - ".$max_discount_rate : $max_discount_rate;
    }

    return ['price' =>round($price , round_digit())."" ,'price_after' => round($price_after , round_digit()), 'discount_rate' => round($discount_rate , 1)];
}


function get_helper_product_variation_price($product , $tax_in_product = true) {

    if($tax_in_product) {
        $tax = $product->product->tax_status && $product->product->tax_status->key == "taxable" ? get_tax() /100: 0;
    }else {
        $tax = 0;
    }

    $now_time = Carbon::now();
    $get_discount_price = 0;
    $original_price = $product->regular_price;
    $original_price_after = $product->discount_price;

    if(is_null($product->discount_start_at) || ($now_time >= $product->discount_start_at  && $now_time <= $product->discount_end_at)) {
        $get_discount_price = $original_price  - $product->discount_price;
    }
    $price = $original_price;
    $price = $price + ($price*$tax);

    $price_after = $original_price - $get_discount_price;
    $price_after = $price_after + ($original_price_after*$tax);

    $discount_rate = ($get_discount_price / $original_price) * 100;
    return ['price' => round($price , round_digit())."" ,'price_after' => round($price_after , round_digit())."", 'discount_rate' => round($discount_rate , 1)];
}


function except_data_from_product() {

    return ['page' ,'price_tax_in_cart' ,'price_tax_in_products' ,'get_currency_data' ,
        'country' , 'get_country_data' , 'country_code_session'];

}
