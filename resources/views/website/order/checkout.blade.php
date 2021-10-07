
@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection
<style>#sort_by_orderby {
        width: auto !important;
    }
    .gm-style .gm-style-iw-c {

        text-align: center;
    }
    select#select_country_user {
        width: 90px;
        margin-right: 6px;
    }
    .custom-map-control-button{
        width: 50px;
        height: 40px;
        left: 10px;
        top: 10px;
    }
</style>
@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')

    <!--Corona Header end-->
    <div class="send-form-page" id="cart-details-data">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('')}}">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">الدفع</li>
            </ol>
        </nav>
        <div class="container">
            <div class="alert alert-danger dan_alert hidden" role="alert">
            </div>
            <div class="alert alert-success suc_alert hidden" role="alert">
            </div>

            <div class="row">


                <div class="col-12 col-md-6">
                    <div class="col-12 payment-details">
                        <div class="head-title">
                            تفاصيل الفاتورة
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <input type="text" placeholder="الاسم الاول"  v-model="user_shipping.first_name">
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" placeholder="الاسم الثاني"   v-model="user_shipping.last_name">
                            </div>


                            <div class="col-12 col-md-12">

                                <input type="email" placeholder="البريد الالكتروني"   v-model="user_shipping.email">
                            </div>
                            <div class="col-12 col-md-9 phone-number">


                                <div style="display: flex">


                                <input type="tel" placeholder="5x xxx xxxx" v-if="phone_code_user == 'SA'" maxlength="9" minlength="9"  v-on:change="change_phone"  id="billing_phone"  v-model="user_shipping.phone">
                                <input type="tel" placeholder="5x xxx xxxx" v-if="phone_code_user != 'SA'"  v-on:change="change_phone"  id="billing_phone"  v-model="user_shipping.phone">

                                    <select class="custom-select bg-light select_country_user" v-model="phone_code_user" name="" id="select_country_user" >
                                        @foreach($countries as $country)
                                            <option value="{{$country->iso2}}">{{$country->phone_code}}</option>
                                        @endforeach
                                    </select>


                                </div>
                                <span id="error_phone_digit" style="color: red ; font-size: 12px;"> </span>
                                <br>

                                {{--<div class="phone-input">--}}


                                    {{--<input v-model="phone_code" disabled style="text-align: center"></input>--}}
                                {{--</div>--}}
                            </div>
                            <div class="col-12 col-md-3 varifay">
                                <button class="btn" id="varifay"  data-toggle="modal" data-target="#exampleModal"
                                        @click="send_phone_code">
                                    تحقق
                                </button>

                            </div>


                            <div class="col-12 col-md-12 mb-3">

                                        <div class="custom-control gift">

                                            <input type="checkbox" id="gift" name="gift"
                                                   class="gift" data-toggle="collapse" href="#giftformsdsfffsdf"
                                            >
                                            <label class="gift" for="gift">هل تريد اهداء هذا الطلب لشحص ما؟</label>




                                        </div>

                                 </div>




                            <div class="col-12 col-md-6">
                                <select class="custom-select bg-light select_country" name="country" id="select_country" >
                                    @foreach($countries as $country)
                                        <option value="{{$country->iso2}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">

                                <select class="custom-select select_city" name="state"  v-model="user_shipping.city" id="state"
                                >
                                    <option value="">{{trans('website.choose_your_city')}}</option>
                                </select>


                            </div>

                            <div class="col-12 col-md-6">
                                <input type="text" placeholder="عنوان الشارع و اسم الحي"  v-model="user_shipping.address">
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="text" placeholder="المحافطة (اختياري)"    v-model="user_shipping.state">
                            </div>

                            <div class="col-12 col-md-12">
                                <div id="accordionform">
                                    <div class="gift">

                                        <div class="description collapse row" id="giftformsdsfffsdf" data-parent="#accordionform">
                                            <div class="col-12 col-md-6">
                                                <input type="text" placeholder="الاسم الاول للمهدى"  name="gift_billing_first_name"  v-model="user_shipping.gift_first_name"  id="gift_billing_first_name">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <input type="text" placeholder="الاسم الثاني للمهدى"  name="gift_billing_last_name" v-model="user_shipping.gift_last_name"  id="gift_billing_last_name">
                                            </div>



                                            <div class="col-12 col-md-6 phone-number">
                                                <input type="tel" placeholder="5x xxx xxxx"
                                                       v-if="phone_code == '966'" maxlength="9" minlength="9"
                                                       v-model="user_shipping.gift_target_phone"   name="gift_billing_phone" id="gift_billing_phone">

                                                <input type="tel" placeholder="5x xxx xxxx"
                                                       v-if="phone_code != '966'"
                                                       v-model="user_shipping.gift_target_phone"   name="gift_billing_phone" id="gift_billing_phone">




                                                <div class="phone-input">
                                                    <input v-model="phone_code" disabled style="text-align: center"></input>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <input type="text" placeholder="نص الاهداء"   v-model="user_shipping.gift_text"
                                                       name="gift_text" id="gift_text" >
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <div class="col-12 col-md-12 ">
                                <select class="custom-select bg-light border-0 select_shipping_company"  name="shipped" id="select_shipping_company">
                                    <option value="">اختر شركة الشحن</option>
                                </select>
                            </div>



                            <div class="col-12">
                                <div id="map"></div>
                                <input type="hidden" v-model="lat" id="lat">
                                <input type="hidden" v-model="lng" id="lng">
                                <div class="form-row">
                                    <div class="col-12 mb-3 map-input" >

                                        <input type="text"  id="pac-input" class="controls"  placeholder="ابحث هنا">
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="col-12">
                        <div class="head-title">
                            طلبك
                        </div>
                        <div class="about-tables">
                            <table class="table1">
                                <thead>
                                <tr>
                                    <td>تفاصيل المنتج</td>

                                    <td class="txt-left p-30">السعر</td>


                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="product in cart_data.products">
                                    <td class="product-details">
                                        <div class="about-img">
                                            <img :src="product.thumb_image" alt="">
                                        </div>
                                        <div class="name-quantity">
                                            <h6 class="name">@{{ product.name }}</h6>
                                            <span class="quantity-no">الكمية: @{{ product.quantity }}</span>
                                        </div>
                                    </td>

                                    <td  class="price txt-left p-30">@{{ product.final_total_price }}</td>
                                    {{--@{{ product.currency }}--}}

                                </tr>

                                </tbody>
                            </table>
                            <table class="table2">

                                <tbody>
                                <tr>
                                    <td>
                                        المبلغ
                                    </td>
                                    <td class="txt-left p-30">
                                        @{{ cart_data.price }}&nbsp;@{{ cart_data.currency }}
                                    </td>


                                </tr>

                                <tr v-for="admin_discount in cart_data.admin_discounts" v-show="admin_discount.price > 0">
                                    <td>
                                        @{{ admin_discount.name }}
                                    </td>
                                    <td class="txt-left p-30">
                                        @{{ "-"+admin_discount.price }}&nbsp;@{{ cart_data.currency }}
                                    </td>

                                </tr>

                                <tr  v-show="cart_data.package && cart_data.package.price > 0">
                                    <td v-text="'{{trans('admin.package_discount')}}' +' ( '+ (cart_data.package ? cart_data.package.name : '') +' ) '">
                                        <small v-text="cart_data.package && cart_data.package.free_shipping ? '{{trans('admin.package_free_shipping')}}': ''"></small>
                                    </td>
                                    <td class="txt-left p-30" style="text-align: left;">
                                        @{{ cart_data.package ? "-"+cart_data.package.price : 0 }} @{{ cart_data.currency }}
                                    </td>
                                </tr>




                                <tr
                                    v-show="cart_data.coupon && cart_data.coupon.id != -1">
                                    <td>{{trans('admin.coupon')}}
                                        (<span v-text="cart_data.coupon && cart_data.coupon.id != -1 ? cart_data.coupon.coupon: '' "> </span>)
                                        <span v-show="cart_data.coupon && cart_data.coupon.id "
                                              v-text="'['+ (cart_data.coupon ? cart_data.coupon.type_text : '')+']'"></span>
                                    </td>
                                    <td style="text-align: left;" data-title="الكوبون">@{{ "-"+cart_data.coupon_price }} @{{ cart_data.currency }}
                                    </td>
                                </tr>
                                <tr
                                    v-for="coupon in cart_data.coupons_automatic">
                                    <td>{{trans('admin.coupon')}}
                                        ( <span v-text="coupon.coupon"> </span> )
                                        <span v-show="coupon.type == 'free_shipping'"
                                              v-text="'['+coupon.type_text+']'"></span>

                                    </td>
                                    <td style="text-align: left;" data-title="الكوبون"><span
                                                class=" txt-left p-30">@{{ "-"+coupon.price }} @{{ cart_data.currency }}</span>
                                    </td>
                                </tr>
                                <tr
                                    v-show="cart_data.first_order_discount > 0">
                                    <td>{{trans('admin.first_order_discount')}}</td>
                                    <td style="text-align: left;" data-title="{{trans('admin.first_order_discount')}}">
                                        @{{ "-"+cart_data.first_order_discount}} @{{ cart_data.currency }}
                                    </td>
                                </tr>
                                <tr >
                                    <td>اجمالي البضاعة بعد الخصم</td>
                                    <td style="text-align: left;" data-title="اجمالي البضاعة بعد الخصم">
                                        @{{ cart_data.price_after_discount_coupon }}@{{ cart_data.currency }}
                                    </td>
                                </tr>

                                <tr
                                    v-show="cart_data.shipping_company && cart_data.shipping_company.id != -1">
                                    <td>  {{trans('admin.shipping')}} <span
                                                v-text="cart_data.shipping_company ? (cart_data.shipping_company.to_price_text) : ''"></span>
                                    </td>
                                    <td style="text-align: left;" data-title="الشحن"><span
                                                class=" txt-left p-30"><span
                                                    v-text="cart_data.shipping == 0 ? '{{trans('admin.free_shipping')}}':cart_data.shipping "></span>
                                                                        <span v-text="cart_data.shipping == 0 ? '':cart_data.currency "></span></span>
                                    </td>
                                </tr>

                                <tr
                                    v-show="cart_data.cash_value != 0">
                                    <td>رسوم الدفع عند الاستلام (ثابتة)</td>
                                    <td style="text-align: left;" data-title="الشحن">@{{ cart_data.cash_value }} @{{ cart_data.currency }}
                                    </td>
                                </tr>
                                <tr >
                                    <td>الاجمالي قبل الضريبة</td>
                                    <td style="text-align: left;" data-title="الاجمالي قبل الضريبة">@{{ cart_data.price_before_tax }}
                                                                       @{{ cart_data.currency }}
                                    </td>
                                </tr>
                                <tr class="tax-total">
                                    <td style="direction: ltr"
                                        v-text="cart_data.tax_text"></td>
                                    <td style="text-align: left;" data-title="الضرائب">@{{ cart_data.tax }}
                                                                        @{{ cart_data.currency }}
                                    </td>
                                </tr>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <td>
                                        الإجمالي
                                    </td>
                                    <td class="price txt-left p-30">
                                        @{{ cart_data.total_price }}
                                        <span>@{{ cart_data.currency }}</span>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 payment-method">
                        <div class="head-title">
                            طريقة الدفع
                        </div>
                        <div class="kind-of-payments">
                            <div id="accordion">


                                @if(optional($payment_methods->where('key' , '=' , 'bank_transfer')->first())->status == 1)

                                    <div class="choice bank_transfer">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio1" name="payment_method" value="bank"
                                                   class="custom-control-input" data-toggle="collapse" href="#bankTransfare"
                                            >
                                            <label class="custom-control-label" for="customRadio1">حوالة مصرفية
                                                مباشرة</label>

                                        </div>
                                        <div class="description collapse" id="bankTransfare" data-parent="#accordion">
                                            {!! $bank_note !!}
                                        </div>
                                    </div>
                                @endif


                                    @if(optional($payment_methods->where('key' , '=' , 'cash')->first())->status == 1)
                                        <div class="choice cash">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="customRadio2" name="payment_method"
                                                       class="custom-control-input" value="cod"  data-toggle="collapse" href="#directPay">
                                                <label class="custom-control-label" for="customRadio2">الدفع نقدا عند الاستلام
                                                </label>
                                            </div>
                                            <div class="description collapse" id="directPay" data-parent="#accordion">
                                                {{$cash_note}}

                                                <span v-text="cart_data.cash_value"></span>
                                                @{{ cart_data.currency }}
                                            </div>
                                        </div>
                                    @endif


                                    @if(optional($payment_methods->where('key' , '=' , 'visa')->first())->status == 1)
                                        <div class="choice visa">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="payment_method_payfort" name="payment_method"
                                                       class="custom-control-input" value="payfort"  data-toggle="collapse" href="#payment_method_payfort">
                                                <label class="custom-control-label" for="payment_method_payfort">
                                                    Credit / Debit Card
                                                </label>
                                            </div>
                                            <div class="description collapse" id="payment_method_payfort" data-parent="#accordion">
                                                {{$visa_note}}
                                            </div>
                                        </div>
                                    @endif




                            </div>
                            <div class="alert alert-danger" role="alert">
                                {{$checkout_label}}
                            </div>
                        </div>


                        <div class="pay-btn">


                            <button class="btn" v-show="confrim_phone.steps != 3"  data-toggle="modal" data-target="#exampleModal"  @click="send_phone_code">إدفع الآن</button>
                            <button class="btn loader_btn"  @click="add_order" v-show="confrim_phone.steps == 3"   > إدفع الآن
                                <span class="spinner-border spinner-border-sm loader_btn_icon" role="status" aria-hidden="true"></span>
                                <span class="sr-only">Loading...</span>

                            </button>

                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            <i class="fas fa-mobile-alt"></i>
                                            تأكيد رقم الجوال
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="model_api_data">تم ارسال كود تحقق إلى رقم الجوال المدرج في تفاصيل الفاتورة</p>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">كود التحقق</label>
                                            <input type="text" class="form-control"     id="confirm_code"
                                                   aria-describedby="emailHelp" placeholder="كود التحقق">
                                            <small id="error_code" style="color: red;"></small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn mt-0 mb-0 send-btn"     @click="confirm_phone_code"
                                                :disabled="confrim_phone.confirm_loading">تحقق الآن</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    @include('website.partals.services')
    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()

@section('js')
    <script src="{{url('')}}/website/general/js/shop/shop.js"></script>

    {{--<script>--}}
        {{--let map;--}}

        {{--function initMap() {--}}

            {{--var myLatLng = { lat:31.515287, lng: 34.451877 };--}}
            {{--var map = new google.maps.Map(document.getElementById('map'), {--}}
                {{--center: myLatLng,--}}
                {{--zoom: 13--}}
            {{--});--}}

            {{--var marker = new google.maps.Marker({--}}
                {{--position: myLatLng,--}}
                {{--map: map,--}}
                {{--title: 'Hello World!',--}}
                {{--draggable: true--}}
            {{--});--}}

            {{--google.maps.event.addListener(marker, 'dragend', function(marker) {--}}
                {{--var latLng = marker.latLng;--}}
                {{--$('#lat').val(latLng.lat())--}}
                {{--$('#lng').val(latLng.lng())--}}

            {{--});--}}

        {{--}--}}


    {{--</script>--}}


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

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrn6JmX_82ZZ2dr7UFsJdhte-0Bsdix-c&libraries=places&callback=initMap"></script>
    <script src="{{url('')}}/website/general/js/map.js" type="text/javascript"></script>


@stop()

