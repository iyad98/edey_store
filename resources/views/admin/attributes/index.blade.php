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

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                        <h3 class="m-portlet__head-text"
                            v-text="add ? '{{trans('admin.new_attribute')}}' : '{{trans('admin.edit_attribute')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->

        @include('admin.attributes.include.form_')

        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body">

                <div class="row top_row">

                    <div class="col-sm-4">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <select id="select_type"
                                        class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                    <option value="-1" selected disabled hidden>{{trans('admin.attribute_type')}}</option>
                                    <option value="-1">{{trans('admin.all')}}</option>
                                    <option v-for="attribute_type in attribute_types" :value="attribute_type.id"
                                            v-text="attribute_type.name"></option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-3 custom_col">
                        <div class="form-group m-form__group row top_row">
                            <div class="col-sm-12 col_sm_custom">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <input type="text" class="form-control m-input" placeholder="ابحث" id="searchValue">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                            @check_role('add_attributes')
                                <a href="javascript:;" id="add_new_attribute"
                                   class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-user-plus"></i>
													<span>{{trans('admin.add_new')}}</span>
												</span>
                                </a>
                            @endcheck_role
                    </div>

                </div>
                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable nowrap_table" id="attribute-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.name_ar')}}</th>
                        {{-- <th>{{trans('admin.name_en')}}</th> --}}
                        <th>{{trans('admin.attribute_type')}}</th>
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

        var attribute_types = {!! $attribute_types !!};
    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/attributes/list.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/attributes/attributes.js"
            type="text/javascript"></script>


@endpush

