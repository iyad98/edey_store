<?php

////// rss ////////////////////////////////
Route::get('news-product/{news_product}', 'Website\RSSController@show')->name('news_product.show');
Route::feeds();
/////////////////////////////////////////
Route::get('change-language/{lang}' ,'Website\Controller@change_language' );

Route::group(['prefix' => 'admin', 'namespace' => 'Admin' ,'middleware' => ['check_admin_lang']], function () {

    Route::get('login', 'AuthController@show_login')->name('admin.auth.login');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');


    Route::group(['middleware' => ['auth:admin' , 'merge_admin_fcm']], function () {

        Route::get('/', 'AdminController@index')->name('admin.index');

        Route::post('set-fcm', 'AdminController@set_fcm_token');
        /*   admins   */

        Route::get('admins', 'AdminController@admins')->name('admin.admins.index');
        Route::post('admins/add', 'AdminController@store');
        Route::post('admins/update', 'AdminController@update');
        Route::post('admins/changeStatus', 'AdminController@change_status');
        Route::post('admins/delete', 'AdminController@delete');

        Route::get('profile', 'AdminController@profile');
        Route::post('profile/update', 'AdminController@update_profile');
        Route::post('profile/changePassword', 'AdminController@change_password');

        Route::get('permissions/{admin_id}', 'PermissionController@permissions')->name('admin.permissions.index');
        Route::post('update-permissions', 'PermissionController@update');
        Route::post('update-admin-order-status', 'PermissionController@add_admin_order_status');


        /*   users   */

        Route::get('users', 'UserController@index')->name('admin.users.index');
        Route::post('users/add', 'UserController@store');
        Route::post('users/update', 'UserController@update');
        Route::post('users/changeStatus', 'UserController@change_status');
        Route::post('users/delete', 'UserController@delete');


        /*   categories   */

        Route::get('categories', 'CategoryController@index')->name('admin.categories.index');
        Route::post('categories/add', 'CategoryController@store');
        Route::post('categories/update', 'CategoryController@update');
        Route::post('categories/delete', 'CategoryController@delete');
        Route::get('categories/get-tree-of-parent', 'CategoryController@get_tree_of_parent');
        /*  helper route categories*/
        Route::get('getCategoryAjax', 'CategoryController@get_category_ajax');
        Route::get('categories/parent/get', 'CategoryController@get_category_parent');

        Route::get('app-categories', 'AppCategoryController@app_categories')->name('admin.app-categories.index');
        Route::get('app-categories-asdasd4sa6dsa5a4sd65sa4d6', 'AppCategoryController@app_categories_test');

        Route::post('categories/add-home-categories', 'AppCategoryController@add_home_categories');
        Route::post('categories/add-sidebar-categories', 'AppCategoryController@add_sidebar_categories');

        Route::get('website-home', 'WebsiteHomeController@website_home')->name('admin.website-home.index');
        Route::post('website/add-home-data', 'WebsiteHomeController@add_home_data');
        Route::post('website/add-sidebar-categories', 'WebsiteHomeController@add_sidebar_categories');
        Route::post('website/update-note-in-website-home', 'WebsiteHomeController@update_note_in_website_home');
        Route::post('website/update-note-text-first-in-website-home', 'WebsiteHomeController@update_note_text_first_in_website_home');
        Route::post('website/update-note-text-second-in-website-home', 'WebsiteHomeController@update_note_text_second_in_website_home');



        Route::get('widget', 'WidgetController@index')->name('admin.widget.index');
        Route::get('widget/{id}/edit', 'WidgetController@edit')->name('admin.widget.edit');
        Route::post('widget/{id}/update', 'WidgetController@update')->name('admin.widget.update');


        Route::get('get-widget-ajax', 'WidgetController@get_widget_ajax');

        /*  End Category  */


        /*   chats   */

        Route::get('chats', 'ChatController@index')->name('admin.chats.index');
        Route::get('chats2', 'ChatController@index2')->name('admin.chats.index2');
        Route::get('get-paginate-chats', 'ChatController@get_paginate_chats');


        /*  notifications */
        Route::get('notifications', 'NotificationAdminController@index')->name('admin.notifications.index');
        Route::get('get-admin-notifications-ajax', 'NotificationAdminController@get_notification_ajax');
        Route::get('get-notifications-pagination', 'NotificationAdminController@get_notifications_pagination');
        Route::get('update-read-notification', 'NotificationAdminController@update_read_notification');

        /*  reports   */
        Route::get('reports', 'Report\ReportController@index')->name('admin.reports.index');
        Route::get('getReportOrderAjax', 'Report\ReportController@get_order_ajax');
        Route::get('getReportOrderData', 'Report\ReportController@get_report_data');


        /*   cities   */

        Route::get('cities', 'CityController@index')->name('admin.cities.index');
        Route::post('cities/add', 'CityController@store');
        Route::post('cities/update', 'CityController@update');
        Route::post('cities/delete', 'CityController@delete');
        Route::post('cities/execute-option' , 'CityController@execute_option');

        Route::get('get-cities-ajax', 'CityController@get_cities_ajax');





        /*   countries   */

        Route::get('countries', 'CountryController@index')->name('admin.countries.index');
        Route::post('countries/add', 'CountryController@store');
        Route::post('countries/update', 'CountryController@update');
        Route::post('countries/delete', 'CountryController@delete');
        Route::post('countries/execute-option' , 'CountryController@execute_option');
        Route::get('get-countries-ajax', 'CountryController@get_countries_ajax');


        /*   neighborhoods   */

        Route::get('neighborhoods', 'NeighborhoodController@index')->name('admin.neighborhoods.index');
        Route::post('neighborhoods/add', 'NeighborhoodController@store');
        Route::post('neighborhoods/update', 'NeighborhoodController@update');
        Route::post('neighborhoods/delete', 'NeighborhoodController@delete');
        Route::get('get-neighborhoods-ajax', 'NeighborhoodController@get_neighborhoods_ajax');


        /*   slider app   */

        Route::get('sliders', 'SliderAppController@index')->name('admin.sliders.index');
        Route::post('sliders/add', 'SliderAppController@store');
        Route::post('sliders/update', 'SliderAppController@update');
        Route::post('sliders/delete', 'SliderAppController@delete');
        Route::post('sliders/change-status', 'SliderAppController@change_status');

        Route::get('get-sliders-ajax', 'SliderAppController@get_sliders_ajax');

        /*  order bank */
        Route::get('bank-transfer', 'BankTransferController@index')->name('admin.order_bank.index');
        Route::post('bank-transfer/approve', 'BankTransferController@approve');
        Route::post('bank-transfer/reject', 'BankTransferController@reject');
        Route::get('get-order-bank-ajax', 'BankTransferController@get_order_bank_ajax');


        /*   attributes   */

        Route::get('attributes', 'AttributeController@index')->name('admin.attributes.index');
        Route::post('attributes/add', 'AttributeController@store');
        Route::post('attributes/update', 'AttributeController@update');
        Route::post('attributes/delete', 'AttributeController@delete');

        Route::get('get-attributes-ajax', 'AttributeController@get_attributes_ajax');


        /*   attribute values   */

        Route::get('attribute-values', 'AttributeValuesController@index')->name('admin.attribute_values.index');
        Route::post('attribute-values/add', 'AttributeValuesController@store');
        Route::post('attribute-values/update', 'AttributeValuesController@update');
        Route::post('attribute-values/delete', 'AttributeValuesController@delete');

        Route::get('get-attribute-values-ajax', 'AttributeValuesController@get_attribute_values_ajax');

        /*   Shipping Companies   */

        Route::get('shipping-companies', 'ShippingCompanyController@index')->name('admin.shipping_companies.index');
        Route::post('shipping-companies/add', 'ShippingCompanyController@store');
        Route::post('shipping-companies/update', 'ShippingCompanyController@update');
        Route::post('shipping-companies/delete', 'ShippingCompanyController@delete');
        Route::post('shipping-companies/change-status-for-user', 'ShippingCompanyController@change_show_for_user');

        Route::get('get-shipping-companies-ajax', 'ShippingCompanyController@get_shipping_companies_ajax');


        Route::get('shipping-company-cities/{shipping_company_country_id}', 'ShippingCompanyCityController@index');
        Route::post('shipping-company-cities/add', 'ShippingCompanyCityController@store');
        Route::post('shipping-company-cities/update', 'ShippingCompanyCityController@update');
        Route::post('shipping-company-cities/delete', 'ShippingCompanyCityController@delete');

        Route::get('get-shipping-company-cities-ajax', 'ShippingCompanyCityController@get_shipping_company_cities_ajax');
        // execute option
        Route::post('update-shipping-company-cities/execute-option' , 'ShippingCompanyCityController@execute_option');

        /*   brands   */

        Route::get('brands', 'BrandController@index')->name('admin.brands.index');
        Route::post('brands/add', 'BrandController@store');
        Route::post('brands/update', 'BrandController@update');
        Route::post('brands/delete', 'BrandController@delete');

        Route::get('get-brands-ajax', 'BrandController@get_brands_ajax');

        Route::get('mailing_list', 'MailingListController@index')->name('admin.mailing_list.index');
        Route::get('get-mailing-list-ajax', 'MailingListController@get_mailing_list_ajax');
        Route::get('download-excel-mailing-list', 'MailingListController@download_excel_mailing_list')->name('admin.mailing_list.download_excel_mailing_list');


        /*   brands   */


        Route::get('services', 'ServicesController@index')->name('admin.services.index');
        Route::post('services/add', 'ServicesController@store');
        Route::post('services/update', 'ServicesController@update');
        Route::post('services/delete', 'ServicesController@delete');
        Route::get('get-services-ajax', 'ServicesController@get_services_ajax');

        Route::get('cancel_reasons', 'CancelReasonsController@index')->name('admin.cancel_reasons.index');
        Route::post('cancel_reasons/add', 'CancelReasonsController@store');
        Route::post('cancel_reasons/update', 'CancelReasonsController@update');
        Route::post('cancel_reasons/delete', 'CancelReasonsController@delete');
        Route::get('get-cancel-reasons-ajax', 'CancelReasonsController@get_cancel_reasons_ajax');



        /*   banks   */

        Route::get('banks', 'BankController@index')->name('admin.banks.index');
        Route::post('banks/add', 'BankController@store');
        Route::post('banks/update', 'BankController@update');
        Route::post('banks/delete', 'BankController@delete');

        Route::get('get-banks-ajax', 'BankController@get_banks_ajax');

        /*   payment methods   */

        Route::get('payment-methods', 'PaymentMethodController@index')->name('admin.payment_methods.index');
        Route::post('payment-methods/update', 'PaymentMethodController@update');
        Route::post('payment-methods/change-status', 'PaymentMethodController@change_status');
        Route::get('get-payment-methods-ajax', 'PaymentMethodController@get_payment_methods_ajax');


        /*   coupons   */

        Route::get('coupons', 'CouponController@index')->name('admin.coupons.index');
        Route::post('coupons/add', 'CouponController@store');
        Route::post('coupons/update', 'CouponController@update');
        Route::post('coupons/delete', 'CouponController@delete');

        Route::get('get-coupons-ajax', 'CouponController@get_coupons_ajax');

        Route::get('check-automatic-coupon', 'CouponController@check_automatic_coupon');

        /*   products   */
        Route::get('products', 'ProductController@index')->name('admin.products.index');
        Route::get('products/create', 'ProductController@create');
        Route::post('products/add', 'ProductController@store');
        Route::get('products/{id}/edit', 'ProductController@edit');
        Route::post('products/update', 'ProductController@update');
        Route::post('products/delete', 'ProductController@delete');
        Route::get('import-product', 'Product\ImportProductController@import_product');


        Route::get('get-products-ajax', 'ProductController@get_products_ajax');
        Route::get('get-details-products-ajax', 'ProductController@get_remote_ajax_details_products');
        Route::get('get-sku-products-ajax', 'ProductController@get_remote_ajax_sku_products');
        Route::get('get-product-variations/{id}', 'ProductController@get_product_variations');

        Route::get('order_status', 'ProductController@order_status')->name('admin.order_status.index');
        Route::get('get_product_variations_ajax', 'ProductController@get_product_variations_ajax');
        Route::post('change_order_status', 'ProductController@change_order_status');
        Route::post('add_note', 'ProductController@add_note');



        /*  orders */
        Route::get('orders', 'OrderController@index')->name('admin.orders.index');
        Route::get('orders/{id}', 'OrderController@order_details');

        Route::post('order/shipping_policy', 'Order\ShipmentOrderController@shipping_policy');
        Route::get('order/print_shipping_policy', 'Order\ShipmentOrderController@print_shipping_policy');
        Route::post('order/cancel-shipping-policy', 'Order\ShipmentOrderController@cancel_shipping_policy');

        Route::post('order/update-order-product', 'Order\UpdateOrderProductController@update_order_product');
        Route::post('order/delete-order-product', 'Order\UpdateOrderProductController@delete_order_product');
        Route::post('order/add-product-to-order', 'Order\UpdateOrderProductController@add_product_to_order');

        // change order status
        Route::post('order/change-status', 'Order\ChangeOrderStatusController@change_status_by_admin');
        Route::post('order/execute-option' , 'Order\ChangeOrderStatusController@execute_option');

        Route::post('update-order-form-data', 'Order\UpdateOrderController@update_order_form_data');

        Route::get('order/print', 'OrderController@print_order');
        Route::get('order/print_multi', 'OrderController@print_multi_order');
        Route::get('order/download-excel', 'OrderController@download_excel_order');



        // invoice number
        Route::post('order-invoice/{order}', 'Order\OrderInvoiceController@store');

        // return order
        Route::get('approve-order-return/{order}' , 'Order\OrderReturnController@approve');
        Route::get('reject-order-return/{order}' , 'Order\OrderReturnController@reject');
        Route::post('send-return-order-note/{order}' , 'Order\OrderReturnController@send_return_order_note');

        Route::get('get-orders-ajax', 'OrderController@get_orders_ajax');
        Route::get('update-order-as-currency-type' , 'OrderController@update_order_as_currency_type');

        // some helper methods in order
        Route::get('get-city-by-country-id/{country_id}', 'CityController@get_city_by_country_id');
        Route::get('get-shipping-companies-by-city-id/{city_id}', 'ShippingCompanyController@get_shipping_companies_by_city_id');
        Route::get('get-payment-methods-by-shipping-company/{shipping_company_id}/{city_id}', 'PaymentMethodController@get_payment_methods_by_shipping_company');


        /*     report      */
        Route::get('store-statistics', 'Report\ReportController@store_statistics')->name('admin.store_statistics.index');
        Route::get('get-store-statistics-ajax', 'Report\ReportController@get_store_statistics_ajax');
        Route::get('download-excel-store-statistics', 'Report\ReportController@download_excel_store_statistics');
        Route::get('print-store-statistics', 'Report\ReportController@print_store_statistics');

        Route::get('store-bill', 'Report\ReportController@store_bill')->name('admin.store_bill.index');
        Route::get('get-store-bill-ajax', 'Report\ReportController@get_store_bill_ajax');
        Route::get('download-excel-store-bill', 'Report\ReportController@download_excel_store_bill');
        Route::get('print-store-bill', 'Report\ReportController@print_store_bill');

        Route::get('excel_test_product', 'Report\ReportController@excel_test_product');
        Route::post('excel_test_import_product', 'Report\ReportController@excel_test_import_product');




        Route::get('invoice', 'Report\ReportController@invoice')->name('admin.invoice.index');
        Route::get('get-invoice-ajax', 'Report\ReportController@get_invoice_ajax');
        Route::get('download-excel-invoice-bill', 'Report\ReportController@download_excel_invoice');
        Route::get('print-invoice', 'Report\ReportController@print_invoice');

        Route::get('invoice2', 'Report\ReportController@invoice2')->name('admin.invoice2.index');
        Route::get('get-invoice2-ajax', 'Report\ReportController@get_invoice2_ajax');
        Route::get('download-excel-invoice2-bill', 'Report\ReportController@download_excel_invoice2');
        Route::get('print-invoice2', 'Report\ReportController@print_invoice2');

        Route::get('coupon-bill', 'Report\ReportController@coupon_bill')->name('admin.coupon_bill.index');
        Route::get('get-coupon-bill-ajax', 'Report\ReportController@get_coupon_ajax');
        Route::get('download-excel-coupon-bill', 'Report\ReportController@download_excel_coupon');
        Route::get('print-coupon', 'Report\ReportController@print_coupon');

        Route::get('order-product-report', 'Report\OrderProductReportController@index')->name('admin.order_product_report.index');

        Route::get('report-sku', 'Report\SkuReportController@index')->name('admin.sku_report.index');
        Route::get('report-sku-ajax', 'Report\SkuReportController@get_report_sku_ajax');
        Route::get('download-excel-skyu-report', 'Report\SkuReportController@download_excel_sku_report');
        Route::get('print-sku-report', 'Report\SkuReportController@print_sku_report');
        /*   banners app   */

        Route::get('banners', 'BannerController@index')->name('admin.banners.index');
        Route::post('banners/add', 'BannerController@store');
        Route::post('banners/update', 'BannerController@update');
        Route::post('banners/delete', 'BannerController@delete');
        Route::post('banners/change-status', 'BannerController@change_status');

        Route::get('get-banners-ajax', 'BannerController@get_banners_ajax');

        /*   banners value app   */

        Route::post('banner-values/add', 'BannerController@store_banner_value');
        Route::post('banner-values/update', 'BannerController@update_banner_value');
        Route::post('banner-values/delete', 'BannerController@delete_banner_value');

        Route::get('get-banner-values-ajax', 'BannerController@get_banner_values_ajax');


        Route::resource('advertisements', 'AdvertisementController')->names([
            'index' => 'admin.advertisements.index'
        ]);

        // store
        Route::resource('stores', 'StoreController')->names([
            'index' => 'admin.stores.index'
        ]);
        Route::get('get-stores-ajax', 'StoreController@get_stores_ajax');


        /*  logs */
        Route::get('action-logs', 'ActionLogController@index')->name('admin.action_logs.index');
        Route::get('get-action-logs-ajax', 'ActionLogController@get_action_logs_ajax');

        /*  settings */
        Route::get('settings', 'SettingController@index')->name('admin.settings.index');
        Route::post('settings/update', 'SettingController@update');
        Route::post('settings/messages/update', 'SettingController@update_messages');
        Route::get('settings/messages', 'SettingController@messages')->name('admin.setting-messages.index');
        /*  test */
        Route::get('testadminn', 'NotificationAdminController@test');

        Route::post('upload_empty', function () {
            // return response()->json([]);
        });


        /*  Package */
        Route::resource('packages', 'PackageController')->names([
            'index' => 'admin.packages.index'
        ]);
        Route::get('get-packages-ajax', 'PackageController@get_packages_ajax');


        // select2 remote
        Route::get('get-remote-ajax-users', 'UserController@get_remote_ajax_users');
        Route::get('get-remote-ajax-products', 'ProductController@get_remote_ajax_products');
        Route::get('get-remote-ajax-categories', 'CategoryController@get_remote_ajax_categories');
        Route::get('get-remote-ajax-leaf-categories', 'CategoryController@get_remote_ajax_leaf_categories');


        /*  comments */
        Route::resource('comments', 'CommentController')->names([
            'index' => 'admin.comments.index'
        ]);
        Route::post('comments/change-status' , 'CommentController@change_status');
        Route::get('get-comments-ajax', 'CommentController@get_comments_ajax');
        Route::get('get-comments-status', 'CommentController@get_comments_status');


        /* contacts */
        Route::get('contacts', 'ContactController@index')->name('admin.contacts.index');
        Route::get('get-contacts-ajax', 'ContactController@get_contacts_ajax');


        /* notification */
        Route::get('notifications-user' , 'NotificationAppUserController@index')->name('admin.notifications-user.index');
        Route::post('send-notifications-user' , 'NotificationAppUserController@send_notifications');

        // galleries
        Route::resource('galleries' , 'GalleryController')->names(['index' => 'admin.galleries.index']);
        Route::get('get-remote-galleries' , 'GalleryController@get_remote_gallery');

        // gallery types
        Route::get('get-remote-gallery-types' , 'GalleryTypeController@get_remote_gallery_types');


        Route::get('user_points', 'UserPointsController@index')->name('admin.user_points.index');
        Route::get('get-user-points-ajax', 'UserPointsController@get_user_point_ajax')->name('admin.user_points.indexAjax');
        Route::post('users/increase_point', 'UserPointsController@increase_point')->name('admin.user_points.increase_point');
        Route::get('download-excel-user-points', 'UserPointsController@download_excel_user_point')->name('admin.user_points.download_excel_user_point');


    });


    /*   ajax data */

    Route::get('getAdminAjax', 'AdminController@get_admin_ajax');
    Route::get('getUserAjax', 'UserController@get_user_ajax');


    /*  test   */
    Route::get('test', 'AdminController@test');
    Route::post('testupload', 'AdminController@testupload');
    Route::post('testupload2', function (\Request $request) {
        return response()->json("done", 200);
    });


});

