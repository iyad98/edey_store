@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection




@section('content')

{{--    <div class="content_innerPage" id="my_account">--}}
{{--        <div class="container">--}}
{{--            <div class="block_sign_layout">--}}
{{--                <div class="row justify-content-sm-center">--}}
{{--                    <div class="col-lg-5 col-md-7 col-sm-9">--}}
{{--                        <div class="cn_sign_layout">--}}
{{--                            <div class="logo_center">--}}
{{--                                <img src="/website_v2/images/logo.png" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="alert alert-success suc_alert hidden" role="alert">--}}
{{--                            </div>--}}
{{--                            <div class="alert alert-danger dan_alert hidden" role="alert">--}}
{{--                            </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="fr_label">الاسم </label>--}}
{{--                                    <input type="text" v-model="register.first_name" class="form-control" placeholder="الاسم ">--}}
{{--                                </div>--}}

{{--                                <div class="form-group">--}}
{{--                                    <label class="fr_label">العائلة </label>--}}
{{--                                    <input type="text" v-model="register.last_name" class="form-control" placeholder="العائلة ">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="fr_label">البريد الالكتروني</label>--}}
{{--                                    <input type="email" class="form-control" placeholder="البريد الالكتروني" v-model="register.email" >--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="fr_label">كلمة المرور</label>--}}
{{--                                    <div class="password_input">--}}
{{--                                        <input type="password" class="form-control pwd" v-model="register.password" placeholder="كلمة المرور">--}}
{{--                                        <span class="fr_icon show_pass"><i class="fas fa-eye"></i></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label class="fr_label">تأكيد كلمة المرور</label>--}}
{{--                                    <div class="password_input">--}}
{{--                                        <input type="password"  v-model="register.password_confirmation" class="form-control pwd" placeholder="تأكيد كلمة المرور">--}}
{{--                                        <span class="fr_icon show_pass"><i class="fas fa-eye"></i></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="label_check">--}}
{{--                                        <input type="checkbox" class="checkbox_st" id="accept_terms">--}}
{{--                                        <div class="check_txt">أوافق على جميع <a href="{{LaravelLocalization::localizeUrl('terms')}}"> الشروط والأحكام </a>الخاصة بالكويتية ستور</div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <button  @click="register_user" class="btn btn_prim btn_dt">تسجيل جديد</button>--}}
{{--                                <div class="note_sign"><p>مستخدم حالي؟ <a href="{{LaravelLocalization::localizeUrl('sign-in') }}">سجل دخول الآن</a></p></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
<!-- preloader -->

<div class="login_layout" >
    <div class="row">
        <div class="col-md-6">
            <div class="login_slider">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100"  src="{{url('')}}/website_v3/img/collection.png"
                                 alt="collection">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"  src="{{url('')}}/website_v3/img/collection.png"
                                 alt="collection">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100"  src="{{url('')}}/website_v3/img/collection.png"
                                 alt="collection">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="my_account">
            <div class="cn_sign_layout">
                <div class="logo">
                    <img src="{{url('')}}/website_v3/img/logo.png" alt="">
                </div>
                <div class="login_msg">
                    <h1>أهلاً بك في متجر إيدي</h1>
                </div>
                <form class="form_st1" action="#"id="my_account">
                    <div class="row">
                        <div class="alert alert-success suc_alert hidden" role="alert">
                        </div>
                        <div class="alert alert-danger dan_alert hidden" role="alert">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fr_label">الاسم الأول</label>
                                <input type="text" class="form-control" v-model="register.first_name" placeholder="الاسم الأول" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fr_label">الاسم الثاني</label>
                                <input type="text" class="form-control"   v-model="register.last_name" placeholder="الاسم الثاني">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fr_label">البريد الالكتروني</label>
                                <input type="email" class="form-control"  placeholder="البريد الالكتروني" v-model="register.email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fr_label">كلمة المرور</label>
                                <div class="password_input">
                                    <input type="password" class="form-control pwd" v-model="register.password" placeholder="كلمة المرور" >
                                    <span class="fr_icon show_pass"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="fr_label">تأكيد كلمة المرور</label>
                                <div class="password_input">
                                    <input type="password" class="form-control pwd" v-model="register.password_confirmation" placeholder="تأكيد كلمة المرور" >
                                    <span class="fr_icon show_pass"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="label_check">
                            <input type="checkbox" class="checkbox_st" id="accept_terms">
                            <div class="check_txt"><a href="{{LaravelLocalization::localizeUrl('terms')}}"></a>أوافق على شروط الخصوصية</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn_prim btn_dt" @click="register_user">إنشاء حساب</button>
                    <div class="note_sign"><p>أنت عضو فعلاً ؟ قم  <a href="#">بتسجيل الدخول</a></p></div>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection



@section('css')

@endsection

@section('js')


    <script src="{{url('')}}/website/general/js/user/my_account.js" type="text/javascript"></script>

@endsection
