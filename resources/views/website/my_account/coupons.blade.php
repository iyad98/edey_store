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
        .pagination > .active > span {
            background: #2e3379 !important;
            border-color: #2e3379 !important;
        }
        .pagination > .active > span:hover {
            background: #2e3379 !important;
            border-color: #2e3379 !important;
        }
        .row {
            margin-left: 0;
            margin-right: 0;
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
                                            <div class="woocommerce-notices-wrapper"></div>

                                            <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                                                <thead>
                                                <tr>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
                                                        <span class="nobr">{{trans('website.coupon')}}</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date">
                                                        <span class="nobr">{{trans('website.orders_count')}}</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status">
                                                        <span class="nobr">{{trans('website.net_sales')}}</span></th>

                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($coupons as $coupon)
                                                    <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">

                                                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                            data-title="التاريخ">
                                                            {{$coupon->coupon}}
                                                        </td>
                                                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                            data-title="الحالة">
                                                            {{$coupon->orders_count}}
                                                        </td>
                                                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                            data-title="الحالة">
                                                            {{$coupon->user_famous_price}}
                                                        </td>
                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                            <nav class="woocommerce-pagination">
                                                {{$coupons->links()}}

                                            </nav>

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


    {{--
    <script src="{{url('')}}/website/general/js/user/profile.js" type="text/javascript"></script>
    --}}
@endpush