// payments
Route::post('paytabs/complete', 'Website\PaymentController@complete_payment');


Route::get('my_fatoorah/complete', 'Website\PaymentController@complete_my_fatoorah');



Route::get('login', function () {

})->name('login');
/*  test  */

Route::get('testf', function () {

    $files = Illuminate\Support\Facades\File::allFiles(public_path()."/uploads/products");
    $arr = [];
    foreach ($files as $file) {
        $arr[] = pathinfo($file)['filename'];
    }
    $a = array_count_values($arr);
    $counts = array_filter($a, function($x) { return $x > 1; });
    return $counts;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('tesryu', 'Admin\TestController@test1');
Route::get('import', 'Admin\TestController@test2');
Route::post('import', 'Admin\TestController@test3');

Route::get('addc', function () {
    return Carbon\Carbon::createFromTimestamp(1587994699)->format('Y-m-d h:i a');

    $lang = 'ar';
    $payment_status = true;
    $platform = "web";
    $pointer = ['name' => trans('website.go_back_checkout' , [] , $lang), 'url' => \LaravelLocalization::localizeUrl("/$lang/checkout")];
    $message = "العودة للمتجر";
    return view('website.notifications.payment', [
        'payment_status' => $payment_status, 'platform' =>$platform ,
        'pointer'=> $pointer , 'payment_message' => $message , '_lang_' => $lang
    ]);
    return Carbon\Carbon::createFromTimestamp(1579075374)->format('Y-m-d h:i a');
    ini_set('max_execution_time', 600); //300 seconds = 5 minutes
    set_time_limit(600);

    $data = json_decode(file_get_contents("https://saidalista.com/json/test.json"), true);

    foreach ($data as $p) {

        $country = App\Country::create([
            'name_ar' => $p['name'],
            'name_en' => $p['name'],
            'flag' => "",
            'iso3' => $p["iso3"],
            'iso2' => $p["iso2"],
            'phone_code' => $p["phone_code"],
            'currency' => $p["currency"],
            'capital_en' => $p["capital"],
            'capital_ar' => $p["capital"],
        ]);

        if (array_key_exists('states', $p)) {
            foreach ($p['states'] as $key => $asdf) {
                $cities = [];

                $state = App\State::create([
                    'name_ar' => $key,
                    'name_en' => $key,
                    'country_id' => $country->id,
                ]);

                foreach ($asdf as $city) {
                    $cities[] = ['name_en' => $city, 'name_ar' => $city, 'state_id' => $state->id];
                }
                if (count($cities) > 0) {
                    DB::table('cities')->insert($cities);
                }

            }
        }


    }

    return "done";
});

Route::get('testmail', function () {



    \Mail::send('email', [], function ($message) {
        $message->to("mohamg1995@gmail.com", 'USER')->subject('Test Email');
        $message->from('raqshopsa@gmail.com');
    });
    echo("The massage email has been send");
});



Route::get('cou', function () {
//    phpinfo();

//    return Carbon\Carbon::createFromTimestamp(1583075198)->format('Y-m-d h:i:s a');
    /* $countries = file_get_contents("https://pkgstore.datahub.io/core/country-codes/country-codes_json/data/471a2e653140ecdd7243cdcacfd66608/country-codes_json.json");
     $countries = json_decode($countries, true);
     $data = [];
     foreach ($countries as $country) {
         if(!is_null($country['official_name_ar'])) {
             $get_curr = App\Models\Currency::where('code' , '=' ,$country['ISO4217-currency_alphabetic_code'] )->first();
             $data[] = [
                 'name_ar' => $country['official_name_ar'],
                 'name_en' => $country['official_name_en'],
                 'iso3' => $country['ISO3166-1-Alpha-3'],
                 'iso2' => $country['ISO3166-1-Alpha-2'],
                 'phone_code' => $country['Dial'],
                 'currency_id' => $get_curr ? $get_curr->id : null,
             ];
         }

     }
     App\Models\Country::insert($data);
     return $data;
    */
    $countries = App\Models\Country::with('currency')->get();
    return $countries;

    $a = file_get_contents("https://gist.githubusercontent.com/erdem/8c7d26765831d0f9a8c62f02782ae00d/raw/248037cd701af0a4957cce340dabb0fd04e38f4c/countries.json");
    $a = json_decode($a, true);
    foreach ($a as $key => $p) {
        $country = App\Models\Country::where('iso2', '=', $p['country_code'])->first();
        if ($country) {
            $country->timezone = $p['timezones'][0];
            $country->update();
        }

    }

});



Route::get('order_email/{id}', 'Website\UserController@order_email');

Route::get('log',function (){
    \Illuminate\Support\Facades\Log::info("AAAAAAA");
});