@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content')

    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">إنهاء الطلب</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage" id="cart-details-data">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 order-lg-12">
                    <h2 class="title_page">طلبك</h2>
                    <div class="tb_order_checkout">
                        <div class="block_table_details_order">
                            <div class="table-responsive">
                                <table class="table table_order">
                                    <thead>
                                    <tr>
                                        <th>تفاصيل المنتج</th>
                                        <th>السعر</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="product in cart_data.products">
                                        <td>
                                            <div class="order_itm_tb clearfix">
                                                <a :href="'{{LaravelLocalization::localizeUrl('products')}}/'+product.id"
                                                   class="thumb_order_tb">
                                                    <img :src="product.image" alt="">
                                                </a>
                                                <div class="txt_order_tb">
                                                    <h2>
                                                        <a :href="'{{LaravelLocalization::localizeUrl('products')}}/'+product.id">@{{
                                                            product.name }}</a></h2>
                                                    <p>الكمية: @{{ product.quantity }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @{{ product.price_after }}
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="block_table_details_order tb_total_checkout">
                            <div class="table-responsive">
                                <table class="table table_order">
                                    <tbody>
                                    <tr>
                                        <td>
                                            السعر
                                        </td>
                                        <td>
                                            @{{ cart_data.price }}
                                        </td>
                                    </tr>

                                    <tr
                                            v-for="coupon in cart_data.coupons_automatic">
                                        <td>{{trans('admin.coupon')}}
                                            ( <span v-text="coupon.coupon"> </span> )
                                            <span v-show="coupon.type == 'free_shipping'"
                                                  v-text="'['+coupon.type_text+']'"></span>

                                        </td>
                                        <td>@{{ "-"+coupon.price }} {{-- @{{ cart_data.currency }} --}}
                                        </td>
                                    </tr>

                                    <tr v-for="admin_discount in cart_data.admin_discounts"
                                        v-show="admin_discount.price > 0">
                                        <td>
                                            @{{ admin_discount.name }}
                                        </td>
                                        <td class="mr-auto">
                                            @{{ "-"+admin_discount.price }}
                                        </td>

                                    </tr>
                                    <tr
                                            v-show="cart_data.coupon && cart_data.coupon.id != -1">
                                        <td>{{trans('admin.coupon')}}
                                            (<span v-text="cart_data.coupon && cart_data.coupon.id != -1 ? cart_data.coupon.coupon: '' "> </span>)
                                            <span v-show="cart_data.coupon && cart_data.coupon.id "></span>
                                        </td>
                                        <td>@{{ "-"+cart_data.coupon_price }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>اجمالي المبلغ بعد الخصم</td>
                                        <td>
                                            @{{ cart_data.price_after_discount_coupon }}
                                        </td>
                                    </tr>




                                    <tr v-if="cart_data.shipping > 0">
                                        <td>
                                            تكاليف الشحن
                                        </td>
                                        <td>
                                            @{{ cart_data.shipping }}
                                        </td>
                                    </tr>


                                    <tr v-show="cart_data.cash_value != 0">
                                        <td>رسوم الدفع عند الاستلام (ثابتة)</td>
                                        <td>@{{ cart_data.cash_value }}
                                        </td>
                                    </tr>

                                    <tr v-if="cart_data.tax > 0">
                                        <td>
                                            الضريبة المضافه
                                        </td>
                                        <td>
                                            @{{ cart_data.tax }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="order_total tb_total_last d-flex align-items-center">
                            <h3>الإجمالي</h3>
                            <p class="mr-auto">@{{cart_data.total_price }} @{{ cart_data.currency }} </p>
                        </div>
                        <div class="msg_thanks"><p><span class="msg_icon"><i
                                            class="fas fa-heart"></i></span>{{$checkout_label}}</p></div>
                    </div>
                </div>
                <div class="col-lg-8 order-lg-1">
                    <div class="alert alert-danger dan_alert hidden" role="alert">

                    </div>
                    <div class="alert alert-success suc_alert hidden" role="alert">

                    </div>

                    {{--<h2 class="title_page">تفاصيل الفاتورة</h2>--}}

                    <h2 class="title_page">طريقة الاستلام المفضلة لك</h2>
                    <div class="row">
                        <div v-for="shipping_company in shipping_companies" class="col-md-6">
                            <div class="form-group">
                                <div class="box_check_itm">
                                    <input type="radio" :class="'shipping_company_'+shipping_company.id"
                                           :value="shipping_company.id" class="radio_st"
                                           @change="update_billing(true , shipping_company.accept_user_shipping_address)"
                                           name="shipping_company">
                                    <div class="box_check_itm_cn clearfix"
                                         :class="'check_shipping_company_'+shipping_company.id">
                                        <div class="icon_check">
                                            <img :src="shipping_company.image_web" alt="">
                                        </div>
                                        <div class="txxt_check">
                                            <h3>@{{ shipping_company.name }}</h3>
                                            <p v-if="shipping_company.id == 1">خدمة مجانية</p>
                                            <p v-if="shipping_company.id != 1"> يوجد رسوم إضافية</p>
                                        </div>
                                    </div>
                                    <p class="show_div1">مدة الشحن : شهرين إلى ثلاث أشهر من تاريخ الطلب</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="order-dis hidden">
                        <div class="row">

                            @foreach($all_shipping_info as $shipping_info)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="box_check_itm">
                                            <input type="radio" class="radio_st" name="addresses" value="{{$shipping_info->id}}"
                                                   @change="update_billing(true )">
                                            <div class="box_check_itm_cn clearfix">
                                                <div class="txxt_check">
                                                    <ul>
                                                        <li>
                                                            <span>الاسم :</span> {{isset($shipping_info->first_name)?$shipping_info->first_name:'' }} {{isset($shipping_info->last_name)?$shipping_info->last_name:''}}
                                                        </li>
                                                        <li>
                                                            <span>رقم الجوال : </span> {{isset($shipping_info->phone)?$shipping_info->phone :'' }}
                                                        </li>

                                                        <li>
                                                            <span>المدينة :</span>{{ isset($shipping_info->shipping_city) ? $shipping_info->shipping_city['name'] : ''}} </li>
                                                            <span>القطعة :</span> {{isset($shipping_info->state)?$shipping_info->state:''}}

                                                        <li>
                                                            <span>الشارع : </span>{{isset($shipping_info->street)?$shipping_info->street:''}}
                                                            <span>الجادة : </span> {{isset($shipping_info->avenue)?$shipping_info->avenue :'' }}
                                                        </li>
                                                        <li>
                                                            <span>رقم المبني :</span> {{isset($shipping_info->building_number)?$shipping_info->building_number:''}}
                                                            <span>رقم الطابق :</span> {{isset($shipping_info->floor_number)?$shipping_info->floor_number:''}}
                                                        </li>
                                                        <li>
                                                            <span> رقم الشقة :</span> {{isset($shipping_info->apartment_number)?$shipping_info->apartment_number:''}}
                                                        </li>

                                                    </ul>
                                                    <div class="actionRow">
                                                        <span class="dots">●</span>
                                                        <a class="editAction" href="{{LaravelLocalization::localizeUrl('my-account/edit-address/'.$shipping_info->id) }}">{{trans('website.edit')}}</a>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        </div>

                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" v-model="user_shipping.first_name"--}}
                                           {{--placeholder="الاسم الأول">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" v-model="user_shipping.last_name"--}}
                                           {{--placeholder="الاسم الثاني">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group ">--}}
                 {{----}}
                                    {{--<div class="code_wr_key">--}}
                                        {{--<input type="text" class="form-control" @change="check_change_phone"--}}
                                               {{--id="phone_number" v-model="user_shipping.phone"--}}
                                               {{--placeholder=" 5XX XXX XXXX">--}}

                                        {{--<div class="label_key">965</div>--}}

                                    {{--</div>--}}
                                    {{--<button type="button" data-toggle="modal" data-target="#order_dt"--}}
                                    {{--@click="send_phone_code" class="btn btn_verify">تحقق--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="email" class="form-control" v-model="user_shipping.email"--}}
                                           {{--placeholder="البريد الالكتروني">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="row hidden">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control js-select select_country">
                                        <option>الدولة</option>

                                        @foreach($countries as $country)
                                            <option value="{{$country->iso2}}">{{$country->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control js-select select_city" v-model="user_shipping.city">

                                    </select>
                                </div>
                            </div>

                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" v-model="user_shipping.state"--}}
                                           {{--placeholder="القطعة">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" v-model="user_shipping.street"--}}
                                           {{--placeholder="الشارع">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" v-model="user_shipping.avenue"--}}
                                           {{--placeholder="الجادة (اختياري)">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" v-model="user_shipping.building_number"--}}
                                           {{--placeholder="رقم المبنى">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" v-model="user_shipping.floor_number"--}}
                                           {{--placeholder="رقم الطابق (اختياري)">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-lg-4 col-md-6 col-sm-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" v-model="user_shipping.apartment_number"--}}
                                           {{--placeholder="رقم الشقة (اختياري)">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <div class="form_st2">


                        <h2 class="title_page">طريقة الدفع</h2>
                        <div class="row">

                            <div v-for="payment_method in payment_method_for_city" class="col-md-6">
                                <div class="form-group">
                                    <div class="box_check_itm">
                                        <input type="radio" :class="'payment_method_'+payment_method.id"
                                               class="radio_st" v-on:change="change_payment_method"
                                               :value="payment_method.id" name="payment_method">
                                        <div class="box_check_itm_cn clearfix">
                                            <div class="icon_check">
                                                <img :src="payment_method.image" alt="">
                                            </div>
                                            <div class="txxt_check">
                                                <h3>@{{ payment_method.name }}</h3>
                                                <p>@{{ payment_method.note }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pay-form ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>الاسم على البطاقة</label>
                                        <input type="text" class="form-control" v-model="card_name"
                                               placeholder="الاسم على البطاقة">
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-end">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>رقم البطاقة</label>
                                        <input type="text" class="form-control" id="card_number" v-model="card_number"
                                               placeholder="رقم البطاقة (أقصى قيمة 16 رقم)">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>تاريخ الانتهاء</label>
                                        <select class="form-control js-select " v-model="card_month"
                                                data-placeholder="الشهر">
                                            <option></option>

                                            <option class="extraneous" value="01">01</option>
                                            <option class="extraneous" value="02">02</option>
                                            <option class="extraneous" value="03">03</option>
                                            <option class="extraneous" value="04">04</option>
                                            <option class="extraneous" value="05">05</option>
                                            <option class="extraneous" value="06">06</option>
                                            <option class="extraneous" value="07">07</option>
                                            <option class="extraneous" value="08">08</option>
                                            <option class="extraneous" value="09">09</option>
                                            <option class="extraneous" value="10">10</option>
                                            <option class="extraneous" value="11">11</option>
                                            <option class="extraneous" value="12">12</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label></label>
                                        <select class="form-control js-select " v-model="card_year"
                                                data-placeholder="السنة">
                                            <option></option>
                                            <option value="20">2020</option>
                                            <option value="21">2021</option>
                                            <option value="22">2022</option>
                                            <option value="23">2023</option>
                                            <option value="24">2024</option>
                                            <option value="25">2025</option>
                                            <option value="26">2026</option>
                                            <option value="27">2027</option>
                                            <option value="28">2028</option>
                                            <option value="29">2029</option>
                                            <option value="30">2030</option>
                                            <option value="31">2031</option>
                                            <option value="32">2032</option>
                                            <option value="33">2033</option>
                                            <option value="34">2034</option>
                                            <option value="35">2035</option>
                                            <option value="36">2036</option>
                                            <option value="37">2037</option>
                                            <option value="38">2038</option>
                                            <option value="39">2039</option>
                                            <option value="40">2040</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>رمز التحقق من البطاقة (CVC)</label>
                                        <input type="text" id="card_cvv" class="form-control" v-model="card_cvv"
                                               placeholder="أقصى قيمة 3 أرقام">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <button type="submit" @click="add_order" class="btn btn-block add_order btn_prim"> إدفع
                                    الآن


                                    <div class="spinner-grow text-light hidden" id="add_order_loader" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal_st" id="order_dt" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button class="close_modal" data-dismiss="modal" aria-label="Close"><i class="far fa-times"></i>
                    </button>
                    <div class="modal_head">
                        <h2 class="modal_title"><i class="fas fa-mobile-alt"></i>تأكيد رقم الجوال</h2>
                    </div>
                    <div class="modal_body">
                        <p class="note_modal model_api_data">تم ارسال كود تحقق إلى رقم الجوال </p>
                        <div class="code_number"></div>

                        <div class="form-group">
                            <label class="fr_label">كود التحقق</label>
                            <input type="text" id="confirm_code" class="form-control" placeholder="كود التحقق">
                            <small id="error_code" class="hidden" style="color: red;"></small>

                        </div>
                        <button type="button" class="btn btn_prim btn_dt" @click="confirm_phone_code">تحقق الآن</button>

                    </div>
                </div>
            </div>
        </div>

    </div>

@stop()

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop()
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var coupon_code = "{{$coupon_code}}";
        var shipping_info = {!! $shipping_info !!};
        var all_shipping_info = {!! $all_shipping_info !!}
        var country_code = {!! $country_code !!};
        var countries = {!! $countries !!};
        var confirm_phone_data =  {!! $confirm_phone_data !!};

        $('#phone_number').change(function () {
            $('#phone_number').val(convertNumber($('#phone_number').val()));
        });

        $('#confirm_code').change(function () {

            $('#confirm_code').val(convertNumber($('#confirm_code').val()));
        });

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
        </script>



    <script src="{{url('')}}/website/general/js/checkout/checkout.js" type="text/javascript"></script>
    <script src="{{url('')}}/website/general/js/map.js" type="text/javascript"></script>

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script src="{{url('')}}/website/general/js/map.js" type="text/javascript"></script>


@stop()

