@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')

    <style>
        .vc_row-fluid, .wpb_text_column {
            padding: 12px !important;
        }

        .ninja-forms-field {
            width: 100% !important;
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
    <div class="" id="bank_transfer">
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



                                        <div class="woocommerce-notices-wrapper"></div>
                                        <div class="u-columns col2-set" id="customer_login">
                                            <div class="col-sm-3"></div>
                                            <div class="u-column1 col-sm-6">

                                                <ul class="msg woocommerce-error hidden" role="alert" v-show="error_msg != ''">
                                                    <li><strong>{{trans('website.error_')}}:</strong> @{{ error_msg }}</li>
                                                </ul>


                                                <div v-show="success_msg != ''"
                                                     class="msg hidden woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
                                                    @{{ success_msg }}
                                                </div>

                                                <form class="woocommerce-form woocommerce-form-login"
                                                      method="post">
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label > {{trans('website.adapter_name')}} <span
                                                                    class="required">*</span></label>
                                                        <input type="text"  v-model="bank.name"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                               /></p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label > {{trans('website.order_number')}} <span
                                                                    class="required">*</span></label>
                                                        <input type="text" disabled v-model="bank.order_id"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                        /></p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label > {{trans('website.transferring_bank')}} <span
                                                                    class="required">*</span></label>

                                                        <select id="nf-field-9" style="background-color: #f7f7f7;border: 1px solid #ededed;padding: 5px 15px;"
                                                                v-model="bank.bank_id">
                                                            @foreach($banks as $bank)
                                                                <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label > {{trans('website.account_number')}} <span
                                                                    class="required">*</span></label>
                                                        <input type="text"  v-model="bank.account_number"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                        /></p>
                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label > {{trans('website.bank_transfer_price')}} <span
                                                                    class="required">*</span></label>
                                                        <input type="text" disabled  v-model="bank.price"
                                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                                        /></p>

                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label > {{trans('website.file')}} </label>
                                                        <input class="form-control" type="file" @change="get_file($event , '#file')" placeholder="{{trans('website.file')}}">
                                                    </p>

                                                </form>
                                            </div>
                                            <div class="col-sm-3"></div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6">
                                            <div id="nf-field-12-wrap"
                                                 class="field-wrap submit-wrap textbox-wrap"
                                                 data-field-id="12">
                                                <div class="nf-field-label"></div>
                                                <div class="nf-field-element">

                                                    <a href="javascript:;"
                                                       @click="send_bank_transfer"
                                                       class="checkout-button button alt wc-forward">
                                                        {{trans('website.send')}}
                                                        <i v-show="loading" class="fa fa-spin fa-spinner"></i>
                                                    </a>
                                                </div>
                                                <div class="nf-error-wrap"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3"></div>
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
    <script>
        var order = {!! $order !!};
    </script>
    <script src="{{url('')}}/website/general/js/bank/bank.js" type="text/javascript"></script>

@endpush