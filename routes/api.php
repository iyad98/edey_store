<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['check_language', 'get_user'], 'namespace' => 'Api'], function () {

    Route::get('shipping-companies/{city_id?}', 'ApiController@get_shipping_companies');
    Route::get('countries', 'ApiController@get_countries');
    Route::get('cities', 'ApiController@get_cities_2');
    Route::get('cities/{country_id}', 'ApiController@get_cities');

    Route::get('stores', 'ApiController@get_stores');

    Route::group(['middleware' => ['check_maintenance_mode_app']], function () {

       Route::get('home', 'HomeController@home')->middleware('published.product');

        Route::get('advertisements', 'HomeController@advertisements');
        Route::get('cancel_reasons', 'HomeController@cancel_reasons');


        Route::get('payment-methods', 'ApiController@get_payment_methods');


        Route::group(['prefix' => 'user/'], function () {
            // home
            Route::get('home', 'HomeController@home');
            // auth
            Route::post('login', 'UserController@login');
            Route::post('register', 'UserController@register');
            Route::post('social-login', 'UserController@social_login');
            // forgot password
            Route::post('forgot-password', 'UserController@send_reset_link_email');

            Route::get('change-notification-status', 'UserController@change_notification_status');
            Route::get('get-app-setting', 'UserController@get_app_setting');

            // help_center
            Route::get('help_center', 'UserController@help_center');

            // cart
            Route::get('products-cart', 'CartController@get_user_cart_products');
            Route::post('product-cart/add-or-update', 'CartController@add_or_update_product_to_cart');
            Route::get('product-cart/delete/{product_id}', 'CartController@remove_product_from_cart');
            Route::post('bill', 'CartController@get_bill');
            // update shipping
            Route::get('shipping-address', 'UserController@addresses')->middleware('TokenInvalid');
            Route::post('shipping-address-store', 'UserController@store_shipping')->middleware('TokenInvalid');
            Route::post('shipping-address-update/{id}', 'UserController@update_shipping')->middleware('TokenInvalid');
            Route::post('shipping-address-delete', 'UserController@delete_shipping')->middleware('TokenInvalid');
            Route::post('shipping-address-as-default', 'UserController@shipping_address_as_default')->middleware('TokenInvalid');
            Route::post('confirm-shipping-address-phone', 'UserController@confirm_shipping_address_code')->middleware('TokenInvalid');


            // coupon
            Route::post('coupon', 'CartController@check_coupon');
            // order
            Route::post('order/add', 'OrderController@make_order');
            Route::post('order/chack_payment', 'OrderController@chack_payment');

            Route::post('return-order-products/{order}' , 'OrderReturnController@return_order_product');
            // order phone code
            Route::post('send-order-phone-code', 'OrderConfirmPhoneController@send_code');
            Route::post('confirm-order-phone', 'OrderConfirmPhoneController@confirm_code');

            Route::get('banks', 'BankTransferController@get_banks');
            Route::post('send-bank-transfer', 'BankTransferController@bank_transfer');



            // comments
            Route::get('comments/{product_id}', 'CommentController@show');
            // countries
            Route::post('change-country', 'UserController@change_country');
            // orders
            Route::get('orders/{id}', 'OrderController@order_details');
            Route::post('orders_cancel', 'OrderController@order_cancel');
            Route::post('ticket', 'OrderController@ticket');

        });

        // category
        Route::get('category', 'CategoryController@get_categories');
        Route::get('category/{category_id}', 'CategoryController@get_sub_category');
        // product
        Route::get('products', 'ProductController@products')->middleware('published.product');;
        Route::get('products/{id}', 'ProductController@product_details')->middleware('published.product');;
        Route::post('product-variation', 'ProductController@get_data_product_variation');
        Route::post('product-variation-details', 'ProductController@product_variation_details');

        Route::get('compare-products', 'ProductController@compare_products');
        // brands
        Route::get('brands', 'BrandController@get_brands');

//        Route::get('user/orders', 'OrderController@my_return_orders');
        Route::get('user/orders_search', 'OrderController@orders_search');

        Route::group(['middleware' => ['auth:api'], 'prefix' => 'user/'], function () {

            // auth
            Route::get('profile', 'UserController@profile')->middleware('TokenInvalid');;
            Route::post('update', 'UserController@update_profile')->middleware('TokenInvalid');;
            Route::get('logout', 'UserController@logout');
            Route::post('fcm', 'UserController@set_fcm_token');
            Route::post('set-language', 'UserController@set_language');
            Route::get('wallet', 'UserController@wallet');

//            // user code
//            Route::post('send-code', 'UserController@send_code');
//            Route::post('check-code', 'UserController@check_code');

            // test
            Route::post('add-contact', 'UserController@add_contact');

            // favorite
            Route::get('favorites', 'ProductController@favorites')->middleware('TokenInvalid');
            Route::get('add-product-to-favorite/{id}', 'ProductController@add_product_to_favorites')->middleware('TokenInvalid');
            Route::get('remove-product-from-favorite/{id}', 'ProductController@remove_product_from_favorites')->middleware('TokenInvalid');

            // order
            Route::get('orders', 'OrderController@my_orders');
            // notification
            Route::get('testn', 'NotificationAppUserController@test');
            Route::get('notifications', 'NotificationAppUserController@get_notifications');
            Route::get('remove-all-notifications', 'NotificationAppUserController@remove_notifications');
            Route::get('mark-as-read-notification/{id}', 'NotificationAppUserController@mark_as_read');
            // comment
            Route::post('comments', 'CommentController@store');
            // rate
            Route::resource('rates', 'ProductRateController');


        });


    });

});


Route::get('test', 'Api\TestController@test');


Route::get('test_', function () {

    $key = "AIzaSyDuTAUwCcpRsxstXrHboNHrofWTmbLBbE4";
    $lat = "21.480939082217933";
    $lng = "39.18832189504133";
    $from_place = json_decode('[' . file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . "&language=ar&key=$key") . ']', true);
    return $from_place;
});
