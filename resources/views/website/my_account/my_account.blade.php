@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')

    <style>
        .woocommerce-MyAccount-navigation {
            float: right;
        }
        .woocommerce-MyAccount-content {
            width: 77%;
            float: left;
        }
    </style>
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



    <div class="" id="profile">
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


                                        @include('website.my_account.menu')
                                        <div class="woocommerce-MyAccount-content">
                                            <ul class="woocommerce-error hidden" role="alert" v-show="error_msg != '' ">
                                                <li><strong>{{trans('website.error_')}}:</strong> @{{ error_msg }} </li>
                                            </ul>

                                            <div v-show="success_msg != '' " class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info hidden">
                                                @{{ success_msg }}
                                            </div>

                                            <div class="woocommerce-notices-wrapper"></div>
                                            <form class="woocommerce-EditAccountForm edit-account" action="" method="post">


                                                <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                                                    <label for="account_first_name">{{trans('website.first_name')}} <span class="required">*</span></label>
                                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" v-model="user.first_name" name="account_first_name" id="account_first_name" >
                                                </p>
                                                <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                                                    <label for="account_last_name">{{trans('website.last_name')}} <span class="required">*</span></label>
                                                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" v-model="user.last_name" name="account_last_name" id="account_last_name" value="">
                                                </p>
                                                <div class="clear"></div>

                                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                    <label for="account_email">{{trans('website.email')}} <span class="required">*</span></label>
                                                    <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" v-model="user.email" name="account_email" id="account_email">
                                                </p>

                                                <fieldset>
                                                    <legend>{{trans('website.change_password')}}</legend>

                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="password_current">{{trans('website.old_password_')}}</label>
                                                        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" v-model="user.old_password" name="password_current" id="password_current">
                                                    </p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="password_1">{{trans('website.new_password_')}}</label>
                                                        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" v-model="user.password" name="password_1" id="password_1">
                                                    </p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="password_2">{{trans('website.confirm_password')}}</label>
                                                        <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" v-model="user.password_confirmation" name="password_2" id="password_2">
                                                    </p>
                                                </fieldset>
                                                <div class="clear"></div>


                                                <p>
                                                    <button :disabled="loading" type="button" class="woocommerce-Button button" @click="update_profile" value="{{trans('website.save_information')}}">
                                                        <i v-show="loading" class="fa fa-spin fa-spinner"></i>
                                                        {{trans('website.save_information')}}
                                                    </button>
                                                </p>

                                            </form>

                                        </div>
                                    </div>                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        var user = {!! $user !!};
    </script>
    <script src="{{url('')}}/website/general/js/user/profile.js" type="text/javascript"></script>

@endpush
