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
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <div class="woocommerce-notices-wrapper"></div>
                                        <div class="u-columns col2-set" id="customer_login">
                                            <div class="u-column1 col-1">
                                                <h2>إعادة تعيين كلمة المرور</h2>

                                                <form method="POST" action="{{ route('password.update') }}">
                                                    <input type="hidden" name="token" value="{{ $token }}">

                                                    @csrf
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="username">البريد الإلكتروني <span
                                                                    class="required">*</span></label>
                                                        <input type="text" value="{{ $email ?? old('email') }}"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                               name="email" id="username" /></p>

                                                    @error('email')
                                                    <span class="invalid-feedback"  role="alert">
                                                      <strong style="color: red;">{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="password">كلمة المرور الجديدة <span
                                                                    class="required">*</span></label>
                                                        <input type="password"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                               name="password" id="password" value=""/></p>
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red;" >{{ $message }}</strong>
                                                         </span>
                                                    @enderror


                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="password-confirm">تأكيد كلمة المرور <span
                                                                    class="required">*</span></label>
                                                        <input type="password"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                               name="password_confirmation" id="password-confirm" value=""/></p>


                                                    <p class="form-row">
                                                        <input type="hidden" id="woocommerce-login-nonce"
                                                               name="woocommerce-login-nonce" value="84cb204e79"/>
                                                        <input type="hidden" name="_wp_http_referer"
                                                               value="/my-account/"/>
                                                        <button type="submit" class="woocommerce-Button button"
                                                                name="login" value="اعادة تعيين كلمة المرور">

                                                            <i v-show="login_loading" class="fa fa-spin fa-spinner"></i>
                                                            اعادة تعيين كلمة المرور
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