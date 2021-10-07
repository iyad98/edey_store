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
                        <img class="lazyload"  data-src="/website/img/base.png" alt="girls">
                    </div>
                </div>
                <div class="col-12 col-md-6">

                    <div class="sign-in-section" id="customer_login">
                        <div class="logo">
                            <img class="lazyload"  data-src="/website/img/mainlogo.png" alt="logo">
                        </div>
                        <div class="sign-in">

                            <div class="title">
                                <h6 class="active">تسجيل الدخول</h6>
                                <a href="/sign-up"> <span>حساب جديد</span></a>
                            </div>
                            <div class="alert alert-danger dan_alert hidden" role="alert">

                            </div>
                            <div class="alert alert-success suc_alert hidden" role="alert ">

                            </div>




                            <div class="inputs">
                                <input type="email" name="email" id="email" placeholder="البريد الالكتروني"  v-model="login.email" >
                                <div class="pass-input">
                                    <input type="password" name="pass" id="pass" placeholder="كلمة المرور"  v-model="login.password"  >
                                    <div class="icon">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="buttons">

                                <button type="button" class="btn sign-in-btn"  name="login"  @click="login_user" :disabled="login_loading">تسجيل الدخول</button>
                                <button class="btn forget-pass-btn" data-toggle="modal" data-target="#exampleModal">هل
                                    نسيت كلمة المرور؟</button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    <i class="fas fa-unlock-alt"></i>
                                                    نسيت كلمة المرور
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>الرجاء ادخال البريد الالكتروني المستخدم في عملية التسجيل</p>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">البريد الالكتروني</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                                           aria-describedby="emailHelp" placeholder="البريد الالكتروني">

                                                </div>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn send-btn">إرسال</button>
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

    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()



@section('js')

    <script src="{{url('')}}/website/general/js/user/my_account.js" type="text/javascript"></script>

@endsection