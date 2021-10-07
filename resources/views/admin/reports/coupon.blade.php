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
        .order-status-active {
            color: black;
            font-weight: 600;
        }

    </style>

@endpush


@section('content')


    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->
    <div class="m-content" id="app">

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">

                </div>
            </div>

            <!--begin::Form my-block-overlay-->
            <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data ">
            <div class="m-portlet__body">


                <div class="row top_row">

                    <div class="col-sm-4">
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
                    {{--<div class="col-sm-4">--}}

                        {{--<div class="row">--}}
                            {{--<div class="col-sm-4">--}}
                                {{--<a href="javascript:;" id="print_excel" class="btn btn-success m-btn m-btn--icon m-btn--pill">--}}
															{{--<span>--}}
																{{--<i class="fa fa-file-excel"></i>--}}
																{{--<span>{{trans('admin.export_excel')}}</span>--}}
															{{--</span>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-4">--}}
                                {{--<a href="javascript:;" id="print_" class="btn btn-success m-btn m-btn--icon m-btn--pill">--}}
															{{--<span>--}}
																{{--<i class="fa fa-print"></i>--}}
																{{--<span>{{trans('admin.print')}}</span>--}}
															{{--</span>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}



                    {{--</div>--}}
                </div>


                <hr>


                <!--begin: Datatable table-striped table-bordered table-hover table-checkable responsive no-wrap -->


                <table class="table table-striped table-bordered table-hover table-checkable responsive no-wrap"
                       id="order-table">
                    <thead>
                    <tr>
                        <th>{{trans('admin.coupon_code')}}</th>
                        <th>{{trans('admin.discount_rate')}}</th>
                        <th>{{trans('admin.user_famous_rate')}}</th>
                        <th>{{trans('admin.total_orders')}}</th>
                        <th>{{trans('admin.coupon_checked_count')}}</th>
                        <th>{{trans('admin.total_discounts')}}</th>
                        <th>{{trans('admin.pending_orders')}}</th>
                        <th>{{trans('admin.pending_orders_price')}}</th>
                        <th>{{trans('admin.confirm_orders')}}</th>
                        <th>{{trans('admin.confirm_orders_price')}}</th>
                        <th>{{trans('admin.user_famous_total_price')}}</th>


                    </thead>
                </table>


            </div>
        </div>


    </div>

@endsection





@push('js')


    <script>
        $(document).ready(function () {
            $('#print_excel').click(function () {
              //  let status = $('#select_order_status').val();
              //  let payment_method = $('#select_order_payment_method').val();

                let date_from = $('#date_from').val();
                let date_to = $('#date_to').val();
                let url = "{{url('admin/download-excel-coupon-bill')}}"+"?date_from="+date_from+"&date_to="+date_to;

                window.location = url;
            });
            $('#print_').click(function () {
                let status = $('#select_order_status').val();
                let payment_method = $('#select_order_payment_method').val();

                let date_from = $('#date_from').val();
                let date_to = $('#date_to').val();
                let url = "{{url('admin/print-coupon')}}"+"?date_from="+date_from+"&date_to="+date_to;

                window.open(url, '_blank');
            });
        });
    </script>

    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/reports/coupon.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js"
            type="text/javascript"></script>


@endpush

