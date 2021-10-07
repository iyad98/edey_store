@extends('website.layout')

@push('css')

@endpush


@section('content')
    <div class="page-header page_">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{$breadcrumb_title}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="breadcrumb">
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main" role="main">
                                <nav class="woocommerce-breadcrumb">
                                    @foreach($breadcrumb_arr as $breadcrumb)
                                        <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a>
                                    @endforeach

                                    {{$breadcrumb_last_item}}
                                </nav>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="" id="my_account">
        <div class="container">
            <div class="row">
                <div class="col-md-12 margin-t-b">
                    <div class="single-page">
                        <div class="row">
                            <div class="col-md-12 margin-t-b ">
                                <div class="single-img">
                                </div>
                            </div>
                            <div class="col-md-12 margin-t-b">
                                <div class="des-10">
                                    <div class="woocommerce">
                                        <ul class="woocommerce-error hidden" role="alert" v-show="error_msg != '' ">
                                            <li><strong>خطأ:</strong> @{{ error_msg }} </li>
                                        </ul>

                                        <div v-show="success_msg != '' " class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info hidden">
                                            @{{ success_msg }}
                                        </div>
                                        <div class="woocommerce-notices-wrapper"></div>
                                        <div class="u-columns col2-set" id="customer_login">
                                            <div class="u-column1 col-1">
                                                <h2>تسجيل الدخول</h2>
                                                <form class="woocommerce-form woocommerce-form-login login"
                                                      method="post">
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="username">البريد الإلكتروني <span
                                                                    class="required">*</span></label>
                                                        <input type="text" v-model="login.email" @keyup.enter="login_user"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                               name="username" id="username" value=""/></p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="password">كلمة المرور <span
                                                                    class="required">*</span></label>
                                                        <input v-model="login.password"  @keyup.enter="login_user" class="woocommerce-Input woocommerce-Input--text input-text"
                                                               type="password" name="password" id="password"/>
                                                    </p>
                                                    <p class="form-row">
                                                        <input type="hidden" id="woocommerce-login-nonce"
                                                               name="woocommerce-login-nonce" value="84cb204e79"/>
                                                        <input type="hidden" name="_wp_http_referer"
                                                               value="/my-account/"/>
                                                        <button type="button" @click="login_user" :disabled="login_loading" class="woocommerce-Button button"
                                                                name="login" value="تسجيل الدخول">

                                                            <i v-show="login_loading" class="fa fa-spin fa-spinner"></i>
                                                            تسجيل الدخول
                                                        </button>
                                                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
                                                            <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                                                                   name="rememberme" type="checkbox" id="rememberme"
                                                                   value="forever"/> <span>تذكرني</span>
                                                        </label>
                                                    </p>
                                                    <p class="woocommerce-LostPassword lost_password">
                                                        <a href="{{url('website/password/forgot')}}">نسيت كلمة مرورك؟</a>
                                                    </p>
                                                </form>
                                            </div>
                                            <div class="u-column2 col-2">
                                                <h2>تسجيل جديد</h2>
                                                <form method="post" class="register">
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="reg_email">البريد الإلكتروني <span class="required">*</span></label>
                                                        <input type="email" v-model="register.email" @keyup.enter="register_user"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                               name="email" id="reg_email" value=""/></p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="reg_password">كلمة المرور <span
                                                                    class="required">*</span></label>
                                                        <input type="password"  v-model="register.password" @keyup.enter="register_user"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                               name="password" id="reg_password"/>
                                                    </p>
                                                    <div class="woocommerce-privacy-policy-text"></div>
                                                    <p class="woocommerce-FormRow form-row">
                                                        <input type="hidden" id="woocommerce-register-nonce"
                                                               name="woocommerce-register-nonce" value="a98e694204"/>
                                                        <input type="hidden" name="_wp_http_referer"
                                                               value="/my-account/"/>


                                                        <button type="button" @click="register_user" :disabled="register_loading" class="woocommerce-Button button"
                                                                name="login" value="تسجيل جديد">

                                                            <i v-show="register_loading" class="fa fa-spin fa-spinner"></i>
                                                            تسجيل جديد
                                                        </button>
                                                    </p>
                                                </form>
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
@endsection

@push('js')

    <script src="{{url('')}}/website/general/js/user/my_account.js" type="text/javascript"></script>

@endpush