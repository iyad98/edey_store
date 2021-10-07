<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});


Route::get('get-payment-methods-by-shipping-company/{shipping_company_id}/{city_id}', 'Admin\PaymentMethodController@get_payment_methods_by_shipping_company');

//Route::view('kareem', 'website_v3.app.layout');


Route::group(['prefix' => LaravelLocalization::setLocale(), 'namespace' => 'Website', 'middleware' => ['check_maintenance_mode_website', 'check_country_code', 'get_website_user', 'page-cache']], function () {
//Route::group(['prefix' => LaravelLocalization::setLocale(), 'namespace' => 'Website',], function () {

    Route::get('/', 'HomeController@index')->middleware('published.product');
    Route::post('/mailing_list', 'HomeController@mailing_list');

    Route::post('/', function () {
        return response()->json([]);
    });

    Route::get('about-us', 'HomeController@about_us');
    Route::get('branches', 'HomeController@branches');
    Route::get('terms', 'HomeController@terms');
    Route::get('contact-us', 'HomeController@contact_us');

    Route::get('return-policy', 'HomeController@return_policy');
    Route::get('privacy-policy', 'HomeController@privacy_policy');

    Route::get('shipping-and-delivery', 'HomeController@shipping_and_delivery');
    Route::get('faqs', 'HomeController@faqs');

    // bank
    Route::get('bank-transfer/{order_id}', 'BankTransferController@bank_transfer');
    Route::post('website/send-bank-transfer', 'BankTransferController@send_bank_transfer');


    Route::get('shop', 'ShopController@index')->middleware('published.product');
    Route::get('product-category/{otherLinks?}', 'ShopController@product_category')->where('otherLinks', '(.*)');
    Route::get('brands', 'ShopController@brands');
    Route::get('search', 'ShopController@search');
    Route::get('category_search', 'HomeController@category_search')->name('search.category.home');

    // products
    Route::get('products-rate', 'ProductRateController@store');

    Route::get('products/{id}', 'ProductController@product_details')->middleware('published.product');
    Route::post('compare-products', 'ProductController@add_compare_products');
    Route::get('compare-products', 'ProductController@compare_products');


    Route::post('product-variation', 'ProductController@get_product_variations');
    Route::get('add-to-wishlist', 'ProductController@add_to_wishlist');
    Route::get('remove-from-wishlist', 'ProductController@remove_from_wishlist');

    Route::get('wishlist', 'ProductController@wishlist');

    // users
    Route::get('my-account', 'UserController@my_account');

    Route::get('sign-up', 'AuthController@sign_up');
    Route::get('sign-in', 'AuthController@sign_in');

    Route::post('website/login', 'AuthController@login');
    Route::post('website/register', 'AuthController@register');
    Route::get('website/logout', 'AuthController@logout');
    Route::get('website/password/forgot', 'UserController@send_reset_password');
    Route::get('website/password/reset/{token}', 'UserController@reset_password')->name('password.reset.custom');
//    Route::get('website/password/reset-done', 'UserController@reset_password_done');


    // my account
    Route::get('my-account/addresses', 'UserController@addresses');
    Route::get('my-account/edit-address/{id}', 'UserController@edit_shipping');
    Route::get('my-account/create-address', 'UserController@create_shipping');

    Route::get('my-account/orders', 'UserController@orders');
    Route::get('my-account/orders/{id}', 'UserController@order_details');
    Route::get('my-account/print_shipping_policy', 'UserController@print_shipping_policy');

    Route::get('my-account/coupons', 'UserController@coupons');

    Route::get('check-return-order', 'OrderReturnController@index');
    Route::post('check-return-order', 'OrderReturnController@check_return_order');

    Route::post('return-order-products/{order}', 'OrderReturnController@return_order_product');

    Route::post('cancel-order', 'UserController@cancel_order');
    Route::post('ticket-order', 'UserController@ticket_order');

    // profile
    Route::post('update-profile', 'UserController@update_profile');
    Route::post('change-password', 'UserController@change_password');
    Route::post('update-shipping/{id}', 'UserController@update_shipping');
    Route::post('store-shipping', 'UserController@store_shipping');
    Route::post('delete-shipping', 'UserController@delete_shipping');
    Route::post('confirm-shipping-address-code', 'UserController@confirm_shipping_address_code');


    // cart data
    Route::get('get-cart-data', 'CartWebsiteController@get_cart_data');
    Route::get('get-cart-data-count', 'CartWebsiteController@get_cart_data_count');
    Route::post('add-or-update-product-to-cart', 'CartWebsiteController@add_or_update_product_to_cart');
    Route::post('update-cart-quantity', 'CartWebsiteController@update_cart_quantity');
    Route::get('remove-product-from-cart/{cart_product_id}', 'CartWebsiteController@remove_product_from_cart');
    Route::get('cart', 'CartWebsiteController@index');
    Route::get('get-cart-details-data', 'CartWebsiteController@get_all_cart_data');
    Route::get('apply-coupon', 'CartWebsiteController@apply_coupon');

    //checkout
    Route::get('checkout', 'OrderWebsiteController@checkout');
    Route::post('update-billing', 'OrderWebsiteController@update_billing');

    // order phone code
    Route::post('send-order-phone-code', 'OrderConfirmPhoneController@send_code');
    Route::post('confirm-order-phone', 'OrderConfirmPhoneController@confirm_code');

    Route::post('add-order', 'OrderWebsiteController@add_order');
    // contact
    Route::post('send-contact', 'ContactController@send_contact');

    Route::get('c/{code}', 'PaymentController@confirmcod');
    Route::get('compleate_payment', 'PaymentController@visa_compleate_payment');

    Route::post('upload/media', 'MediaController')->name('upload.media');


    // Auth::routes();

});
Route::get('website/maintenance', function (\Request $request) {
    return view('website.maintenance');
});
Route::group(['prefix' => LaravelLocalization::setLocale(), 'namespace' => 'Website'], function () {
    Route::get('change-country/{country_code}', 'Controller@change_country');

});

Route::get('email_view_test', function () {

    $sd = App\User::select('*')->where('notification', '=', 1)
        ->whereNotNull('fcm_token')
        ->where('platform', '=', 'ios')
        ->chunk(100, function ($users) {
            $get_users_fcm = $users->unique('fcm_token')->pluck('fcm_token')->toArray();
            dd($get_users_fcm);
        });


    return \Illuminate\Support\Facades\Lang::getFromJson(trans('website.reset_password'));
    return view('auth.passwords.email');
});

Route::get('updated_test', function () {

    $products = \App\Models\ProductCategory::query()->get();
    foreach($products as $row) {
        $row->merchant_id = 0;
        $row->save();
    }


});


include 'admin.php';
include 'vendor.php';


