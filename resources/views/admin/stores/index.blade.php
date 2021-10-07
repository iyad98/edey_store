@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <style>
        #m_select_city_form_div .select2-container {
            width: 100%!important;
        }
        #m_select_country_form_div2 .select2-container {
            width: 100%!important;
        }
        #map {
            height: 500px;
            width: 100%;
        }
        .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            font-family: Roboto;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }
        #target {
            width: 345px;
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
                            v-text="add ? '{{trans('admin.new_store')}}' : '{{trans('admin.edit_store')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->


        @include('admin.stores.include.form_')


        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body">

                <div class="row top_row">

                    <div class="col-sm-4 col-lg-3 custom_col">
                        <div class="form-group m-form__group row top_row">
                            <div class="col-sm-12 col_sm_custom">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <input type="text" class="form-control m-input" placeholder="ابحث" id="searchValue">
                                </div>
                            </div>
                        </div>
                    </div>
                    @check_role('edit_stores')
                    <div class="col-sm-4">
                        <a href="javascript:;" id="add_new_store"
                           class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-user-plus"></i>
													<span>{{trans('admin.add_new')}}</span>
												</span>
                        </a>
                    </div>
                    @endcheck_role
                </div>
                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkabl nowrap_tablee" id="store-table">
                    <thead>
                    <tr>
                        <th>#</th>

                        <th>{{trans('admin.name_ar')}}</th>
                        <th>{{trans('admin.city')}}</th>
                        <th>{{trans('admin.phone')}}</th>
                        <th>{{trans('admin.address_ar')}}</th>
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

    <script src="{{url('')}}/admin_assets/assets/general/js/stores/list.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/stores/store.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/stores/map.js"
            type="text/javascript"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places&callback=initMap"
    ></script>
@endpush

