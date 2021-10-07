@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection
@section('content')

    @if(Session::has('success'))

        <div class="alert alert-warning mt-4" role="alert">
            {{Session::get('success')}}
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{Session::get('error')}}
        </div>
    @endif

    <div class="content_innerPage">
        <div class="container">
            <div class="row">
                <div class="col-md-3 ">
                    <div class="side_menu_account">
                        <ul class="menu_account">
                            <li><a href="account.html">المعلومات الشخصية</a></li>
                            <li class=""><a href="account2.html">معلومات التوصيل والشحن</a></li>
                            <li class="active"><a href="account3.html">ترقية لحساب تاجر/متجر</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 ">
                    <div class="block_cn_account">
                        <form class="form_st1" action="{{route('upgrade.account.post')}}" method="post">
                            @csrf
                            <h2 class="title_page">ترقية لحساب تاجر/متجر</h2>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="img_info">
                                        <h4>أيقونة المتجر</h4>
                                        <p>يجب أن يكون ملف .jpg أو .gif أو .png أصغر من 10 ميجابايت و 400 × 400 بكسل على
                                            الأقل</p>
                                    </div>
                                    <div class="circle upload-button">
                                        <!-- User Profile Image -->
                                        <img class="profile-pic" src="{{asset('website_v3/img/profil_pic.svg')}}">
                                    </div>

                                    <input class="file-upload" name="logo_store" type="file" accept="image/*"/>
                                    @error('logo_store')
                                    <span class="error_validation">{{$message}}</span>
                                    @enderror
                                </div>


                                <div class="col-md-6 banner_shop">
                                    <div class="img_info">
                                        <h4>بانر المتجر</h4>
                                        <p>يجب أن يكون ملف .jpg أو .gif أو .png أصغر من 10 ميجابايت </p>
                                    </div>
                                    <div class="circle upload-button2">
                                        <!-- User Profile Image -->
                                        <img class="profile-pic2" src="{{asset('website_v3/img/shop_banner.png')}}">
                                    </div>
                                    <input class="file-upload2" type="file" name="image_banar_store" accept="image/*"/>
                                    @error('image_banar_store')
                                    <span class="error_validation">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">اسم المتجر</label>
                                        <input type="text" class="form-control " name="store_name">
                                        @error('store_name')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">رقم جوال المتجر</label>
                                        <input type="text" class="form-control" name="phone_store">
                                        @error('phone_store')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">رقم الواتس آب</label>

                                        <input type="text" class="form-control" name="phone_whatsapp_store">
                                        @error('phone_whatsapp_store')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">حسابك في فيسبوك</label>
                                        <input type="text" class="form-control" name="facebook_link">
                                        @error('facebook_link')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">حسابك في تويتر</label>
                                        <input type="text" class="form-control" name="twitter_link">
                                        @error('twitter_link')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">حسابك في انستغرام</label>
                                        <input type="text" class="form-control" name="instagram_link">
                                        @error('instagram_link')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <h2 class="title_page">معلومات التاجر</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">الاسم الاول</label>
                                        <input type="text" class="form-control" name="merchant_first_name">
                                        @error('merchant_first_name')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">اسم العائلة</label>
                                        <input type="text" class="form-control" name="merchant_last_name">
                                        @error('merchant_last_name')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">رقم الجوال</label>
                                        <input type="text" class="form-control" name="phone_merchants">
                                        @error('phone_merchants')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">الهوية</label>
                                        <input type="text" class="form-control" name="identification_number">
                                        @error('identification_number')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label mb-3">لديك حساب في بارع؟</label>
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <div class="box_check_itm">
                                                        <input type="radio" class="radio_st"
                                                               name="account_barea" value="1">
                                                        <div class="box_check_itm_cn clearfix">
                                                            <div class="icon_check">
                                                                لدي حساب
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="box_check_itm">
                                                        <input type="radio" class="radio_st"
                                                               name="account_barea" checked="" value="0">
                                                        <div class="box_check_itm_cn clearfix">
                                                            <div class="icon_check">
                                                                غير مسجل
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">نبذة عن التاجر</label>
                                        <textarea type="text" class="form-control" name="about_us_merchants"></textarea>
                                        @error('about_us_merchants')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">السجل التجاري (اختياري)</label>
                                        <input type="text" class="form-control" name="commercial_register_number">
                                        @error('commercial_register_number')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">رقم معروف (اختياري)</label>
                                        <input type="text" class="form-control" name="maroof_number">
                                        @error('maroof_number')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <h2 class="title_page">معلومات الحساب البنكي</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">اسم الحساب البنكي</label>
                                        <input type="text" class="form-control" name="bank_account_name">
                                        @error('bank_account_name')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">اسم البنك</label>
                                        <select class="form-control js-select" name="bank_id"
                                                data-placeholder="اختر البنك">
                                            <option>إختر البنك</option>
                                            @foreach( $banks as $bank)
                                                <option value="{{$bank->id}}">{{$bank->name_ar}}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="fr_label">رقم الايبان <img
                                                src="{{asset('website_v3/img/information-circle-outline.svg')}}" alt=""></label>
                                        <input type="text" class="form-control" name="iban_number">
                                        @error('iban_number')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <h2 class="title_page">موقع المتجر</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">الدولة</label>
                                        <select class="form-control js-select" name="city_id"
                                                data-placeholder="الدولة">
                                            <option>اختر الدولة</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->name_ar}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">المدينة</label>
                                        <select class="form-control js-select" name="country_id"
                                                data-placeholder="المدينة">
                                            <option>اختر المدينة</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name_ar}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">المنطفة</label>
                                        <select class="form-control js-select" data-placeholder="المنطفة"
                                                name="area_id">
                                            <option>إختر المنطقة</option>
                                            @foreach($areas as $area)
                                                <option value="{{$area->id}}">{{$area->name_ar}}</option>
                                            @endforeach
                                        </select>
                                        @error('area_id')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">العنوان</label>
                                        <input type="text" class="form-control" name="address_store">
                                        @error('address_store')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">الشارع</label>
                                        <input type="text" class="form-control" name="street_store">
                                        @error('street_store')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">أقرب معلم (اختياري)</label>
                                        <input type="text" class="form-control" name="nearest_public_place">
                                        @error('nearest_public_place')
                                        <span class="error_validation">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <button type="submit" class="btn btn-block btn_prim">حفظ المعلومات</button>
                                </div>
                            </div>
                        </form>
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
        $(document).ready(function () {
            var readURL = function (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-pic').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".file-upload").on('change', function () {
                readURL(this);
            });
            $(".upload-button").on('click', function () {
                $(".file-upload").click();
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            var readURL = function (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.profile-pic2').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".file-upload2").on('change', function () {
                readURL(this);
            });
            $(".upload-button2").on('click', function () {
                $(".file-upload2").click();
            });
        });
    </script>




@endsection
