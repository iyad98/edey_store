@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')




    <div class="empty_product show_empty_cart">
        <div class="container">
            <div class="empty-container">
                <div>
                    <img src="/website/img/empty_product.svg" alt="...">
                    <div class="back-home text-center">
                        <p>لا يوجد منتجات  في سلة المشتريات </p><a href="{{LaravelLocalization::localizeUrl('/')}}">العودة الى الرئيسية</a>
                    </div>
                </div>


            </div>
        </div>
    </div>





    <div class="cart-page " id="cart-details-data">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">سلة المشتريات</li>
            </ol>
        </nav>
        <div class="cart-table-mobile">
            <table>
                <thead>
                <tr>
                    <td>المنتج</td>
                    <td>التفاصيل</td>
                    <td>الإجمالي</td>
                </tr>
                </thead>
                <tbody>


                <tr v-for="product in cart_data.products">
                    <td class="about-img">

                        <a :href="product.image"><img
                                    width="100" height="100"
                                    :src="product.image"
                                    class="lazyload"
                                    alt=""
                                    :srcset="product.image"
                                    sizes="(max-width: 300px) 100vw, 300px"></a>
                    </td>
                    <td>
                        <div class="name">

                            <a class="name" v-text="product.name + ' ( ' + get_attribute_values_name(product.attribute_values) +' ) '"
                               :href="'{{url('products')}}/'+product.id+'?cart_product_id='+product.cart_product_id">
                            </a>
                        </div>
                        <div class="price">


                            @{{product.currency}} @{{ product.price }} : سعر الوحدة
                        </div>
                        <div class="quantity-close">
                            <div class="quantity-box">

                                <div class="input-group quantity-btns">
                                    <button type="button" class="quantity-left-minus btn btn-number" data-type="minus" @click="product.quantity > 1 ? product.quantity = parseInt(product.quantity) - 1 : 1"
                                            data-field="">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <input type="text" name="quantity" v-model="product.quantity" title="Qty" class="form-control quantity input-number"
                                           step="1" min="0" max="20"  size="4" />

                                    <button type="button" class="quantity-right-plus btn btn-number" data-type="plus"
                                            data-field="" @click="product.quantity = parseInt(product.quantity) + 1">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>


                            </div>
                            <div class="remove-row">
                                <button @click="remove_product_from_cart(product.cart_product_id)" class="btn icon">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td>@{{product.currency}} @{{ product.final_total_price }}</td>
                </tr>


                </tbody>
            </table>
        </div>
        <div class="container">
            <div class="cart-table">
                <table>
                    <thead>
                    <tr>
                        <td>المنتج</td>
                        <td></td>
                        <td>السعر</td>
                        <td>الكمية</td>
                        <td class="total-td">الإجمالي</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in cart_data.products">
                        <td class="about-img">
                            <a :href="product.image"><img
                                        width="100" height="100"
                                        :src="product.image"
                                        class="lazyload"
                                        alt=""
                                        :srcset="product.image"
                                        sizes="(max-width: 300px) 100vw, 300px"></a>
                        </td>
                        <td class="product-name">
                            <a  class="product-name"  v-text="product.name + ' ( ' + get_attribute_values_name(product.attribute_values) +' ) '"
                               :href="'{{url('products')}}/'+product.id+'?cart_product_id='+product.cart_product_id">
                            </a>

                        </td>
                        <td>  @{{product.currency}} @{{ product.price }} </td>
                        <td class="quantity-box">




                            <div class="input-group quantity-btns">
                                <button type="button" class="quantity-left-minus btn btn-number" data-type="minus" @click="product.quantity > 1 ? product.quantity = parseInt(product.quantity) - 1 : 1"
                                        data-field="">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <input type="text" name="quantity" v-model="product.quantity" title="Qty" class="form-control quantity input-number"
                                       step="1" min="0" max="20"  size="4" />

                                <button type="button" class="quantity-right-plus btn btn-number" data-type="plus"
                                        data-field="" @click="product.quantity = parseInt(product.quantity) + 1">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                        </td>
                        <td>@{{ product.final_total_price }} @{{product.currency}}</td>
                        <td class="remove-row">
                            <button class="btn icon" @click="remove_product_from_cart(product.cart_product_id)">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>


                    </tbody>
                </table>
            </div>


            <button type="button" class="btn btn-secondary" name="" @click="update_quantity"
                    value="تحديث السلة">تحديث السلة
            </button>


            <div class="table-info1">
                <div class="discount-code">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" @keyup.enter="apply_coupon" v-model="coupon_code" placeholder="كود الخصم" aria-label=""
                               aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                            <button class="btn" @click="apply_coupon" type="button">تأكيد</button>
                        </div>
                    </div>
                </div>
                <div class="total-info">
                    <table>
                        <tbody>
                        <tr>
                            <td class="text-right">السعر</td>
                            <td>@{{ cart_data.price }}&nbsp; @{{ cart_data.currency }}</td>
                        </tr>

                        <tr  v-for="admin_discount in cart_data.admin_discounts" v-show="admin_discount.price > 0">
                            <td class="text-right" class="text-right" v-text="admin_discount.name"></td>
                            <td :data-title="admin_discount.name">
                                @{{ "-"+admin_discount.price }} @{{ cart_data.currency }}
                            </td>
                        </tr>


                        <tr  v-show="cart_data.package && cart_data.package.price > 0">
                            <td class="text-right">
                                <span v-text="'{{trans('admin.package_discount')}}' +' ( '+ (cart_data.package ? cart_data.package.name : '') +' ) '"></span>
                                <br>
                                <small v-text="cart_data.package && cart_data.package.free_shipping ? '{{trans('admin.package_free_shipping')}}': ''" ></small>
                            </td>
                            <td data-title="خصم الباقة">
                                <span>@{{ cart_data.package ? "-"+cart_data.package.price : 0 }}&nbsp;<span>@{{ cart_data.currency }}</span></span>
                            </td>
                        </tr>


                        <tr v-show="cart_data.coupon && cart_data.coupon.id != -1">
                            <td class="text-right">كوبون الخصم
                                ( <span v-text="cart_data.coupon && cart_data.coupon.id != -1 ? cart_data.coupon.coupon: '' "> </span> )
                            </td>
                            <td data-title="الكوبون"><span
                                       >@{{ "-"+cart_data.coupon_price }}&nbsp;<span>@{{ cart_data.currency }}</span></span>
                            </td>
                        </tr>
                        <tr  v-for="coupon in cart_data.coupons_automatic">
                            <td class="text-right">كوبون الخصم
                                ( <span v-text="coupon.coupon"> </span> )
                            </td>
                            <td data-title="الكوبون"><span>@{{ "-"+coupon.price }}&nbsp;
                                    <span>@{{ cart_data.currency }}</span></span>
                            </td>
                        </tr>

                        <tr  v-show="cart_data.first_order_discount > 0">
                            <td class="text-right">{{trans('admin.first_order_discount')}}</td>
                            <td data-title="{{trans('admin.first_order_discount')}}"><span
                                       >@{{ "-"+cart_data.first_order_discount}}&nbsp;<span
                                          >@{{ cart_data.currency }}</span></span>
                            </td>
                        </tr>

                        <tr >
                            <td class="text-right">اجمالي البضاعة بعد الخصم</td>
                            <td data-title="اجمالي البضاعة بعد الخصم">
                                <span>@{{ cart_data.price_after_discount_coupon }}&nbsp;<span>@{{ cart_data.currency }}</span></span>
                            </td>
                        </tr>
                        <tr >
                            <td class="text-right" v-text="cart_data.tax_text"></td>
                            <td :data-title="cart_data.tax_text"><span
                                       >@{{ cart_data.tax }}&nbsp;<span
                                            >@{{ cart_data.currency }}</span></span>
                            </td>
                        </tr>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td class="text-right">الإجمالي</td>
                            <td>
                                @{{ cart_data.total_price }}
                                <span>@{{ cart_data.currency }}</span>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="pay-btn">
                        <a href="{{LaravelLocalization::localizeUrl('checkout')}}">
                        <button  class="btn">
                        إدفع الآن
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()



@section('js')

    <script>
        var coupon_code = "{{$coupon_code}}";
    </script>
    <script src="{{url('')}}/website/general/js/cart/cart.js" type="text/javascript"></script>
@endsection