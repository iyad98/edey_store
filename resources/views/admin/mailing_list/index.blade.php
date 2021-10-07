@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <style>
        #m_select_city_form_div .select2-container {
            width: 100% !important;
        }

        #m_select_type_form_div2 .select2-container {
            width: 100% !important;
        }

    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->
    <div class="m-content" id="app">



        <div class="m-portlet m-portlet--mobile show_data">
        <div class="m-portlet__body">

            {{--<div class="row top_row">--}}

                {{--<div class="col-sm-4">--}}

                    {{--<div class="col-sm-6" style="display: inline">--}}
                        {{--<a href="javascript:;" id="print_excel" class="btn btn-success m-btn m-btn--icon m-btn--pill">--}}
															{{--<span>--}}
																{{--<i class="fa fa-file-excel"></i>--}}
																{{--<span>تصدير</span>--}}
															{{--</span>--}}
                        {{--</a>--}}
                    {{--</div>--}}


                {{--</div>--}}
            {{--</div>--}}

            <!--begin: Datatable -->
            <table class="table table-striped table-bordered table-hover table-checkable nowrap_table" id="mailing-list-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{trans('admin.email')}}</th>


                </thead>
            </table>
        </div>
    </div>

    <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')

    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/mailing_list/list.js"
            type="text/javascript"></script>


    <script>
        $(document).ready(function () {
            $('#print_excel').click(function () {
                let url = "{{url('admin/download-excel-mailing-list')}}"
                window.location = url;
            });

        });
    </script>


@endpush

