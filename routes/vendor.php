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


Route::get('get-payment-methods-by-shipping-company/{shipping_company_id}/{city_id}', 'Admin\PaymentMethodController@get_payment_methods_by_shipping_company');

//Route::view('kareem', 'website_v3.app.layout');


Route::group(['prefix' => LaravelLocalization::setLocale(), 'namespace' => 'Website', 'middleware' => ['check_maintenance_mode_website', 'check_country_code', 'get_website_user', 'page-cache']], function () {
//Route::group(['prefix' => LaravelLocalization::setLocale(), 'namespace' => 'Website',], function () {

    Route::get('/', 'HomeController@index')->middleware('published.product');;


    Route::get('upgrade-account', 'MerchantController@upgrade_account')->name('upgrade.account.get');
    Route::post('upgrade-account', 'MerchantController@store_merchant')->name('upgrade.account.post');
    Route::get('/merchant/{merchant_id}/{category_id?}', 'MerchantController@merchant_details')->name('merchant.account.get');


    Route::post('filter_product', 'MerchantController@filter_product')->name('filter.product');
    Route::post('search/product/{merchant_id}', 'MerchantController@searchProduct')->name('merchant.search.product');



});




