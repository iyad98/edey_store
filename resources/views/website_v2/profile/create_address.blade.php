@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">حسابي</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage" id="shipping">
        <div class="container">
            <h2 class="title_page">حسابي</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="side_menu_profile">
                        <ul class="menu_profile">
                            <li><a href="{{LaravelLocalization::localizeUrl('my-account') }}">{{trans('website.user_info')}}</a></li>
                            <li ><a href="{{LaravelLocalization::localizeUrl('my-account/addresses') }}">{{trans('website.my_addresses')}}</a></li>
                            <li class="active"><a href="{{LaravelLocalization::localizeUrl('my-account/create-address') }}">{{trans('website.add_new_address')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="box_skin_cn">
                        <div class="alert alert-danger dan_alert hidden" role="alert">

                        </div>
                        <div class="alert alert-success suc_alert hidden" role="alert ">

                        </div>

                        <div class="form_st2" >
                            <h3>معلومات المستلم</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <input type="text" class="form-control" v-model="user_shipping.first_name" placeholder="الاسم الأول">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <input type="text" class="form-control" v-model="user_shipping.last_name" placeholder="الاسم الثاني">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <input type="text"  v-model="user_shipping.phone" id="phone" class="form-control" placeholder="رقم الجوال">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <input type="email"  v-model="user_shipping.email" class="form-control" placeholder="البريد الالكتروني">
                                    </div>
                                </div>
                            </div>
                            <h3>العنوان</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <select class="form-control js-select select_country" data-placeholder="الدولة" >

                                            @foreach($countries as $country)
                                                <option  value="{{$country->iso2}}" >{{$country->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group required">
                                        <select class="form-control js-select select_city"  data-placeholder="المدينة" v-model="user_shipping.city" >

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class=" col-md-6 ">
                                    <div class="form-group required">
                                        <input type="text" class="form-control" v-model="user_shipping.state"  placeholder="القطعة">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <input type="text" class="form-control" v-model="user_shipping.street"  placeholder="الشارع">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <input type="text" class="form-control req"  v-model="user_shipping.avenue"  placeholder="الجادة">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" v-model="user_shipping.building_number"  placeholder=" رقم المبنى (اختياري)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" v-model="user_shipping.floor_number"  placeholder="رقم الطابق (اختياري)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" v-model="user_shipping.apartment_number"  placeholder="رقم الشقة (اختياري)">
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <button @click="store_shipping"  class="btn btn-block btn_prim">اضف عنوان جديد</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal_st" id="order_dt" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button class="close_modal" data-dismiss="modal" aria-label="Close"><i class="far fa-times"></i></button>
                    <div class="modal_head">
                        <h2 class="modal_title"><i class="fas fa-mobile-alt"></i>تأكيد رقم الجوال</h2>
                    </div>
                    <div class="modal_body">
                        <p class="note_modal model_api_data" >تم ارسال كود تحقق إلى رقم الجوال </p>
                        <div class="code_number" >  </div>

                        <div class="form-group">
                            <label class="fr_label">كود التحقق</label>
                            <input type="text" id="confirm_code" class="form-control" placeholder="كود التحقق">
                            <small id="error_code" class="hidden" style="color: red;"> </small>

                        </div>
                        <button type="button" class="btn btn_prim btn_dt"  @click="confirm_shipping_address_code(user_shipping.id)">تحقق الآن</button>


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
        var user = {!! $user !!};

        var country_code = "{{$country_code}}";

    </script>
    <script src="{{url('')}}/website/general/js/user/profile.js" type="text/javascript"></script>
    <script src="{{url('')}}/website/general/js/user/create_shipping.js" type="text/javascript"></script>

@endsection
