@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>
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
                            v-text="add ? '{{trans('admin.add_new_user')}}' : '{{trans('admin.edit_user')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
        @include('admin.users.include.form_user')
        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_users">
            <div class="m-portlet__body">

                <div class="row top_row">
                    <div class="col-sm-4">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_status"
                                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                        <option value="-1" selected disabled hidden>{{trans('admin.select_status')}}</option>
                                        <option value="-1">{{trans('admin.all_status')}}</option>
                                        <option value="1">{{trans('admin.active')}}</option>
                                        <option value="0">{{trans('admin.not_active')}}</option>
                                    </select>

                                </div>
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
                        @check_role('add_users')
                        <a href="javascript:;" id="add_new_user"
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
                <table class="table table-striped table-bordered table-hover table-checkable nowrap_table" id="user">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.image')}}</th>
                        <th>{{trans('admin.f_name')}}</th>
                        <th>{{trans('admin.l_name')}}</th>
                        <th>{{trans('admin.email')}}</th>
                        <th>{{trans('admin.phone')}}</th>
                        <th>{{trans('admin.membership')}}</th>
                        <th>{{trans('admin.status')}}</th>
                        <th>{{trans('admin.actions')}}</th>

                    </thead>
                </table>
            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')

    @include('admin.components.success_error_template')
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/user/list.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/user/user.js"
            type="text/javascript"></script>

@endpush

