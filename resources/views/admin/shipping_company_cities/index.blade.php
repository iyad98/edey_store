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

        <input type="hidden" value="{{$shipping_company_country_id}}" id="get_shipping_company_country_id">

        <div class="m-portlet">
            <div class="m-portlet__body m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-sm-3">

                        <!--begin:: Widgets/Stats2-1 -->
                        <div class="m-widget1" style="padding: 5px;!important;">
                            <div class="m-widget1__item">
                                <div class="row">
                                    <div class="col ml-4">
                                        <h3 class="m-widget1__title">{{trans('admin.shipping_company')}}</h3>
                                    </div>
                                    <div class="col">
                                        <span class="m-widget1__number m--font-brand">{{$shipping_company_country->shipping_company->name}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end:: Widgets/Stats2-1 -->
                    </div>
                    <div class="col-sm-4">

                        <!--begin:: Widgets/Stats2-2 -->
                        <div class="m-widget1" style="padding: 5px;!important;">
                            <div class="m-widget1__item">
                                <div class="row ">
                                    <div class="col ml-4">
                                        <h3 class="m-widget1__title">{{trans('admin.country')}}</h3>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="m-widget1__number m--font-accent">{{$shipping_company_country->country->name}}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--begin:: Widgets/Stats2-2 -->
                    </div>

                </div>
            </div>
        </div>

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                        <h3 class="m-portlet__head-text"
                            v-text="add ? '{{trans('admin.new_shipping_company_city')}}' : '{{trans('admin.edit_shipping_company_city')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->


        @include('admin.shipping_company_cities.include.form_')


        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body">

                <div class="row top_row">
                    <div class="col-sm-4">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-8">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_order_option"
                                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                        <option value="-1">{{trans('admin.execute_option')}}</option>

                                        <option value="1">{{trans('admin.activate_cash')}}</option>
                                        <option value="2">{{trans('admin.deactivate_cash')}}</option>
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
                        @check_role('add_shipping_companies')
                        <a href="javascript:;" id="add_new_shipping_company"
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
                <table class="table table-striped table-bordered table-hover table-checkable nowrap_table"
                       id="shipping-company-table">
                    <thead>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-sm-3" style="margin-top: -4%">
                                    <label class="m-checkbox m-checkbox--state-brand">
                                        <input type="checkbox" id="check_all">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    {{trans('admin.name_ar')}}
                                </div>

                            </div>

                        </th>
                        <th>{{trans('admin.cash')}}</th>
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

        var cities ={!! $cities !!};
        var city_ids_not_in_shipping_company = {!! $city_ids_not_in_shipping_company !!};
    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/shipping_company_cities/list.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/shipping_company_cities/shipping_company_cities.js"
            type="text/javascript"></script>


@endpush

