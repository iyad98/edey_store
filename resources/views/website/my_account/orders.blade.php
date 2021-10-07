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
                                                        <span class="nobr">{{trans('website.order_number')}}</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date">
                                                        <span class="nobr">{{trans('website.date')}}</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status">
                                                        <span class="nobr">{{trans('website.status')}}</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total">
                                                        <span class="nobr">{{trans('website.total_price')}}</span></th>
                                                    <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions">
                                                        <span class="nobr">{{trans('website.actions')}}</span></th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($orders as $order)
                                                    <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-on-hold order">
                                                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number"
                                                            data-title="{{trans('website.order_number')}}">
                                                            <a href="{{LaravelLocalization::localizeUrl('my-account/orders')}}/{{$order->id}}">
                                                                #{{$order->id}}                                </a>

                                                        </td>
                                                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date"
                                                            data-title="{{trans('website.date')}}">
                                                            <time datetime="{{$order->created_at}}">{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d h:i a')}}</time>

                                                        </td>
                                                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status"
                                                            data-title="{{trans('website.status')}}">
                                                            {{trans_order_status()[$order->status]}}
                                                        </td>
                                                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total"
                                                            data-title="{{trans('website.total_price')}}">
                                                            <span class="woocommerce-Price-amount amount">{{$order->total_price}}
                                                                &nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">{{$order->currency->symbol}}</span>
                                                            </span>
                                                            ( {{$order->order_products_count. " ".trans('website.items')}} )
                                                            {{-- count products --}}
                                                        </td>
                                                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions"
                                                            data-title="{{trans('website.actions')}}">
                                                            <a href="{{LaravelLocalization::localizeUrl('my-account/orders')}}/{{$order->id}}"
                                                               class="woocommerce-button button view"> {{trans('website.show')}}</a></td>
                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                            <nav class="woocommerce-pagination">
                                                {{$orders->links()}}

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