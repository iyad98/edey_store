@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="content_innerPage" id="my_account">
        <div class="container">

            <div class="block_sign_layout">
                <div class="row justify-content-sm-center">
                    <div class="col-lg-5 col-md-7 col-sm-9">

                        <div class="cn_sign_layout">
                            <div class="logo_center">
                                <img src="/website_v2/images/logo.png" alt="">
                            </div>
                            <form method="POST" action="{{ route('password.update') }}">
                                <input type="hidden" name="token" value="{{ $token }}">
                                @csrf
                                @error('email')
                                <div class="alert alert-danger dan_alert " role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                @error('password')
                                <div class="alert alert-danger dan_alert " role="alert">
                                    {{ $message }}
                                </div>
                                @enderror




                                <div class="form-group">
                                <label class="fr_label">البريد الالكتروني</label>

                                    <input type="email" disabled   value="{{ $email ?? old('email') }}" class="form-control" placeholder="البريد الالكتروني">
                                    <input type="hidden"   name="email"  value="{{ $email ?? old('email') }}" >
                            </div>
                            <div class="form-group">
                                <div class="cn_label  d-flex align-items-center">
                                    <label class="fr_label">  كلمة المرور الجديدة</label>
                                </div>
                                <div class="password_input">
                                    <input type="password"  name="password" id="password" class="form-control pwd" placeholder="  كلمة المرور الجديدة">
                                    <span class="fr_icon show_pass"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="cn_label  d-flex align-items-center">
                                    <label class="fr_label">تأكيد كلمة المرور</label>
                                </div>
                                <div class="password_input">
                                    <input type="password"  name="password_confirmation" id="password-confirm" class="form-control pwd" placeholder="تأكيد كلمة المرور">
                                    <span class="fr_icon show_pass"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                            <button   type="submit" class="btn btn_prim btn_dt">اعادة تعيين كلمة المرور</button>
                            <div class="note_sign"><p>مستخدم جديد؟<a href="{{LaravelLocalization::localizeUrl('sign-up') }}">انضم إلى الكويتية ستور</a></p></div>
                            </form>
                        </div>
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
