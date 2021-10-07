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


        @include('admin.shipping_companies.include.countries')
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


        @include('admin.shipping_companies.include.form_')


        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body">

                <div class="row top_row">

                    <div class="col-sm-4">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12" data-select2-id="80" id="m_select_city_form_div2">
                                <select class="form-control m-select2 " id="m_select_country_form2" name="param"
                                        data-select2-id="m_select_city_form_div2" tabindex="-1" aria-hidden="true">
                                    <option value="-1" selected hidden disabled>{{trans('admin.country')}}</option>
                                    <option value="-1">{{trans('admin.all')}}</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
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
                        <th>#</th>
                        <th>{{trans('admin.image')}}</th>
                        <th>{{trans('admin.name_ar')}}</th>
                        <th>{{trans('admin.phone')}}</th>
                        <th>{{trans('admin.show_for_user')}}</th>
                        {{--  <th>{{trans('admin.name_en')}}</th> --}}
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

    <script src="{{url('')}}/admin_assets/assets/general/js/shipping_companies/list.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/shipping_companies/shipping_companies.js"
            type="text/javascript"></script>


@endpush

