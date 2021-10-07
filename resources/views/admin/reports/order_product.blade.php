@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>
    <style>
        #m_select_remote_products_div .select2-container {
            width: 100% !important;
        }

        #m_select_remote_sku_div .select2-container {
            width: 100% !important;
        }

        .m-body .m-content {
            padding: 50px !important;
        }
    </style>
@endpush

@section('content')
    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row  top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-sm-12">

                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <h4>
                                    @if($type_product == 1)

                                        {{trans('admin.result_search_product')}} <span
                                                style="color: blue;">{{$product->name}}</span>
                                    @elseif($type_product == 2)
                                        {{trans('admin.result_search_product_variation')}} <span
                                                style="color: blue;">{{$product_variation->product->name ." ( $product_variation->sku )"}}</span>
                                        <div class="row mt-3">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-4">
                                                <table class="table">
                                                    @foreach($product_variation->attribute_values as $attribute_value)
                                                        <tr>
                                                            <td>{{$attribute_value->attribute->name}}</td>
                                                            <td>{{$attribute_value->name}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </h4>
                            </div>
                        </div>
                        <div class="row top_row">

                            <div class="col-sm-2">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12">
                                        <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                            <select id="select_search_type"
                                                    class="form-control m-bootstrap-select m_selectpicker"
                                                    tabindex="-98">
                                                <option value="1">{{trans('admin.search_product')}}</option>
                                                <option value="2">{{trans('admin.search_sku')}}</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 search_product_div">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12" id="m_select_remote_products_div">
                                        <select class="form-control m-select2" id="m_select_remote_products"
                                                name="param"
                                                data-select2-id="m_select_remote_products">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 search_sku_div hidden">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12" id="m_select_remote_sku_div">
                                        <select class="form-control m-select2" id="m_select_remote_sku"
                                                name="param"
                                                data-select2-id="m_select_remote_sku">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <div style="display: inline;margin-right: 10ex;">
                                        <input type="hidden" value="{{$start_at}}" id="date_from">
                                        <input type="hidden" value="{{$end_at}}" id="date_to">

                                        <span class="m-subheader__daterange" id="m_dashboard_daterangepicker_2">
                                        									<span class="m-subheader__daterange-label">
                                        										<span class="m-subheader__daterange-title">{{$end_at ." - ".$start_at}}</span>
                                        										<span class="m-subheader__daterange-date m--font-brand"></span>
                                        									</span>
                                        									<a href="#"
                                                                               class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                        										<i class="la la-angle-down"></i>
                                        									</a>
                                        								</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="general_search"
                                        class="btn m-btn--square  btn-primary" style="width: 100%"
                                        v-text="' {{trans('admin.search')}}'">
                                    {{trans('admin.search')}}
                                </button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body m-portlet__body--no-padding">
                <div class="row top_row m-row--no-padding m-row--col-separator-xl">
                    @foreach($order_status as $chunks)
                        <div class="col-md-12 col-lg-12 col-xl-4">

                            <div class="m-widget1">
                                @foreach($chunks as $status)
                                    <div class="m-widget1__item">
                                        <div class="row top_row m-row--no-padding align-items-center">
                                            <div class="col">
                                                <h3 class="m-widget1__title">{{$status['text']}}</h3>
                                            </div>
                                            <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{$status['count_orders'] ? $status['count_orders'] : 0}}
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>
                    @endforeach

                        <div class="col-md-12 col-lg-12 col-xl-4">

                            <div class="m-widget1">

                                    <div class="m-widget1__item">
                                        <div class="row top_row m-row--no-padding align-items-center">
                                            <div class="col">
                                                <h3 class="m-widget1__title">عدد المنتجات المباعة</h3>
                                            </div>
                                            <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                             @if($type_product == 1)

                                                {{$product->order_count}}
                                            @elseif($type_product == 2)
                                                {{$product_variation->order_count}}

                                            @endif


                                        </span>
                                            </div>
                                        </div>
                                    </div>


                            </div>

                        </div>

                </div>
            </div>
        </div>
        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row  top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-4">
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row  top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">إجمالي عدد الطلبات</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">{{$count_orders}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="chart-pie-order-type"></canvas>
                    </div>
                    <div class="col-xl-8">
                        <canvas id="chart_area-order-count"></canvas>
                    </div>

                </div>
            </div>
        </div>
        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row  top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-sm-12">

                        <div class="row top_row" id="order_vue">

                            <div class="col-sm-4">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12">
                                        <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                            <select id="select_order_status"
                                                    class="form-control m-bootstrap-select m_selectpicker"
                                                    tabindex="-98">
                                                <option value="-1">{{trans('admin.order_status')}}</option>
                                                @foreach(trans_orignal_order_status() as $key=>$status)
                                                    <option value="{{$key}}">{{$status}}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12">
                                        <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                            <select id="select_order_payment_method"
                                                    class="form-control m-bootstrap-select m_selectpicker"
                                                    tabindex="-98">
                                                <option value="-1">{{trans('admin.payment_methods')}}</option>
                                                @foreach($payment_methods as $payment_method)
                                                    <option value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12">
                                        <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                            <select id="select_order_shipping_company"
                                                    class="form-control m-bootstrap-select m_selectpicker selectSearch" tabindex="-98">
                                                <option value="-1">{{trans('admin.shipping_companies')}}</option>
                                                @foreach($shipping_companies as $shipping_company)
                                                    <option value="{{$shipping_company->id}}">{{$shipping_company->name}}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12">
                                        <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                            <select id="select_search_type"
                                                    class="form-control m-bootstrap-select m_selectpicker"
                                                    tabindex="-98">
                                                <option value="1">{{trans('admin.general')}}</option>
                                                <option value="2">{{trans('admin.order_number')}}</option>
                                                <option value="3">{{trans('admin.phone')}}</option>
                                                <option value="4">{{trans('admin.total_price')}}</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-form__group row top_row">
                                    <div class="col-sm-12 col_sm_custom">
                                        <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                            <input type="text" class="form-control m-input" placeholder="ابحث"
                                                   id="searchValue">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12">
                                        <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                            <select id="select_country"
                                                    class="form-control m-bootstrap-select m_selectpicker"
                                                    tabindex="-98">
                                                <option value="-1">{{trans('admin.country')}}</option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12">
                                        <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                            <select id="select_city"
                                                    class="form-control m-bootstrap-select m_selectpicker"
                                                    tabindex="-98">
                                                <option value="-1">{{trans('admin.city')}}</option>
                                                <option v-for="city in cities" :value="city.id"
                                                        v-text="city.name"></option>


                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" :disabled="search_loading" @click="search" id="search"
                                        class="btn m-btn--square  btn-primary" style="width: 100%"
                                        v-text="' {{trans('admin.search')}}'"
                                        :class="search_loading ? 'm-loader m-loader--light m-loader--left' : ''">
                                </button>

                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-checkable responsive no-wrap order-table-1"
                               id="order-table">
                            <thead>
                            <tr>
                                <th>{{trans('admin.order_number')}}</th>
                                <th>{{trans('admin.user')}}</th>
                                <th>{{trans('admin.order_status')}}</th>
                                <th>{{trans('admin.phone')}}</th>
                                <th>{{trans('admin.payment')}}</th>
                                <th>{{trans('admin.total_price')}}</th>
                                <th>{{trans('admin.date')}}</th>
                                <th>{{trans('admin.platform')}}</th>
                                <th>{{trans('admin.shipping_company')}}</th>
                                <th>{{trans('admin.order_shipment_date')}}</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection





@push('js')

    <script>
        var type_product_id = {!! $type_product_id !!};
        var type_product = {!! $type_product !!};
        var has_option = false;
        var deleted = 0;
        var chart_orders = {!! $chart_orders !!};
        var orders_payment_type = {!! $orders_payment_type !!};
        var product = {!! $product !!};
        var product_variation = {!! $product_variation !!};
        var countries = {!! $countries !!};
        var is_return = false;

    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/admin_assets/assets/app/js/dashboard.js" type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/home/chart.js" type="text/javascript"></script>
    <script src="{{url('')}}/admin_assets/assets/general/js/home/test/utils.js"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/reports/chart_data.js" type="text/javascript"></script>
    <script src="{{url('')}}/admin_assets/assets/general/js/reports/order_product.js" type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/orders/list.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/orders/service.js"
            type="text/javascript"></script>
    <script>


        $(document).ready(function () {
            $("#m_dashboard_daterangepicker_2").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary",
                direction: mUtil.isRTL(),
                startDate: $('#start_at').val(),
                endDate: $('#end_at').val(),
                locale: {
                    "customRangeLabel": "تحديد تاريخ",
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'رجوع',
                    applyLabel: 'تطبيق',
                },
                ranges: {
                    "اليوم": [moment(), moment()],
                    "البارحة": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "أخر 7 أيام": [moment().subtract(6, "days"), moment()],
                    "أخر 30 يوم": [moment().subtract(29, "days"), moment()],
                    "هذا الشهر": [moment().startOf("month"), moment().endOf("month")],
                    "الشهر الماضي": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                }
            }, function (a, t, n) {
                $('#date_from').val(a.format("YYYY-MM-DD"));
                $('#date_to').val(t.format("YYYY-MM-DD"));
                $("#m_dashboard_daterangepicker_2 .m-subheader__daterange-label").text(a.format("YYYY-MM-DD") + " / " + t.format("YYYY-MM-DD"));
            });
        });


    </script>


@endpush

