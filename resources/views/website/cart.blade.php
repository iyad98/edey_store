@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')
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
            width: 126px!important;
            border: 1px solid #d3ced2;
            padding: 6px 6px 5px;
            margin: 0 0 0 4px;
        }
        .checkout-button {
            width: 100%;
            padding: 17px!important;
            text-align: center;
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
                                    @foreach($breadcrumb_arr as $key=>$breadcrumb)
                                        @if($key+1 == count($breadcrumb_arr))
                                            {{$breadcrumb['name']}}
                                        @else
                                            <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a>
                                        @endif
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
    <div class="show_empty_cart hidden">
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
                                        <div class="woocommerce-notices-wrapper"></div>
                                        <p class="cart-empty">سلة مشترياتك فارغة حاليًا.</p>
                                        <p class="return-to-shop">
                                            <a class="button wc-backward" href="{{url('shop')}}">
                                                العودة إلى المتجر </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="show_cart_data hidden" id="cart-details-data" style="margin-bottom: 30px;">
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
                                        <div class="woocommerce-notices-wrapper"></div>
                                        <form class="woocommerce-cart-form processing"
                                              action="https://alfowzan.com/cart/" method="post"
                                              style="position: relative; zoom: 1;">

                                            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents"
                                                   cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th class="product-remove">&nbsp;</th>
                                                    <th class="product-thumbnail">&nbsp;</th>
                                                    <th class="product-name">المنتج</th>
                                                    <th class="product-price">السعر</th>
                                                    <th class="product-quantity">الكمية</th>
                                                    <th class="product-subtotal">الإجمالي</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr v-for="product in cart_data.products"
                                                    class="woocommerce-cart-form__cart-item cart_item">

                                                    <td class="product-remove">
                                                        <a href="javascript:;" @click="remove_product_from_cart(product.cart_product_id)"
                                                           class="remove" aria-label="إزالة هذا المنتج"
                                                           data-product_id="2927"
                                                           data-product_sku="0PR0332-WH-000-00/32">×</a></td>

                                                    <td class="product-thumbnail"><a
                                                                :href="product.image"><img
                                                                    width="50" height="50"
                                                                    :src="product.image"
                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                    alt=""
                                                                    :srcset="product.image"
                                                                    sizes="(max-width: 300px) 100vw, 300px"></a></td>

                                                    <td class="product-name" data-title="المنتج"><a v-text="product.name + ' ( ' + get_attribute_values_name(product.attribute_values) +' ) '"
                                                                                                    :href="'{{url('products')}}/'+product.id+'?cart_product_id='+product.cart_product_id">
                                                        </a>
                                                    </td>

                                                    <td class="product-price" data-title="السعر">
                                                        <span class="woocommerce-Price-amount amount">@{{ product.price }}&nbsp;<span
                                                                    class="woocommerce-Price-currencySymbol">@{{product.currency}}</span></span>
                                                    </td>

                                                    <td class="product-quantity" data-title="الكمية">
                                                        {{--<div class="quantity">--}}
                                                            {{--<input class="minus" type="button" value="-" >--}}
                                                            {{--<input type="number" step="1" min="1" max="4182"--}}
                                                                   {{--name="" v-model="product.quantity"--}}
                                                                   {{--title="الكمية" class="input-text qty text"--}}
                                                                   {{--size="4" pattern="[0-9]*" inputmode="numeric">--}}
                                                            {{--<input class="plus" type="button" value="+" >--}}
                                                        {{--</div>--}}
                                                        <div class="quantity pr fl mr__10">
                                                            <input type="number" step="1" min="0" max="20" v-model="product.quantity"  title="Qty" class="input-text qty tc get_quantity" size="4">
                                                            <div class="qty tc">
                                                                <a class="plus" @click="product.quantity = parseInt(product.quantity) + 1" href="javascript:;">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                                <a class="minus" @click="product.quantity > 1 ? product.quantity = parseInt(product.quantity) - 1 : 1" href="javascript:;">
                                                                    <i class="fa fa-minus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="product-subtotal" data-title="الإجمالي">
                                                        {{-- @{{ get_total_price_after_discount(product)}}--}}
                                                        <span class="woocommerce-Price-amount amount">@{{ product.final_total_price }} &nbsp;<span
                                                                    class="woocommerce-Price-currencySymbol">@{{product.currency}}</span></span>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td colspan="6" class="actions">

                                                        <div class="coupon">
                                                            <label for="coupon_code">القسيمة:</label> <input type="text" @keyup.enter="apply_coupon" v-model="coupon_code"

                                                                                                             class="input-text"
                                                                                                             value=""
                                                                                                             placeholder="رمز القسيمة">
                                                            <input type="button"  class="button" @click="apply_coupon"
                                                                   value="استخدام القسيمة">
                                                        </div>

                                                        <button type="button" class="button" name="" @click="update_quantity"
                                                                value="تحديث السلة">تحديث السلة
                                                        </button>


                                                </tr>

                                                </tbody>
                                            </table>

                                            <div class="blockUI" style="display:none"></div>
                                            <div class="blockUI blockOverlay hidden"
                                                 style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; background: rgb(255, 255, 255); opacity: 0.6; cursor: wait; position: absolute;"></div>
                                            <div class="blockUI blockMsg blockElement hidden"
                                                 style="z-index: 1011; display: none; position: absolute; left: 585px; top: 139.5px;"></div>

                                        </form>

                                        <div class="cart-collaterals processing" style="position: relative; zoom: 1;">
                                            <div class="cart_totals ">


                                                <h2>إجمالي سلة المشتريات</h2>

                                                <table cellspacing="0" class="shop_table shop_table_responsive">

                                                    <tbody>
                                                    <tr class="cart-subtotal">
                                                        <th>إجمالي السعر الاصلي</th>
                                                        <td data-title="إجمالي السعر الاصلي"><span
                                                                    class="woocommerce-Price-amount amount">@{{ cart_data.price }}&nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                        </td>
                                                    </tr>

                                                    <tr class="tax-total" v-for="admin_discount in cart_data.admin_discounts" v-show="admin_discount.price > 0">
                                                        <th style="direction: ltr" v-text="admin_discount.name"></th>
                                                        <td :data-title="admin_discount.name"><span
                                                                    class="woocommerce-Price-amount amount">
                                                                <span>@{{ "-"+admin_discount.price }}</span>
                                                                <span
                                                                        class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                        </td>
                                                    </tr>


                                                    <tr class="cart-subtotal" v-show="cart_data.package && cart_data.package.price > 0">
                                                        <th>
                                                            <span v-text="'{{trans('admin.package_discount')}}' +' ( '+ (cart_data.package ? cart_data.package.name : '') +' ) '"></span>
                                                            <br>
                                                            <small v-text="cart_data.package && cart_data.package.free_shipping ? '{{trans('admin.package_free_shipping')}}': ''" ></small>
                                                        </th>
                                                        <td data-title="خصم الباقة"><span
                                                                    class="woocommerce-Price-amount amount">@{{ cart_data.package ? "-"+cart_data.package.price : 0 }}&nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                        </td>
                                                    </tr>

                                                    <tr class="tax-total" v-show="cart_data.coupon && cart_data.coupon.id != -1">
                                                        <th>كوبون الخصم
                                                            ( <span v-text="cart_data.coupon && cart_data.coupon.id != -1 ? cart_data.coupon.coupon: '' "> </span> )
                                                        </th>
                                                        <td data-title="الكوبون"><span
                                                                    class="woocommerce-Price-amount amount">@{{ "-"+cart_data.coupon_price }}&nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr class="tax-total" v-for="coupon in cart_data.coupons_automatic">
                                                        <th>كوبون الخصم
                                                            ( <span v-text="coupon.coupon"> </span> )
                                                        </th>                                                        <td data-title="الكوبون"><span
                                                                    class="woocommerce-Price-amount amount">@{{ "-"+coupon.price }}&nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                        </td>
                                                    </tr>

                                                    <tr class="tax-total" v-show="cart_data.first_order_discount > 0">
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
                                                    <tr class="tax-total">
                                                        <th style="direction: ltr" v-text="cart_data.tax_text"></th>
                                                        <td :data-title="cart_data.tax_text"><span
                                                                    class="woocommerce-Price-amount amount">@{{ cart_data.tax }}&nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span>
                                                        </td>
                                                    </tr>
                                                    <tr class="order-total">
                                                        <th>الإجمالي</th>
                                                        <td data-title="الإجمالي"><strong><span
                                                                        class="woocommerce-Price-amount amount">@{{ cart_data.total_price }}&nbsp;<span
                                                                            class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span></strong>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                                <div class="wc-proceed-to-checkout">

                                                    <a href="{{LaravelLocalization::localizeUrl('checkout')}}"
                                                       class="checkout-button button alt wc-forward">
                                                        التقدم لإنهاء الطلب</a>
                                                </div>


                                                <div class="blockUI" style="display:none"></div>
                                                <div class="blockUI blockOverlay hidden"
                                                     style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 60%; height: 100%; top: 0px; left: 0px; background: rgb(255, 255, 255); opacity: 0.6; cursor: wait; position: absolute;"></div>

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
    </div>


@endsection

@push('js')

    <script>
        var coupon_code = "{{$coupon_code}}";
    </script>
    <script src="{{url('')}}/website/general/js/cart/cart.js" type="text/javascript"></script>

@endpush