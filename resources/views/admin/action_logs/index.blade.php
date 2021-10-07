@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>
    <style>
        table th {
            text-align: center;
        }
    </style>
@endpush


@section('content')

    <!-- END: Subheader -->
    <div class="m-content" id="app">

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">

                </div>
            </div>

            <!--begin::Form-->
            <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
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
                    <div class="col-sm-3"></div>
                </div>
                <hr>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap"
                       id="action-logs-table">
                    <thead>
                    <tr>
                        <th>{{trans('admin.admin')}}</th>
                        <th>{{trans('admin.description')}}</th>
                        <th>{{trans('admin.date')}}</th>
                    </thead>
                </table>
            </div>
        </div>

    </div>

@endsection


@push('js')

    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/action_logs/list.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js" type="text/javascript"></script>


@endpush

