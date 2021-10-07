@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')

    <style>
        .woocommerce-MyAccount-navigation {
            float: right;
        }

        .woocommerce-MyAccount-content {
            width: 77%;
            float: left;
        }

        .pagination > .active > span {
            background: #2e3379 !important;
            border-color: #2e3379 !important;
        }

        .pagination > .active > span:hover {
            background: #2e3379 !important;
            border-color: #2e3379 !important;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .woocommerce .woocommerce-customer-details {
            margin: 0;
        }

        /* ****** 31_10 ****** */
        .label_restore {
            margin-top: 10px;
        }

        .product_rn {
            display: flex;
            border-bottom: 1px solid #ededed;
            padding-bottom: 5px;
        }

        .count_res {
            display: flex;
        }

        .count_res input {
            background-color: #f7f7f7;
            height: 30px;
            border-radius: 0;
            padding: 5px 15px;
            border: 1px solid #ededed;
            margin-right: 10px;
            align-self: center;
        }

        .confirmTxt {
            color: #f06274;
            margin-top: 10px;
        }
    </style>

@endpush


@section('content')
    <div class="page-header page_">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{$breadcrumb_title}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="breadcrumb">
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main" role="main">
                                <nav class="woocommerce-breadcrumb">
                                    @foreach($breadcrumb_arr as $breadcrumb)
                                        <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a>
                                    @endforeach

                                    {{$breadcrumb_last_item}}
                                </nav>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="" id="order">
        <div class="container">
            <div class="row">
                <div class="col-md-12 margin-t-b">
                    <div class="single-page">
                        <div class="row">
                            <div class="col-md-12 margin-t-b ">
                                <div class="single-img">
                                </div>

                            </div>
                            <div class="col-md-12 margin-t-b">
                                <div class="des-10">
                                    <div class="woocommerce">
                                        @include('website.my_account.menu')
                                        <div class="woocommerce-MyAccount-content">


                                            @if(isset($order_success) && !empty($order_success))
                                                <div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
                                                    {{$order_success}}
                                                </div>
                                            @endif

                                            <div class="woocommerce-notices-wrapper"></div>
                                            <p>{{trans('website.order_submitted')}} #
                                                <mark class="order-number">{{$order->id}}</mark>
                                                {{trans('website.in')}}
                                                <mark class="order-date">{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d h:i a')}}</mark>
                                                {{trans('website.now_in_status')}}
                                                <mark class="order-status"> {{trans_order_status()[$order->status]}}</mark>
                                                .
                                            </p>


                                            <section class="woocommerce-order-details">

                                                <h2 class="woocommerce-order-details__title">{{trans('website.order_details')}}</h2>

                                                <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

                                                    <thead>
                                                    <tr>
                                                        <th class="woocommerce-table__product-name product-name">
                                                            {{trans('website.product')}}
                                                        </th>
                                                        <th class="woocommerce-table__product-table product-total">
                                                            {{trans('website.total_price')}}
                                                        </th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($order->order_products as $product)
                                                        <tr class="woocommerce-table__line-item order_item">
                                                            <td class="product-name">
                                                                <span style="float: right;margin-left: 2px;">{{$product->product->name}}</span>
                                                                (
                                                                <span v-text="get_attribute_values_name('{{$product->product_attribute_values__}}')"></span>
                                                                )

                                                                <strong class="product-quantity">{{$product->price}}</strong>
                                                                <strong class="product-quantity">{{'×'.$product->quantity}}</strong>
                                                            </td>
                                                            <td class="product-total">
                                                                    <span class="woocommerce-Price-amount amount">{{$product->total_price}}
                                                                        <span
                                                                                class="woocommerce-Price-currencySymbol"
                                                                                v-text="'{{$order->currency->symbol}}'"></span></span>
                                                            </td>
                                                        </tr>

                                                    @endforeach

                                                    </tbody>

                                                    <tfoot>


                                                    <tr>
                                                        <th scope="row">{{trans('admin.order_price_before_discount')}}</th>
                                                        <td>
                                                            <span class="woocommerce-Price-amount amount">{{$order->price}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>
                                                        </td>
                                                    </tr>

                                                    @foreach($order->admin_discounts as $admin_discount)
                                                        @if($admin_discount->price > 0)
                                                            <tr>
                                                                <th style="direction: ltr"
                                                                    scope="row">{{trans('api.admin_discount' , ['discount_rate' => $admin_discount->discount_rate])}}</th>
                                                                <td>
                                                                    -<span class="woocommerce-Price-amount amount">{{$admin_discount->price}}
                                                                        &nbsp;<span
                                                                                class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                    @if($order->package_discount_price > 0)
                                                        <tr>
                                                            <th scope="row">
                                                                {{trans('admin.package_discount') . " ( " . ($order->package && $order->package->package ? $order->package->package->name : '') ." ) "}}

                                                                <br>
                                                                @if($order->package && $order->package->free_shipping == 1)
                                                                    <small>{{trans('admin.package_free_shipping')}}</small>
                                                                @endif
                                                            </th>
                                                            <td>
                                                            <span class="woocommerce-Price-amount amount">{{"-".$order->package_discount_price}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @foreach($order->coupon as $coupon)
                                                        <tr>
                                                            <th scope="row">{{trans('admin.coupon_value')}}
                                                                ( <span>{{$coupon->coupon_code}}</span> )
                                                            </th>
                                                            <td>
                                                                -<span class="woocommerce-Price-amount amount">{{$coupon->coupon_price}}
                                                                    &nbsp;<span
                                                                            class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <th scope="row">{{trans('admin.price_after_discount_coupon')}}</th>
                                                        <td>
                                                            <span class="woocommerce-Price-amount amount">{{$order->price_after_discount_coupon}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>&nbsp;<small
                                                                    class="shipped_via">
                                                            </small>
                                                        </td>
                                                    </tr>
                                                    @if($order->first_order_discount)
                                                        <tr class="tax-total">
                                                            <th>{{trans('admin.first_order_discount')}}</th>
                                                            <td data-title="{{trans('admin.first_order_discount')}}"><span
                                                                        class="woocommerce-Price-amount amount">{{$order->first_order_discount}}
                                                                    &nbsp;<span
                                                                            class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th scope="row">{{trans('admin.shipping')}}
                                                            ( {{ $order->shipping_text }}
                                                            )
                                                        </th>
                                                        <td>
                                                            <span class="woocommerce-Price-amount amount">{{$order->shipping == 0 ? trans('admin.free_shipping'): $order->shipping}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->shipping == 0 ? "" : get_currency()}}</span></span>&nbsp;<small
                                                                    class="shipped_via">
                                                            </small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{trans('admin.cash_fees')}}</th>
                                                        <td>
                                                            <span class="woocommerce-Price-amount amount">{{$order->cash_fees}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>&nbsp;<small
                                                                    class="shipped_via">
                                                            </small>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th scope="row">{{trans('admin.price_before_tax')}}</th>
                                                        <td>
                                                            <span class="woocommerce-Price-amount amount">{{$order->price_before_tax}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row"
                                                            style="direction: ltr">{{trans('api.tax_text' , ['tax' => $order->tax_percentage])}}</th>
                                                        <td>
                                                            <span class="woocommerce-Price-amount amount">{{$order->tax}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{trans('website.payment_method')}}</th>
                                                        <td>{{$order->payment_method->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{trans('admin.total_price')}}</th>
                                                        <td>
                                                            <span class="woocommerce-Price-amount amount">{{$order->total_price}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span></span>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>

                                            </section>

                                            <section class="woocommerce-customer-details">

                                                <div class="alert show_return_order_product {{in_array($order->status , [6 , 9 , 10]) ? '': 'hidden'}}" style="color: blue;">
                                                    تم تقديم طلب الاسترجاع في
                                                    <span v-text="order.return_order_at"></span>
                                                </div>
                                                <section
                                                        class="woocommerce-customer-details col-md-6 return_order_product_section {{in_array($order->status , [6 , 9 , 10]) ? 'hidden': ''}}">
                                                    <section
                                                            class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses addresses">
                                                        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
                                                            <h2 class="woocommerce-column__title">استرجاع المنتجات </h2>
                                                            <p class="label_restore">اختر المنتجات المراد استرجاعها (يحق
                                                                لك استرجاع المنتجات فقط خلال <span class="confirmTxt">{{$return_order_time}} أيام</span>
                                                                من تاريخ الطلب)</p>
                                                            <div class="product_restore">
                                                                @foreach($order->order_products as $order_product)
                                                                    <div class="product_rn">
                                                                        <p class="form-row terms wc-terms-and-conditions">
                                                                            <label class="woocommerce-form_label woocommerce-form_label-for-checkbox checkbox">
                                                                                <input type="checkbox"
                                                                                       value="{{$order_product->id}}"
                                                                                       name="return_products"
                                                                                       class="return_products woocommerce-form_input woocommerce-form_input-checkbox input-checkbox">
                                                                                <span>
                                                                                    {{$order_product->product->name}}
                                                                                      (
                                                                <span v-text="get_attribute_values_name('{{$order_product->product_attribute_values__}}')"></span>
                                                                )
                                                                                </span>
                                                                            </label>
                                                                            <input type="hidden" name="terms-field"
                                                                                   value="1">
                                                                            <input type="hidden"
                                                                                   id="get_order_id_hidden"
                                                                                   value="{{$order->id}}">
                                                                        </p>
                                                                    </div><!-- end-->
                                                                @endforeach

                                                            </div>
                                                            <p class="confirmTxt">اضغط تأكيد للاسترجاع</p>
                                                            <button type="button" @click="return_order"
                                                                    :disabled="loading"
                                                                    name="woocommerce_checkout_place_order"
                                                                    id="place_order" value="تأكيد الطلب"
                                                                    data-value="تأكيد الطلب" class="button alt">
                                                                <i v-show="loading" class="fa fa-spin fa-spinner"></i>
                                                                تأكيد

                                                            </button>

                                                        </div>
                                                    </section>
                                                </section>

                                                <section
                                                        class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses addresses col-md-6">
                                                    <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">


                                                        <h2 class="woocommerce-column__title">{{trans('website.shipping_address')}}</h2>

                                                        <address>
                                                            {{$order->order_user_shipping->first_name . " ".$order->order_user_shipping->last_name}}
                                                            <br>{{$order->order_user_shipping && $order->order_user_shipping->shipping_city ? $order->order_user_shipping->shipping_city->name : ""}}
                                                            <br>{{$order->order_user_shipping->address}}<br>

                                                            <p class="woocommerce-customer-details--phone">{{$order->order_user_shipping->phone}}</p>
                                                            <p class="woocommerce-customer-details--email">
                                                                {{$order->order_user_shipping->email}}</p>

                                                            @if(!empty($order->order_user_shipping->billing_national_address))
                                                                <p class="woocommerce-customer-details">{{trans('website.national_address')}}
                                                                    : {{$order->order_user_shipping->billing_national_address}}</p>
                                                            @endif

                                                            @if(!empty($order->order_user_shipping->billing_building_number))
                                                                <p class="woocommerce-customer-details">{{trans('website.building_number')}}
                                                                    : {{$order->order_user_shipping->billing_building_number}}</p>
                                                            @endif

                                                            @if(!empty($order->order_user_shipping->billing_postalcode_number))
                                                                <p class="woocommerce-customer-details">{{trans('website.postalcode_number')}}
                                                                    : {{$order->order_user_shipping->billing_postalcode_number}}</p>
                                                            @endif

                                                            @if(!empty($order->order_user_shipping->billing_unit_number))
                                                                <p class="woocommerce-customer-details">{{trans('website.unit_number')}}
                                                                    : {{$order->order_user_shipping->billing_unit_number}}</p>
                                                            @endif

                                                            @if(!empty($order->order_user_shipping->billing_extra_number))
                                                                <p class="woocommerce-customer-details">{{trans('website.extra_number')}}
                                                                    : {{$order->order_user_shipping->billing_extra_number}}</p>
                                                            @endif
                                                        </address>


                                                    </div><!-- /.col-1 -->

                                                </section>

                                            </section>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        var order = {!! $order !!};
    </script>
    <script src="{{url('')}}/website/general/js/user/order.js" type="text/javascript"></script>

@endpush