@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <style>
        #m_select_category_form_div .select2-container {
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
                            v-text="add ? '{{trans('admin.add_new_category')}}' : '{{trans('admin.edit_category')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
        @include('admin.categories.include.form_category')
        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body">

                <div class="row top_row">
                    {{--
                    <div class="col-sm-6">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-sm-3">{{trans('admin.select_category_type')}}</label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_category_type"
                                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                        <option value="-1">الكل</option>
                                        @foreach($category_types as $category_type)
                                            <option value="{{$category_type->id}}">{{$category_type->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    --}}

                    <div class="col-sm-4">
                        <input type="hidden" id="main_category_text" value="{{trans('admin.main_category')}}">
                        <div class="form-group m-form__group row">
{{--                            <label class="col-form-label col-lg-3 col-sm-12">{{trans('admin.select_category_parent')}}</label>--}}
                            <div class="col-sm-12" data-select2-id="80">
                                <select class="form-control m-select2 " id="m_select2_2" name="param"
                                        data-select2-id="m_select2_2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled hidden>{{trans('admin.select_category_parent')}}</option>
                                    <option v-for="category_parent in category" :value="category.id">@{{ category.name
                                        }}
                                    </option>

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
                            @check_role('add_categories')
                                <a href="javascript:;" id="add_new_category"
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
                <table class="table table-striped table-bordered table-hover table-checkable nowrap_table" id="category-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.image')}}</th>
                       {{--  <th>{{trans('admin.name_en')}}</th> --}}
                        <th>{{trans('admin.name_ar')}}</th>
                       {{--  <th>{{trans('admin.description_en')}}</th> --}}
                        <th>{{trans('admin.description_ar')}}</th>
                        <th>{{trans('admin.category_parent')}}</th>
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
        var default_image = "{{getImage('categories' ,'true')}}";
    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/categories/list.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/categories/category.js"
            type="text/javascript"></script>


@endpush

