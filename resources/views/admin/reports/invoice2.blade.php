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
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        {{--
                        <h3 class="m-portlet__head-text">
                            {{trans('admin.all_orders')}}
                        </h3>
                        --}}
                        @if($order_status)
                            <div class="order-status">
                                <a href="javascript:;" class="order_status_item_-1"
                                   onclick="set_order_status(-1)">{{trans('api.all') ." : "."( $order_status->all_count )"}}</a><span
                                        class="span-slash">|</span>
                                <a href="javascript:;" class="order_status_item_4"
                                   onclick="set_order_status(4)">{{trans('api.finished') ." : "."( $order_status->finished_count )"}}</a><span
                                        class="span-slash">|</span>
                                <a href="javascript:;" class="order_status_item_6"
                                   onclick="set_order_status(6)">{{trans('api.returned') ." : "."( $order_status->returned_count )"}}</a><span
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


                <div class="row top_row">
                    <div class="col-sm-4 hidden">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-sm-4">{{trans('admin.order_status')}}</label>
                            <div class="col-md-8 col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_order_status"
                                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                        <option value="-1">{{trans('admin.all_status')}}</option>
                                        @foreach(trans_order_status() as $key=>$status)
                                            <option value="{{$key}}">{{$status}}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group m-form__group row">
{{--                            <label class="col-form-label col-sm-4">{{trans('admin.payment_methods')}}</label>--}}
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_order_payment_method"
                                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                        <option value="-1">{{trans('admin.all_status')}}</option>
                                        @foreach($payment_methods as $payment_method)
                                            <option value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                                        @endforeach

                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

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
                    <div class="col-sm-4">

                        <div class="row">
                            <div class="col-sm-4">
                                <a href="javascript:;" id="print_excel"
                                   class="btn btn-success m-btn m-btn--icon m-btn--pill">
															<span>
																<i class="fa fa-file-excel"></i>
																<span>{{trans('admin.export_excel')}}</span>
															</span>
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <a href="javascript:;" id="print_"
                                   class="btn btn-success m-btn m-btn--icon m-btn--pill">
															<span>
																<i class="fa fa-print"></i>
																<span>{{trans('admin.print')}}</span>
															</span>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>


                <hr>


                <!--begin: Datatable table-striped table-bordered table-hover table-checkable responsive no-wrap -->


                <table class="table table-striped table-bordered table-hover table-checkable responsive no-wrap"
                       id="custom-order-table">
                    <thead>
                    <tr>
                        <th>DocNum</th>
                        <th>DocEntry</th>
                        <th>DocType</th>
                        <th>Handwrtten</th>
                        <th>DocDate</th>
                        <th>DocDueDate</th>
                        <th>CardCode</th>
                        <th>DocTotal</th>
                        <th>DocCur</th>
                        <th>Ref1</th>
                        <th>Ref2</th>
                        <th>Comments</th>
                        <th>JrnlMemo</th>
                        <th>SlpCode</th>
                        <th>DiscPrcnt</th>


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
                let status = $('#select_order_status').val();
                let payment_method = $('#select_order_payment_method').val();

                let date_from = $('#date_from').val();
                let date_to = $('#date_to').val();
                let url = "{{url('admin/download-excel-invoice2-bill')}}" + "?status=" + status + "&payment_method=" + payment_method
                    + "&date_from=" + date_from + "&date_to=" + date_to;

                window.location = url;
            });
            $('#print_').click(function () {
                let status = $('#select_order_status').val();
                let payment_method = $('#select_order_payment_method').val();

                let date_from = $('#date_from').val();
                let date_to = $('#date_to').val();
                let url = "{{url('admin/print-invoice2')}}" + "?status=" + status + "&payment_method=" + payment_method
                    + "&date_from=" + date_from + "&date_to=" + date_to;

                window.open(url, '_blank');
            });
        });
    </script>

    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/reports/invoice2.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js"
            type="text/javascript"></script>


@endpush

