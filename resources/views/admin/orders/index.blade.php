@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <style>
        .dir-ltr {
            direction: ltr;
        }

        .order-status a {
            margin-right: 10px;
        }

        .span-slash {
            margin-left: 6px;
            margin-right: 6px;
        }

        #order-table th{
            text-align: center;
        }
        #order-table td{
            white-space: nowrap !important;
        }

        /*#order-table td{*/
        /*    white-space: nowrap !important;*/
        /*}*/

        .order-status-active {
            color: black;
            font-weight: 600;
        }

    </style>

@endpush


@section('content')


    <div class="m-content custom_content" id="app">

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">

                </div>
            </div>

            <!--begin::Form my-block-overlay-->
            <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data ">
            <div class="m-portlet__head custom_head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">

                        @if($order_status && $deleted == 0)
                            <div class="order-status" style="background-color: white;border-bottom: none;">

                                <a href="javascript:;" class="order_status_item_-1"
                                   onclick="set_order_status(-1)">{{trans('api.all') ." : "."( $order_status->all_count )"}}</a><span
                                        class="span-slash">|</span>



                                <a href="javascript:;" class="order_status_item_0"
                                   onclick="set_order_status(0)">{{trans('api.new') ." : "."( $order_status->new_count )"}}</a><span
                                        class="span-slash">|</span>

                                <a href="javascript:;" class="order_status_item_1"
                                   onclick="set_order_status(1)">{{trans('api.processing') ." : "."( $order_status->processing_count )"}}</a><span
                                        class="span-slash">|</span>

                                <a href="javascript:;" class="order_status_item_2"
                                   onclick="set_order_status(2)">{{trans('api.finished') ." : "."( $order_status->finished_count )"}}</a><span
                                        class="span-slash">|</span>

                                <a href="javascript:;" class="order_status_item_2"
                                   onclick="set_order_status(3)">{{trans('api.failed') ." : "."( $order_status->failed_count )"}}</a><span
                                        class="span-slash">|</span>

                                <a href="javascript:;" class="order_status_item_2"
                                   onclick="set_order_status(4)">{{trans('api.canceled') ." : "."( $order_status->canceled_count )"}}</a><span
                                        class="span-slash">|</span>





                            </div>
                        @endif

                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">

                        </li>

                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">


                <div class="row top_row" id="order_vue">

                    <div class="col-sm-3">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-8">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_order_option"
                                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                        <option value="-1">{{trans('admin.execute_option')}}</option>

                                        @if($deleted == 1)
                                            <option value="-2">{{trans('admin.restore_from_trash')}}</option>
                                        @endif
                                        @if($deleted == 0)
                                            <option value="-3">{{trans('admin.move_to_trash')}}</option>
                                            <option value="-4">{{trans('admin.print')}}</option>

                                        @foreach(trans_orignal_order_status() as $key=>$status)
                                                <option value="{{$key}}">{{trans('admin.change_status_to', ['status' => $status])}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" :disabled="loading" @click="execute_option"
                                        class="btn m-btn--square  btn-primary"
                                        v-text="' {{trans('admin.apply')}}'"
                                        :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                                </button>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_order_status"
                                            class="form-control m-bootstrap-select m_selectpicker selectSearch" tabindex="-98">
                                        <option value="-1">{{trans('admin.order_status')}}</option>
                                        @foreach(trans_orignal_order_status() as $key=>$status)

                                             <option value="{{$key}}">{{$status}}</option>

                                        @endforeach

                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_order_payment_method"
                                            class="form-control m-bootstrap-select m_selectpicker selectSearch" tabindex="-98">
                                        <option value="-1">{{trans('admin.payment_methods')}}</option>
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
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
                        <div class="col-sm-12">
                            <input type="hidden" id="date_from" value="">
                            <input type="hidden" id="date_to" value="">
                            <div class="input-group" id="m_daterangepicker_order_date">
                                <input type="text" class="form-control m-input" readonly="" placeholder="اختار تاريخ">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_search_type"
                                            class="form-control m-bootstrap-select m_selectpicker " tabindex="-98">
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
                                    <input type="text" class="form-control m-input" @keyup.enter="search()" placeholder="ابحث" id="searchValue">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" :disabled="search_loading" @click="search" id="search"
                                class="btn m-btn--square  btn-primary"
                                v-text="' {{trans('admin.search')}}'"
                                :class="search_loading ? 'm-loader m-loader--light m-loader--left' : ''">
                        </button>

                    </div>
                    <div class="col-sm-2">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_country"
                                            class="form-control m-bootstrap-select m_selectpicker selectSearch" tabindex="-98">
                                        <option value="-1">{{trans('admin.country')}}</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_city"
                                            class="form-control m-bootstrap-select m_selectpicker selectSearch" tabindex="-98">
                                        <option value="-1">{{trans('admin.city')}}</option>
                                        <option v-for="city in cities" :value="city.id" v-text="city.name"></option>


                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_platform"
                                            class="form-control m-bootstrap-select m_selectpicker selectSearch" tabindex="-98">
                                        <option value="-1">{{trans('admin.platform')}}</option>
                                        <option value="web">web</option>

                                        <option value="ios">ios</option>
                                        <option value="android">android</option>


                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    {{--<div class="col-md-1">--}}
                        {{--<a href="javascript:;" id="print_excel" class="btn btn-success m-btn m-btn--icon m-btn--pill">--}}
															{{--<span>--}}
																{{--<i class="fa fa-file-excel"></i>--}}
																{{--<span>تصدير</span>--}}
															{{--</span>--}}
                        {{--</a>--}}

                    {{--</div>--}}
                </div>



                <!--begin: Datatable -->


                <table class="table table-striped table-bordered table-hover table-checkable responsive no-wrap order-table-1"
                       id="order-table">
                    <thead>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-sm-3" style="margin-top: -16%">
                                    <label class="m-checkbox m-checkbox--state-brand">
                                        <input type="checkbox" id="check_all">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    #
                                </div>

                            </div>

                        </th>
                        <th>{{trans('admin.user')}}</th>
                        <th>{{trans('admin.order_status')}}</th>
                        <th>{{trans('admin.phone')}}</th>
                        <th>{{trans('admin.payment')}}</th>
                        <th>{{trans('admin.total_price')}}</th>
                        <th>{{trans('admin.date')}}</th>
                        <th>{{trans('admin.platform')}}</th>
                        <th>{{trans('admin.shipping_company')}}</th>
                        <th>{{trans('admin.order_shipment_date')}}</th>
{{--                        <th>{{trans('admin.actions')}}</th>--}}

                    </thead>
                </table>


            </div>
        </div>


    </div>

@endsection





@push('js')


    <script>
        var deleted = {!! $deleted !!};
        var has_option = true;
        var type_product_id = -1;
        var type_product = -1;
        var countries = {!! $countries !!};
        var is_return = {!! $is_return !!};

        $(document).ready(function () {
            $('#print').click(function () {

                window.location = "{{url('tesryu')}}";
            });
        });
    </script>

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
            $('#print_excel').click(function () {
                let url = "{{url('admin/order/download-excel')}}"
                window.location = url;
            });

        });
    </script>

@endpush

