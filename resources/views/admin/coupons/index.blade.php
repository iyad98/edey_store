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

        #m_select_remote_product_div .select2-container {
            width: 100% !important;
        }
        #m_select_remote_excluded_product_div .select2-container {
            width: 100% !important;
        }
        #m_select_remote_category_name_div .select2-container {
            width: 100% !important;
        }
        #m_select_remote_excluded_category_name_div .select2-container {
            width: 100% !important;
        }

        #m_select_remote_user_name_div .select2-container {
            width: 100% !important;
        }
        #m_select_remote_user_name_div .select2-selection {
            height: 41px;
        }
        .select2-search__field {
            direction: rtl!important;
            margin-left: -25px!important;
        }
        .select2-selection__clear {
            float: left!important;
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
                            v-text="add ? '{{trans('admin.new_coupon')}}' : '{{trans('admin.edit_coupon')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->


        @include('admin.coupons.include.form_')

        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body">

                <div class="row top_row">
                    <div class="col-sm-4">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_status"
                                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                        <option value="-1" selected hidden disabled>{{trans('admin.select_status')}}</option>
                                        <option value="-1">{{trans('admin.all_status')}}</option>
                                        <option value="1">{{trans('admin.active_coupon')}}</option>
                                        <option value="0">{{trans('admin.not_active_coupon')}}</option>
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
                            @check_role('add_coupons')
                                <a href="javascript:;" id="add_new_coupon"
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
                <table class="table table-striped table-bordered table-hover table-checkable" id="coupon-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.coupon')}}</th>
                        <th>{{trans('admin.status')}}</th>
                        <th>{{trans('admin.num_used')}}</th>
                        <th>{{trans('admin.value')}}</th>
                        <th>{{trans('admin.min_price')}}</th>
                        <th>{{trans('admin.max_used')}}</th>
                        <th>{{trans('admin.coupon_type')}}</th>
                        <th>{{trans('admin.start_at')}}</th>
                        <th>{{trans('admin.end_at')}}</th>

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

        var coupon_types = {!! $coupon_types !!};
    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/coupons/list.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/coupons/coupon.js"
            type="text/javascript"></script>


@endpush

