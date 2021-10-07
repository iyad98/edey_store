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
                                        @include('website.my_account.menu')



                                        <div class="woocommerce-MyAccount-content">
                                            <div class="woocommerce-notices-wrapper"></div>

                                            <p>
                                                {{trans('website.edit_address_note')}}
                                            </p>

                                            <div class="u-columns woocommerce-Addresses col2-set addresses">


                                                {{--
                                                <div class="u-column1 col-1 woocommerce-Address">
                                                    <header class="woocommerce-Address-title title">
                                                        <h3>عنوان الفاتورة</h3>
                                                        <a href="https://alfowzan.com/my-account/edit-address/billing/"
                                                           class="edit">تحرير</a>
                                                    </header>
                                                    <address>لم تقم بإعداد هذا العنوان بعد.</address>
                                                </div>
                                                --}}

                                                <div class="u-column2 col-1 woocommerce-Address">
                                                    <header class="woocommerce-Address-title title">
                                                        <h3>{{trans('website.billing_address')}}</h3>
                                                        <a href="{{LaravelLocalization::localizeUrl('my-account/edit-address/shipping')}}"
                                                           class="edit">{{trans('website.edit')}}</a>
                                                    </header>

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
    </div>
@endsection

@push('js')

    <script src="{{url('')}}/website/general/js/user/my_account.js" type="text/javascript"></script>

@endpush