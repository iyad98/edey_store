
<!DOCTYPE html>

<html lang="en">

<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>الكويتيه ستور</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>


    <link href="{{url('')}}/admin_assets/assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />

    <link href="{{url('')}}/admin_assets/assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />


    <link rel="icon" href="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/favicon.png" type="image/gif" sizes="32x32">

    <link href="{{url('')}}/admin_assets/assets/general/css/general.css" rel="stylesheet" type="text/css" />
    <style>
        .btn-primary:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle {
            color: #fff;
            background-color: #f75151 !important;
            border-color: #C4161C;
        }
        .m-login.m-login--2.m-login-2--skin-2 .m-login__container .m-login__head .m-login__title {
            color: #000;
            font-weight: 900;
        }
        .m-checkbox.m-checkbox--focus > input:checked ~ span {
            border: 1px solid #c4161c;
        }
        .m-checkbox.m-checkbox--focus > span::after {
            border: solid #c4161c;
            border-top-width: medium;
            border-right-width: medium;
            border-bottom-width: medium;
            border-left-width: medium;
        }
        .m-login.m-login--2 .m-login__wrapper .m-login__container .m-login__form {
            margin: 3rem auto;
        }
    </style>

</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url({{url('')}}/admin_assets/assets/app/media/img//bg/bg-3.jpg);">
        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="#">
                        <img alt="" style="width: 310px;height: 100px;"
                             src="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/ft_logo.svg"/>
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">سجل الدخول الى لوحة الأدمن</h3>
                    </div>

                    <form method="post" class="m-login__form m-form" action="{{url('admin/login')}}">
                        {{csrf_field()}}
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{session()->get('error')}}
                            </div>
                        @endif
                        <div class="form-group ">
                            <input class="form-control m-input" type="text" placeholder="{{trans('admin.email')}}" name="email" autocomplete="off">
                        </div>
                        <div class="form-group ">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="{{trans('admin.password')}}" name="password">
                        </div>
                        <div class="row m-login__form-sub">
                            <div class="col m--align-left m-login__form-left">
                                <label class="m-checkbox  m-checkbox--focus">
                                    <input type="checkbox" name="remember"> تذكرني
                                    <span></span>
                                </label>
                            </div>

                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signin_submit" class="btn m-btn btn-primary ">سجل الدخول</button>
                        </div>
                    </form>
                </div>
                <div class="m-login__signup">
                    <div class="m-login__head">
                        <h3 class="m-login__title">Sign Up</h3>
                        <div class="m-login__desc">Enter your details to create your account:</div>
                    </div>
                    <form class="m-login__form m-form" action="">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="password" placeholder="Password" name="password">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
                        </div>
                        <div class="row form-group m-form__group m-login__form-sub">
                            <div class="col m--align-left">
                                <label class="m-checkbox m-checkbox--focus">
                                    <input type="checkbox" name="agree">I Agree the <a href="#" class="m-link m-link--focus">terms and conditions</a>.
                                    <span></span>
                                </label>
                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign Up</button>&nbsp;&nbsp;
                            <button id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="m-login__forget-password">
                    <div class="m-login__head">
                        <h3 class="m-login__title">Forgotten Password ?</h3>
                        <div class="m-login__desc">Enter your email to reset your password:</div>
                    </div>
                    <form class="m-login__form m-form" action="">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primaryr">Request</button>&nbsp;&nbsp;
                            <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->

<!--begin::Global Theme Bundle -->
<script src="{{url('')}}/admin_assets/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="{{url('')}}/admin_assets/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

</body>

<!-- end::Body -->
</html>