<?php

use App\Models\ProductCategory;

function get_category_lang()
{
    return "name_" . app()->getLocale();
}

function get_category_nick_lang()
{
    return "website_nickname_" . app()->getLocale();
}

function get_category_slug_lang()
{
    return "slug_" . (app()->getLocale());
}

function get_category_slug_data_from_id($all_categories, $id)
{

    $get_category = $all_categories->where('id', '=', $id)->first();
    return $get_category;
}

function get_category_from_slug($categories, $slug_data)
{

    $get_category = $categories->where('slug_ar_data', '=', $slug_data)->first();
    if (!$get_category) {
        $get_category = $categories->where('slug_en_data', '=', $slug_data)->first();
    }
    if (!$get_category) {
        $get_category = $categories->where('id', '=', $slug_data)->first();
    }
    return $get_category;
}

function get_slug_data_by_lang($data)
{
    try {
        return app()->getLocale() == 'ar' ? $data->slug_ar_data : $data->slug_en_data;
    } catch (\Exception $e) {
        return "";
    }

}


function get_pointer_url($product)
{
    $pointer = "";
    switch ($product['type']) {
        case 1 :
            $pointer = LaravelLocalization::localizeUrl('shop') . "?category=" . $product['id'];
            break;
        case 2 :
            $pointer = LaravelLocalization::localizeUrl('products') . "/" . $product['id'];
            break;
    }
    return $pointer;
}

function get_pointer_top_banner_url($product)
{

    $pointer = "#";
    if (!is_null($product->category_id)) {
        $pointer = LaravelLocalization::localizeUrl('shop') . "?category=" . $product->category_id;
    } else if (!is_null($product->product_id)) {
        $pointer = LaravelLocalization::localizeUrl('products') . "/" . $product->product_id;
    } else if (!is_null($product->url)) {
        $pointer = $product->url;
    } else {
        $pointer = "";
    }
    return $pointer;
}

function get_pointer_slider_url($product)
{

    $pointer = "#";
    switch ($product['type']) {
        case 1 :
            $pointer = LaravelLocalization::localizeUrl('shop') . "?category=" . $product['id'];
            break;
        case 2 :
            $pointer = LaravelLocalization::localizeUrl('products') . "/" . $product['id'];
            break;
    }
    return $pointer;
}

function get_pointer_home_slider_url($product)
{

    $pointer = "";
    switch ($product['type']) {
        case 1 :
            $pointer = LaravelLocalization::localizeUrl('shop') . "?category=" . $product['id'];
            break;
        case 2 :
            $pointer = LaravelLocalization::localizeUrl('products') . "/" . $product['id'];
            break;
    }
    return $pointer;
}

function convert_from_tree_to_list($array, $parent = null)
{
    $result = array();
    $index = 0;
    foreach ($array as $key => $row) {
        $result[] = ['index' => $index++, 'id' => $row['id'], 'nickname_ar' => $row['nickname_ar'], 'nickname_en' => $row['nickname_en'], 'parent' => $parent];
        if (array_key_exists('children', $row) && count($row['children']) > 0) {
            $result = array_merge($result, convert_from_tree_to_list($row['children'], $row['id']));
        }
    }
    return $result;
}


/*
 ******************************************************************
 * kareem : added function
 * input "merchant_id"
 * output return all category have merchant
 ******************************************************************
 **/

function get_category_merchant($merchant_id)
{
    $category_id = ProductCategory::query()->where('merchant_id', $merchant_id)->pluck('category_id')->toArray();
    $category_id_unique = array_unique($category_id);
//    $categories = \App\Models\Category::query()->whereIn('id', $category_id_unique)->pluck('name_ar','id')->toArray();
    $categories = \App\Models\Category::query()->whereIn('id', $category_id_unique)->get();
    return $categories; // the merchant have products in this category
}









