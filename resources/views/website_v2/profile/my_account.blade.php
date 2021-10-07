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
    <div class="content_innerPage" id="profile">
        <div class="container">
            <h2 class="title_page">حسابي</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="side_menu_profile">
                        <ul class="menu_profile">

                            <li class="active"><a href="{{LaravelLocalization::localizeUrl('my-account') }}">{{trans('website.user_info')}}</a></li>
                            <li><a href="{{LaravelLocalization::localizeUrl('my-account/addresses') }}">{{trans('website.my_addresses')}}</a></li>
                            <li><a href="{{LaravelLocalization::localizeUrl('my-account/create-address') }}">{{trans('website.add_new_address')}}</a></li>


                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="box_skin_cn">
                        <div class="alert alert-danger dan_alert hidden" role="alert">

                        </div>
                        <div class="alert alert-success suc_alert hidden" role="alert ">

                        </div>

                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"  v-model="user.first_name" class="form-control" placeholder="الاسم الأول">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"  v-model="user.last_name" class="form-control" placeholder="الاسم الثاني">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <input type="text" class="form-control" v-model="user.phone" placeholder="رقم الجوال">
                                        <div class="label_key_flag"><img src="{{$country_flag}}"></div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" v-model="user.email" class="form-control" placeholder="البريد الالكتروني">
                                    </div>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" v-model="user.old_password" placeholder="كلمة المرور القديمة">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" v-model="user.password" class="form-control" placeholder="كلمة المرور">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" v-model="user.password_confirmation" class="form-control" placeholder="تاكيد كلمة المرور">
                                </div>
                            </div>
                        </div>


                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <button @click="update_profile" class="btn btn-block btn_prim">حفظ التغييرات</button>
                                </div>
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
    <script>
        var user = {!! $user !!};
        var user_shipping = {!! $user_shipping !!};
        var country_code = "{{$country_code}}";

    </script>
    <script src="{{url('')}}/website/general/js/user/profile.js" type="text/javascript"></script>
    <script src="{{url('')}}/website/general/js/user/shipping.js" type="text/javascript"></script>

@endsection
