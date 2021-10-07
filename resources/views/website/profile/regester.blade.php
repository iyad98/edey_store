@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')

    <div class="sign-in-page">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">التسجيل</li>
            </ol>
        </nav>
        <div class="container" id="my_account">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="about-img">
                        <img class="lazyload"  data-src="/website/img/base2.png" alt="girls">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="sign-in-section">
                        <div class="logo">
                            <img class="lazyload"  data-src="/website/img/mainlogo.png" alt="logo">
                        </div>
                        <div class="sign-in">
                            <div class="title">

                                <a href="/sign-in" >  <h6 >تسجيل الدخول</h6></a>

                                 <span class="active">حساب جديد</span>

                            </div>
                            <div class="alert alert-danger dan_alert hidden" role="alert">

                            </div>
                            <div class="alert alert-success suc_alert hidden" role="alert ">

                            </div>


                            <div class="inputs">
                                <input type="text" name="first_name" id="first_name" v-model="register.first_name" placeholder="الاسم ">
                                <input type="text" name="last_name" id="last_name" v-model="register.last_name" placeholder="العائلة">
                                <input type="email" name="email" id="email" v-model="register.email" placeholder="البريد الالكتروني">
                                <div class="pass-input">
                                    <input type="password" name="password"  v-model="register.password" id="pass" placeholder="كلمة المرور">
                                    <div class="icon">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                                <div class="pass-input">
                                    <input type="password" name="pass" v-model="register.password_confirmation" id="pass2" placeholder="تأكيد كلمة المرور ">
                                    <div class="icon">
                                        <i class="fas fa-eye-slash"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="buttons">
                                <button class="btn sign-up-btn" @click="register_user">تأكيد التسجيل</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()
<style>

</style>

@section('js')

    <script src="{{url('')}}/website/general/js/user/my_account.js" type="text/javascript"></script>

@endsection