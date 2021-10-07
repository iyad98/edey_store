@extends('website_v3.app.layout')
@section('title')
    {{show_website_title(@$title)}} @endsection
@section('content')

    <div class="content_innerPage" id="my_account">
        <div class="container">

            <div class="block_sign_layout">
                <div class="row justify-content-sm-center">
                    <div class="col-lg-5 col-md-7 col-sm-9">

                        <div class="cn_sign_layout">
                            <div class="logo_center">
                                <img src="{{asset('/website_v3/images/logo.png')}}" alt="">
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success hidden" role="alert">
                                    {{ trans('website.reset_password_done') }}
                                </div>

                            @endif
                            <div class="alert alert-success suc_alert hidden" role="alert">
                            </div>

                            <div class="alert alert-danger dan_alert hidden" role="alert">
                            </div>
                            <div class="form-group">
                                <label class="fr_label">البريد الالكتروني</label>
                                <input type="email" v-model="login.email" @keyup.enter="login_user" class="form-control"
                                       placeholder="البريد الالكتروني">
                            </div>
                            <div class="form-group">
                                <div class="cn_label  d-flex align-items-center">
                                    <label class="fr_label">كلمة المرور</label>
                                    <div class="pass_left mr-auto">
                                        <a href="#forget_password" data-toggle="modal" class="forget_password">هل نسيت
                                            كلمة المرور؟</a>
                                    </div>
                                </div>
                                <div class="password_input">
                                    <input type="password" v-model="login.password" @keyup.enter="login_user"
                                           class="form-control pwd" placeholder="كلمة المرور">
                                    <span class="fr_icon show_pass"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                            <button @click="login_user" class="btn btn_prim btn_dt">تسجيل الدخول</button>
                            <div class="note_sign"><p>مستخدم جديد؟<a
                                        href="{{LaravelLocalization::localizeUrl('sign-up') }}">انضم إلى الكويتية
                                        ستور</a></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal_st" id="forget_password" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button class="close_modal" data-dismiss="modal" aria-label="Close"><i class="far fa-times"></i>
                    </button>
                    <div class="modal_head">
                        <h2 class="modal_title"><i class="fas fa-unlock-alt"></i>نسيت كلمة المرور</h2>
                    </div>
                    <div class="modal_body">
                        <p class="note_modal">الرجاء ادخال البريد الالكتروني المستخدم في عملية التسجيل</p>

                        <div class="alert alert-success suc_alert1 hidden" role="alert">

                        </div>
                        <div class="alert alert-danger dan_alert1 hidden" role="alert">
                        </div>
                        <div class="form-group">
                            <label class="fr_label">البريد الالكتروني</label>
                            <input type="email" v-model="email_forget_password" name="email" class="form-control"
                                   placeholder="البريد الالكتروني">
                        </div>
                        <input type="hidden" name="_wp_http_referer"
                               value="/my-account/"/>
                        <button type="submit" @click="send_email_for_forget_passeord"
                                class="btn btn_prim btn_dt send_email">
                            إرسال
                            <div class="spinner-grow text-light hidden " id="send_email_loader" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
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
