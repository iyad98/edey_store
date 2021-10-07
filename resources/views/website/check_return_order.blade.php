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
                                                <h2>معلومات الطلب اللازمة للاسترجاع</h2>
                                                <form class="woocommerce-form woocommerce-form-login login"
                                                      method="post">
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="username">رقم الطلب <span
                                                                    class="required">*</span></label>
                                                        <input type="text" v-model="order.id" @keyup.enter="send"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"/>
                                                    </p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="username">رقم الجوال <span
                                                                    class="required">*</span></label>
                                                        <input type="text" v-model="order.phone" @keyup.enter="send"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"/>
                                                    </p>

                                                    <p class="form-row">
                                                        <button type="button" @click="send" :disabled="loading" class="woocommerce-Button button">
                                                            <i v-show="loading" class="fa fa-spin fa-spinner"></i>
                                                            إرسال
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

    <script src="{{url('')}}/website/general/js/user/check_return_order.js" type="text/javascript"></script>

@endpush