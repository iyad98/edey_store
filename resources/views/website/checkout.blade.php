@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
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
        table.cart td.actions .input-text {
            width: 126px !important;
            border: 1px solid #d3ced2;
            padding: 6px 6px 5px;
            margin: 0 0 0 4px;
        }
        #map {
            height: 500px;
            width: 100%;
        }

        .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            font-family: Roboto;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 29%;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 235px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
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
    <div class="show_cart_data hidden">
        <div class="container">
            <div class="row" id="cart-details-data">
                <div class="col-md-12 margin-t-b">
                    <div class="single-page">
                        <ul class="msg woocommerce-error hidden" role="alert" v-show="error_msg != ''">
                            <li><strong>خطأ:</strong> @{{ error_msg }}</li>
                        </ul>


                        <div v-show="success_msg != ''"
                             class="msg hidden woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
                            @{{ success_msg }}
                        </div>

                        <div class="row">
                            <div class="col-md-12 margin-t-b ">
                                <div class="single-img">
                                </div>

                            </div>
                            <div class="col-md-12 margin-t-b">
                                <div class="des-10">
                                    <div class="woocommerce">
                                        <div class="woocommerce-notices-wrapper"></div>
                                        <form class="checkout_coupon" method="post" style="display:none">

                                            <p class="form-row form-row-first">
                                                <input type="text" name="coupon_code" class="input-text"
                                                       placeholder="رمز القسيمة" id="coupon_code" value="">
                                            </p>

                                            <p class="form-row form-row-last">
                                                <button type="submit" class="button" name="apply_coupon"
                                                        value="استخدام القسيمة">استخدام القسيمة
                                                </button>
                                            </p>

                                            <div class="clear"></div>
                                        </form>
                                        <div class="woocommerce-notices-wrapper"></div>

                                        <form @submit.prevent id="add_order_form" name="checkout"
                                              class="checkout woocommerce-checkout"
                                              action="" enctype="multipart/form-data"
                                              novalidate="novalidate">


                                            <div class="col2-set" id="customer_details">
                                                <div class="col-md-6 col-style">
                                                    <h3 id="order_review_heading">طلبك</h3>
                                                    <div id="order_review" class="woocommerce-checkout-review-order">
                                                        <table class="shop_table woocommerce-checkout-review-order-table">
                                                            <thead>
                                                            <tr>
                                                                <th class="product-name">المنتج</th>
                                                                <th class="product-total">الإجمالي</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr class="cart_item" v-for="product in cart_data.products">
                                                                <td class="product-name">
                                                                    <label  v-text="product.name" > </label>
                                                                    {{--
                                                                    (
                                                                    <span v-text="get_attribute_values_name(product.attribute_values)"></span>
                                                                    )
                                                                    --}}
                                                                    (
                                                                    <strong v-text="product.price"></strong>
                                                                    <strong class="product-quantity"
                                                                            v-text="'×'+product.quantity"></strong>
                                                                    )
                                                                </td>
                                                                <td class="product-total">
                                                                    <span class="woocommerce-Price-amount amount"
                                                                          v-text="product.final_total_price"><span
                                                                                class="woocommerce-Price-currencySymbol"
                                                                                v-text="product.currency"></span></span>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                            <tfoot>

                                                            <tr class="cart-subtotal">
                                                                <th>إجمالي السعر الاصلي</th>
                                                                <td data-title="المجموع"><span
                                                                            class="woocommerce-Price-amount amount">@{{ cart_data.price }}&nbsp;<span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>

                                                                </td>

                                                            </tr>

                                                            <tr class="tax-total"
                                                                v-for="admin_discount in cart_data.admin_discounts"
                                                                v-show="admin_discount.price > 0">
                                                                <th style="direction: ltr"
                                                                    v-text="admin_discount.name"></th>
                                                                <td :data-title="admin_discount.name"><span
                                                                            class="woocommerce-Price-amount amount">
                                                                        <span>@{{ "-"+admin_discount.price }}</span>
                                                                        <span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                                </td>
                                                            </tr>

                                                            <tr class="cart-subtotal"
                                                                v-show="cart_data.package && cart_data.package.price > 0">
                                                                <th>
                                                                    <span v-text="'{{trans('admin.package_discount')}}' +' ( '+ (cart_data.package ? cart_data.package.name : '') +' ) '"></span>
                                                                    <br>
                                                                    <small v-text="cart_data.package && cart_data.package.free_shipping ? '{{trans('admin.package_free_shipping')}}': ''"></small>
                                                                </th>
                                                                <td :data-title="'{{trans('admin.package_discount')}}' +' ( '+ (cart_data.package ? cart_data.package.name : '') +' ) '"><span
                                                                            class="woocommerce-Price-amount amount">@{{ cart_data.package ? "-"+cart_data.package.price : 0 }}&nbsp;<span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>


                                                                </td>
                                                            </tr>

                                                            <tr class="tax-total"
                                                                v-show="cart_data.coupon && cart_data.coupon.id != -1">
                                                                <th>{{trans('admin.coupon')}}
                                                                    (<span v-text="cart_data.coupon && cart_data.coupon.id != -1 ? cart_data.coupon.coupon: '' "> </span>)
                                                                    <span v-show="cart_data.coupon && cart_data.coupon.id "
                                                                          v-text="'['+ (cart_data.coupon ? cart_data.coupon.type_text : '')+']'"></span>
                                                                </th>
                                                                <td data-title="الكوبون"><span
                                                                            class="woocommerce-Price-amount amount">@{{ "-"+cart_data.coupon_price }}&nbsp;<span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                                </td>
                                                            </tr>
                                                            <tr class="tax-total"
                                                                v-for="coupon in cart_data.coupons_automatic">
                                                                <th>{{trans('admin.coupon')}}
                                                                    ( <span v-text="coupon.coupon"> </span> )
                                                                    <span v-show="coupon.type == 'free_shipping'"
                                                                          v-text="'['+coupon.type_text+']'"></span>

                                                                </th>
                                                                <td data-title="الكوبون"><span
                                                                            class="woocommerce-Price-amount amount">@{{ "-"+coupon.price }}&nbsp;<span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                                </td>
                                                            </tr>
                                                            <tr class="tax-total"
                                                                v-show="cart_data.first_order_discount > 0">
                                                                <th>{{trans('admin.first_order_discount')}}</th>
                                                                <td data-title="{{trans('admin.first_order_discount')}}"><span
                                                                            class="woocommerce-Price-amount amount">@{{ "-"+cart_data.first_order_discount}}&nbsp;<span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                                </td>
                                                            </tr>
                                                            <tr class="tax-total">
                                                                <th>اجمالي البضاعة بعد الخصم</th>
                                                                <td data-title="اجمالي البضاعة بعد الخصم"><span
                                                                            class="woocommerce-Price-amount amount">@{{ cart_data.price_after_discount_coupon }}&nbsp;<span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                                </td>
                                                            </tr>
                                                            <tr class="tax-total shipping_data"
                                                                v-show="cart_data.shipping_company && cart_data.shipping_company.id != -1">
                                                                <th>  {{trans('admin.shipping')}} <span
                                                                            v-text="cart_data.shipping_company ? (cart_data.shipping_company.to_price_text) : ''"></span>
                                                                </th>
                                                                <td data-title="الشحن"><span
                                                                            class="woocommerce-Price-amount amount"><span
                                                                                v-text="cart_data.shipping == 0 ? '{{trans('admin.free_shipping')}}':cart_data.shipping "></span>
                                                                        <span
                                                                                class="woocommerce-Price-currencySymbol"
                                                                                v-text="cart_data.shipping == 0 ? '':cart_data.currency "></span></span>
                                                                </td>
                                                            </tr>

                                                            <tr class="tax-total tax_data"
                                                                v-show="cart_data.cash_value != 0">
                                                                <th>رسوم الدفع عند الاستلام (ثابتة)</th>
                                                                <td data-title="الشحن"><span
                                                                            class="woocommerce-Price-amount amount">
                                                                        <span style="float: right">@{{ cart_data.cash_value }}</span><span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                                </td>
                                                            </tr>
                                                            <tr class="tax-total">
                                                                <th>الاجمالي قبل الضريبة</th>
                                                                <td data-title="الاجمالي قبل الضريبة"><span
                                                                            class="woocommerce-Price-amount amount">
                                                                        <span>@{{ cart_data.price_before_tax }}</span>
                                                                        <span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                                </td>
                                                            </tr>
                                                            <tr class="tax-total">
                                                                <th style="direction: ltr"
                                                                    v-text="cart_data.tax_text"></th>
                                                                <td data-title="الضرائب"><span
                                                                            class="woocommerce-Price-amount amount">
                                                                        <span>@{{ cart_data.tax }}</span>
                                                                        <span
                                                                                class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                                </td>
                                                            </tr>
                                                            <tr class="order-total">
                                                                <th>إجمالي الفاتورة المطلوبة من العميل</th>
                                                                <td data-title="الإجمالي"><strong><span
                                                                                class="woocommerce-Price-amount amount"><span
                                                                                    v-text="cart_data.total_price"></span> <span
                                                                                    class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span></strong>
                                                                </td>
                                                            </tr>


                                                            </tfoot>
                                                        </table>

                                                        <div id="payment" class="woocommerce-checkout-payment">
                                                            <ul class="wc_payment_methods payment_methods methods">
                                                                @if(optional($payment_methods->where('key' , '=' , 'bank_transfer')->first())->status == 1)
                                                                    <li class="wc_payment_method payment_method_bacs">
                                                                        <input id="payment_method_bacs" type="radio"
                                                                               class="input-radio" name="payment_method"
                                                                               value="bank"
                                                                               data-order_button_text="">

                                                                        <label for="payment_method_bacs">
                                                                            حوالة مصرفية مباشرة </label>
                                                                        <div class="payment_box payment_method_bank hidden">
                                                                            <p>
                                                                                {!! $bank_note !!}
                                                                            </p>
                                                                        </div>
                                                                    </li>
                                                                @endif

                                                                @if(optional($payment_methods->where('key' , '=' , 'cash')->first())->status == 1)
                                                                    <li class="wc_payment_method payment_method_cod">
                                                                        <input id="payment_method_cod" type="radio"
                                                                               class="input-radio" name="payment_method"
                                                                               value="cod" data-order_button_text="">

                                                                        <label for="payment_method_cod">
                                                                            الدفع نقدًا عند الإستلام </label>
                                                                        <div class="payment_box payment_method_cod hidden">
                                                                            <p> {{$cash_note}} <span
                                                                                        v-text="cart_data.cash_value"></span>
                                                                                @{{ cart_data.currency }}</p>
                                                                        </div>
                                                                    </li>
                                                                @endif

                                                                @if(optional($payment_methods->where('key' , '=' , 'visa')->first())->status == 1)
                                                                    <li class="wc_payment_method payment_method_payfort">
                                                                        <input id="payment_method_payfort" type="radio"
                                                                               class="input-radio" name="payment_method"
                                                                               value="payfort"
                                                                               data-order_button_text="">

                                                                        <label for="payment_method_payfort">
                                                                            Credit / Debit Card <img
                                                                                    src="https://alfowzan.com/wp-content/plugins/payfort_fort/assets/images/cards.png"
                                                                                    alt="Credit / Debit Card"> </label>
                                                                        <div class="payment_box payment_method_payfort hidden">
                                                                            <input type="hidden"
                                                                                   id="payfort_fort_cc_integration_type"
                                                                                   value="merchantPage2"><input
                                                                                    type="hidden"
                                                                                    id="payfort_cancel_url"
                                                                                    value="https://alfowzan.com?wc-api=wc_gateway_payfort_fort_merchantPageCancel">
                                                                            <p>{{$visa_note}}</p>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                                @if(optional($payment_methods->where('key' , '=' , 'wallet')->first())->status == 1)
                                                                    <li class="wc_payment_method payment_method_wallet">
                                                                        <input id="payment_method_wallet" type="radio"
                                                                               class="input-radio" name="payment_method"
                                                                               value="wallet" data-order_button_text="">

                                                                        <label for="payment_method_wallet">
                                                                            الدفع بواسطة المحفظة
                                                                        </label>
                                                                        <div class="payment_box payment_method_wallet hidden">
                                                                            <p> {{$wallet_note}} <span
                                                                                        v-text="cart_data.cash_value"></span>
                                                                                @{{ cart_data.currency }}</p>
                                                                        </div>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                            <div class="form-row place-order">
                                                                <noscript>
                                                                    Since your browser does not support JavaScript, or
                                                                    it is disabled, please ensure you click the &lt;em&gt;Update
                                                                    Totals&lt;/em&gt; button before placing your order.
                                                                    You may be charged more than the amount stated above
                                                                    if you fail to do so. <br/>
                                                                    <button type="submit" class="button alt"
                                                                            name="woocommerce_checkout_update_totals"
                                                                            value="تحديث الإجمالي">تحديث الإجمالي
                                                                    </button>
                                                                </noscript>
                                                                <div class="alert alert-success">
                                                                    {{$checkout_label}}
                                                                </div>

                                                                <p class="form-row terms wc-terms-and-conditions">
                                                                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                                                        <input type="checkbox" value="1"
                                                                               class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                                                                               name="terms" id="terms"> <span>لقد قرأت وقبلت <a
                                                                                    href="{{url('privacy-policy')}}"
                                                                                    target="_blank"
                                                                                    class="woocommerce-terms-and-conditions-link">الشروط والأحكام</a></span>
                                                                        <span class="required">*</span>
                                                                    </label>
                                                                    <input type="hidden" name="terms-field" value="1">
                                                                </p>


                                                                <button type="button" class="button alt"
                                                                        @click="add_order"
                                                                        name="woocommerce_checkout_place_order"
                                                                        id="place_order" value="تأكيد الطلب"
                                                                        data-value="تأكيد الطلب">تأكيد الطلب
                                                                </button>

                                                                <input type="hidden" id="_wpnonce" name="_wpnonce"
                                                                       value="a89840337e"><input type="hidden"
                                                                                                 name="_wp_http_referer"
                                                                                                 value="/?wc-ajax=update_order_review">
                                                            </div>
                                                        </div>
                                                        <div class="blockUI" style="display:none"></div>
                                                        <div class="blockUI blockOverlay hidden"
                                                             style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; right: 0; background: rgb(255, 255, 255); opacity: 0.6; cursor: wait; position: absolute;"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-style">
                                                    <div class="woocommerce-billing-fields">

                                                        <input type="checkbox" id="select_gift" name="select_gift" value="1">
                                                        <label for="select_gift"> إهداء لشخص</label><br>

                                                        <h3>البيانات الاساسية</h3>
                                                        <div class="woocommerce-billing-fields__field-wrapper">
                                                            <p class="form-row form-row-first thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                               id="billing_first_name_field" data-priority="10"><label
                                                                        for="billing_first_name" class="">الاسم الأول&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.first_name"
                                                                            type="text" class="input-text "
                                                                            name="billing_first_name"
                                                                            id="billing_first_name" placeholder=""
                                                                            value="" autocomplete="given-name"></span>
                                                            </p>
                                                            <p class="form-row form-row-last thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                               id="billing_last_name_field" data-priority="20"><label
                                                                        for="billing_last_name" class="">الاسم الأخير&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.last_name"
                                                                            type="text" class="input-text "
                                                                            name="billing_last_name"
                                                                            id="billing_last_name" placeholder=""
                                                                            value="" autocomplete="family-name"></span>
                                                            </p>
                                                            <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-tel validate-required validate-phone"
                                                               id="billing_phone_field" data-priority="100"><label
                                                                        for="billing_phone" class="">الهاتف&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr>
                                                                    <i v-show="confrim_phone.steps == 3" class="fa fa-check-circle" style="color: green;font-size: 16px"></i>
                                                                </label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.phone"
                                                                            @keyup="check_change_phone"
                                                                            type="tel" class="input-text "
                                                                            name="billing_phone" id="billing_phone"
                                                                            placeholder="" value="" autocomplete="tel"></span>

                                                                <small style="color: blue;font-weight: bold">
                                                                    الرجاء ادخال الرقم بدون مقدمة الدولة , سيتم وضعها تلقائيا
                                                                </small>
                                                                <br>
                                                                <small>
                                                                    الرقم : <span v-text="phone_code"></span><span v-text="user_shipping.phone"></span>
                                                                </small>
                                                            </p>
                                                            <div class="row" v-show="confrim_phone.steps == 2" >
                                                                <div class="col-sm-8">
                                                                    <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-tel hidden show_hidden"
                                                                       data-priority="100"><label class="">الرجاء إدخال كود التحقق&nbsp;<abbr
                                                                                    class="required"
                                                                                    title="مطلوب">*</abbr></label><span
                                                                                class="woocommerce-input-wrapper"><input
                                                                                    type="tel" class="input-text "
                                                                                    id="confirm_code"
                                                                                    placeholder="" value=""></span>

                                                                    </p>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-tel hidden show_hidden"
                                                                       data-priority="100">
                                                                        <label class="">&nbsp;</label>
                                                                        <span class="woocommerce-input-wrapper">
                                                                           <button type="button" class="button alt"
                                                                                   @click="confirm_phone_code"
                                                                                   :disabled="confrim_phone.confirm_loading"
                                                                                   name="woocommerce_checkout_place_order">
                                                                        <i v-show="confrim_phone.confirm_loading" class="fa fa-spin fa-spinner hidden show_hidden"></i>
                                                                       تحقق
                                                                    </button>
                                                                        </span>

                                                                </div>
                                                            </div>
                                                            <button v-show="confrim_phone.steps == 1" type="button" class="button alt"
                                                                    @click="send_phone_code"
                                                                    :disabled="confrim_phone.loading"
                                                                    name="woocommerce_checkout_place_order">
                                                                <i v-show="confrim_phone.loading" class="fa fa-spin fa-spinner hidden show_hidden"></i>
                                                                تأكيد رقم الجوال
                                                            </button>
                                                            <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                               id="billing_email_field" data-priority="110"><label
                                                                        for="billing_email" class="">البريد الإلكتروني&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.email"
                                                                            type="email" class="input-text "
                                                                            name="billing_email" id="billing_email"
                                                                            placeholder="" value="fowzan@alfowzan.com"
                                                                            autocomplete="email username"></span></p>

                                                        </div>
                                                        <h3 v-text="is_gift ? 'بيانات المهدى اليه': 'تفاصيل الفاتورة'"></h3>
                                                        <div class="woocommerce-billing-fields__field-wrapper">
                                                            <p v-show="is_gift" class="form-row form-row-first thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                               id="gift_billing_first_name_field" data-priority="10"><label
                                                                        for="gift_billing_first_name_field" class="">الاسم الأول&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.gift_first_name"
                                                                            type="text" class="input-text "
                                                                            name="gift_billing_first_name"
                                                                            id="gift_billing_first_name" placeholder=""
                                                                            value="" autocomplete="given-name"></span>
                                                            </p>
                                                            <p v-show="is_gift" class="form-row form-row-last thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                               id="billing_last_name_field" data-priority="20"><label
                                                                        for="gift_billing_last_name" class="">الاسم الأخير&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.gift_last_name"
                                                                            type="text" class="input-text "
                                                                            name="gift_billing_last_name"
                                                                            id="gift_billing_last_name" placeholder=""
                                                                            value="" autocomplete="family-name"></span>
                                                            </p>
                                                            <p v-show="is_gift" class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                               id="gift_text_field" data-priority="110"><label
                                                                        for="gift_text" class="">نص الاهداء&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.gift_text"
                                                                            type="text" class="input-text "
                                                                            name="gift_text" id="gift_text"
                                                                            placeholder=""
                                                                    ></span></p>
                                                            <p class="form-row form-row-wide address-field update_totals_on_change thwcfd-field-wrapper thwcfd-field-country validate-required"
                                                               id="billing_country_field" data-priority="30"><label
                                                                        for="billing_country" class="">الدولة&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label>
                                                                <select class="js-example-basic-single select_country" id="select_country">
                                                                    @foreach($countries as $country)
                                                                        <option value="{{$country->iso2}}">{{$country->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </p>

                                                            <p class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                               id="billing_city_field" data-priority="40"
                                                               data-o_class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-text validate-required">
                                                                <label for="billing_city" class="">المدينة&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper">

                                                                    <select class="js-example-basic-single select_city"
                                                                            name="state">
                                                                        <option value="">اختر مدينتك</option>
                                                                        </select>
                                                                </span>
                                                            </p>
                                                            <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                               id="city2_field" data-priority="50"
                                                               style="display: none;"><label for="city2" class="">اخرى&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            type="text" class="input-text " name="city2"
                                                                            id="city2" placeholder="اسم المدينة"
                                                                            value=""></span></p>
                                                            <p class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                               id="billing_address_1_field" data-priority="60"><label
                                                                        for="billing_address_1" class="">عنوان الشارع و
                                                                    اسم الحي&nbsp;<abbr class="required"
                                                                                        title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.address"
                                                                            type="text" class="input-text "
                                                                            name="billing_address_1"
                                                                            id="billing_address_1"
                                                                            placeholder="عنوان الشارع و اسم الحي"
                                                                            value=""
                                                                            autocomplete="address-line1"></span></p>
                                                            <p class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-state validate-state"
                                                               id="billing_state_field" data-priority="80"
                                                               data-o_class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-state validate-state">
                                                                <label for="billing_state" class="">المحافظة&nbsp;<span
                                                                            class="optional">(اختياري)</span></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.state"
                                                                            type="text" class="input-text " value=""
                                                                            placeholder="" name="billing_state"
                                                                            id="billing_state"
                                                                            autocomplete="address-level1"></span></p>
                                                            <p v-show="is_gift" class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-tel validate-required validate-phone"
                                                               id="gift_billing_phone_field" data-priority="100"><label
                                                                        for="gift_billing_phone_field" class="">الهاتف&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr>
                                                                </label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.gift_target_phone"
                                                                            type="tel" class="input-text "
                                                                            name="gift_billing_phone" id="gift_billing_phone"
                                                                            placeholder="" value="" autocomplete="tel"></span>

                                                                <small style="color: blue;font-weight: bold">
                                                                    الرجاء ادخال الرقم بدون مقدمة الدولة , سيتم وضعها تلقائيا
                                                                </small>
                                                                <br>
                                                                <small>
                                                                    الرقم : <span v-text="phone_code"></span><span v-text="user_shipping.gift_target_phone"></span>
                                                                </small>

                                                            </p>

                                                            <p v-show="is_gift" class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                               id="gift_billing_email_field" data-priority="110"><label
                                                                        for="gift_billing_email" class="">البريد الإلكتروني&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.gift_target_email"
                                                                            type="email" class="input-text "
                                                                            name="gift_billing_email" id="gift_billing_email"
                                                                            placeholder=""
                                                                          ></span></p>
                                                            <p class="form-row form-row-wide billing_shipping_type thwcfd-field-wrapper thwcfd-field-select validate-required"
                                                               id="billing_shipping_type_field" data-priority="120">
                                                                <label for="billing_shipping_type" class="">شركة الشحن&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper">

                                                                <select class="js-example-basic-single select_shipping_company"
                                                                        name="state" id="select_shipping_company">
                                                                         <option value="">اختر شركة الشحن</option>

                                                                        </select>
                                                                </span>
                                                            </p>

                                                            <p v-show="billing_national_address"
                                                               class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                               id="billing_national_address" data-priority="110"><label
                                                                        for="billing_email" class="">العنوان الوطني&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.billing_national_address"
                                                                            type="email" class="input-text "
                                                                            name="billing_email"
                                                                            placeholder="" value="fowzan@alfowzan.com"
                                                                            autocomplete="email username"></span>
                                                            </p>
                                                            <p v-show="billing_building_number"
                                                               class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                               id="billing_building_number" data-priority="110"><label
                                                                        for="billing_email" class="">رقم
                                                                    المبنى&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.billing_building_number"
                                                                            type="email" class="input-text "
                                                                            name="billing_email"
                                                                            placeholder="" value="fowzan@alfowzan.com"
                                                                            autocomplete="email username"></span>
                                                            </p>
                                                            <p v-show="billing_postalcode_number"
                                                               class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                               id="billing_postalcode_number" data-priority="110"><label
                                                                        for="billing_email" class="">الرقم البريدي&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.billing_postalcode_number"
                                                                            type="email" class="input-text "
                                                                            name="billing_email" id="billing_email"
                                                                            placeholder="" value="fowzan@alfowzan.com"
                                                                            autocomplete="email username"></span>
                                                            </p>
                                                            <p v-show="billing_unit_number"
                                                               class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                               id="billing_unit_number" data-priority="110"><label
                                                                        for="billing_email" class="">رقم
                                                                    الوحدة&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.billing_unit_number"
                                                                            type="email" class="input-text "
                                                                            name="billing_email"
                                                                            placeholder="" value="fowzan@alfowzan.com"
                                                                            autocomplete="email username"></span>
                                                            </p>
                                                            <p v-show="billing_extra_number"
                                                               class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                               id="billing_extra_number" data-priority="110"><label
                                                                        for="billing_email" class="">الرقم الاضافي&nbsp;<abbr
                                                                            class="required"
                                                                            title="مطلوب">*</abbr></label><span
                                                                        class="woocommerce-input-wrapper"><input
                                                                            v-model="user_shipping.billing_extra_number"
                                                                            type="email" class="input-text "
                                                                            name="billing_email"
                                                                            placeholder="" value="fowzan@alfowzan.com"
                                                                            autocomplete="email username"></span>
                                                            </p>

                                                        </div>

                                                        <div style="width: 100%">
                                                            <input id="pac-input" class="controls" type="text"
                                                                   placeholder="{{trans('website.search_here')}}">
                                                            <div id="map"></div>
                                                    </div>

                                                </div>

                                            </div>
                                        </form>
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
        var coupon_code = "{{$coupon_code}}";
        var shipping_info = {!! $shipping_info !!};
        var country_code = {!! $country_code !!};
        var countries = {!! $countries !!};
        var confirm_phone_data=  {!! $confirm_phone_data !!};
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script src="{{url('')}}/website/general/js/checkout/checkout.js" type="text/javascript"></script>
    <script src="{{url('')}}/website/general/js/map.js" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places&callback=initMap"></script>

@endpush