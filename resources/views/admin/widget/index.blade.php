@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <style>
        #m_select_city_form_div .select2-container {
            width: 100% !important;
        }

        #m_select_city_form_div2 .select2-container {
            width: 100% !important;
        }

    </style>
@endpush


@section('content')
    <div class="m-content" id="app">


        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                        <h3 class="m-portlet__head-text"
                            v-text="add ? '{{trans('admin.new_shipping_company')}}' : '{{trans('admin.edit_shipping_company')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->


{{--        @include('admin.shipping_companies.include.form_')--}}


        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable nowrap_table"
                       id="widget">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.name_ar')}}</th>
                          <th>{{trans('admin.name_en')}}</th>
                        <th>{{trans('admin.product_counts')}}</th>
                        <th>{{trans('admin.actions')}}</th>

                    </thead>
                </table>
            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')

    <script>

    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/widget/list.js"
            type="text/javascript"></script>


    {{--<script src="{{url('')}}/admin_assets/assets/general/js/widget/shipping_companies.js"--}}
            {{--type="text/javascript"></script>--}}


@endpush

