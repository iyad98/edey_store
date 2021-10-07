@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('')}}">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">عربة التسوق</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage hidden show_empty_cart">
        <div class="container">
            <div class="cart_empty_block">
                <img src="/website_v2/images/bag.svg" alt="bag">
                <p>عذرا، لا يوجد منتجات في عربة التسوق</p>
                <a href="{{asset('/')}}" class="btn m_pro_addCart"><i class="fal fa-shopping-cart"></i>تسوق الآن</a>
            </div>
        </div>
    </div>

    <div class="content_innerPage" id="cart-details-data">


        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table_st1">
                            <thead class="hide_xs">
                            <tr>
                                <th>المنتج</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th class="th_total">الإجمالي</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in cart_data.products">
                                <td>
                                    <div class="tb_product clearfix">
                                        <a :href="'{{LaravelLocalization::localizeUrl('products')}}/'+product.id"
                                           class="ppt_thumb">
                                            <img :src="product.image" alt="">


                                        </a>
                                        <div class="tb_txt">
                                            <h2>
                                                <a :href="'{{LaravelLocalization::localizeUrl('products')}}/'+product.id">@{{
                                                    product.name }}</a></h2>
                                            <div class="tb_sale hid_lg">@{{ product.price_after }}<span>@{{product.currency}}</span>
                                            </div>
                                            <span class="attr" v-for="attribute_values in product.attribute_values "> @{{ attribute_values.name }}</span>

                                        </div>
                                    </div>
                                    <div class="hid_lg">
                                        <div class="quantity_remove_mo">
                                            <div class="quantity">
                                                <input type="text" name="count-quat1" @change="update_quantity"
                                                       v-model="product.quantity" :id="'product_guantity_'+product.id"
                                                       class="jsQuantity count-quat">
                                                <div
                                                    @click="update_quantity(product.cart_product_id , product.quantity + 1 )"
                                                    class="btn button-count inc jsQuantityIncrease">
                                                    <i class="far fa-plus"></i>
                                                </div>
                                                <div
                                                    @click="update_quantity(product.cart_product_id , product.quantity - 1 )"
                                                    class="btn button-count dec jsQuantityDecrease " minimum="1">
                                                    <i class="far fa-minus"></i>
                                                </div>
                                            </div>
                                            <button @click="remove_product_from_cart(product.cart_product_id)"
                                                    class="btn_tb_remove"><i class="fal fa-times"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td class="hide_xs">
                                    <div class="tb_sale">@{{ product.price_after }}<span>@{{product.currency}}</span>
                                    </div>
                                </td>
                                <td class="hide_xs">
                                    <div class="quantity">
                                        <input type="text" name="count-quat1" @change="update_quantity(product.id)"
                                               v-model="product.quantity" :id="'product_guantity_'+product.id"
                                               class="jsQuantity count-quat">
                                        <div @click="update_quantity(product.cart_product_id , product.quantity + 1 )"
                                             class="btn button-count inc jsQuantityIncrease ">
                                            <i class="far fa-plus"></i>
                                        </div>
                                        <div @click="update_quantity(product.cart_product_id , product.quantity - 1 )"
                                             class="btn button-count dec jsQuantityDecrease " minimum="1">
                                            <i class="far fa-minus"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="hide_xs">
                                    <div class="tb_sale">@{{ product.total_price }} <span>@{{product.currency}}</span>
                                    </div>
                                </td>
                                <td class="hide_xs">
                                    <button @click="remove_product_from_cart(product.cart_product_id)"
                                            class="btn_tb_remove"><i class="fal fa-times"></i></button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <form class="form_copon">
                        <input type="text" class="form-control discount-code" @keyup.enter="apply_coupon"
                               v-model="coupon_code" placeholder="كود الخصم">
                        <button type="button" @click="apply_coupon" class="btn btn_copon">تأكيد</button>
                    </form>
                    <div class="box_bill">
                        <div class="bill_details">
                            <div class="itm_rw_bill d-flex align-items-center">
                                <h3>السعر</h3>
                                <p class="mr-auto"> @{{ cart_data.price_with_tax }} </p>
                            </div>
                            {{--<div class="itm_rw_bill d-flex align-items-center">--}}
                            {{--<h3>تكلفة التوصيل</h3>--}}
                            {{--<p class="mr-auto">@{{ cart_data.shipping }}</p>--}}

                            {{--</div>--}}

                            <div class="itm_rw_bill d-flex align-items-center"
                                 v-for="coupon in cart_data.coupons_automatic">
                                <h3>{{trans('admin.coupon')}}
                                    ( <span v-text="coupon.coupon"> </span> )
                                    <span v-show="coupon.type == 'free_shipping'"
                                          v-text="'['+coupon.type_text+']'"></span>

                                </h3>
                                <p class="mr-auto" data-title="الكوبون">@{{ "-"+coupon.price
                                    }} {{-- @{{ cart_data.currency }} --}}
                                </p>
                            </div>


                            <div class="itm_rw_bill d-flex align-items-center"
                                 v-for="admin_discount in cart_data.admin_discounts" v-show="admin_discount.price > 0">
                                <h3>
                                    @{{ admin_discount.name }}
                                </h3>
                                <p class="mr-auto">
                                    @{{ "-"+admin_discount.price }}&nbsp;@{{ cart_data.currency }}
                                </p>

                            </div>

                            <div class="itm_rw_bill d-flex align-items-center" v-if="cart_data.coupon_price > 0">
                                <h3>قيمة الكوبون</h3>

                                <p class="mr-auto">@{{ "-"+cart_data.coupon_price }}</p>
                            </div>

                            <div class="itm_rw_bill d-flex align-items-center" v-if="cart_data.coupon_price > 0">
                                <h3> السعر بعد الخصم</h3>

                                <p class="mr-auto">@{{ cart_data.price_after_discount_coupon }}</p>
                            </div>

                            <div class="itm_rw_bill d-flex align-items-center" v-if="cart_data.shipping > 0">
                                <h3>تكاليف الشحن</h3>

                                <p class="mr-auto">@{{ cart_data.shipping }}</p>
                            </div>

                            <div class="itm_rw_bill d-flex align-items-center" v-if="cart_data.tax > 0">
                                <h3>الضريبة المضافة</h3>

                                <p class="mr-auto">@{{ cart_data.tax }}</p>
                            </div>
                        </div>


                        <div class="bill_ft">
                            <div class="total_rw_bill d-flex align-items-center">
                                <h3>الإجمالي</h3>
                                <p class="mr-auto">@{{cart_data.total_price }}<span>@{{ cart_data.currency }}</span></p>
                            </div>
                        </div>
                        <a href="{{LaravelLocalization::localizeUrl('checkout')}}"
                           class="btn btn-block btn_prim btn-lg">إدفع الآن</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('css')
@endsection

@section('js')
    <script>
        var coupon_code = "{{$coupon_code}}";
    </script>
    <script src="{{url('')}}/website/general/js/cart/cart.js" type="text/javascript"></script>
@endsection
