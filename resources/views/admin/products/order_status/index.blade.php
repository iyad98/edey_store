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

        .select2-search__field {
            direction: rtl !important;
            margin-left: -25px !important;
        }

        .select2-selection__clear {
            float: left !important;
        }

        .swal2-popup .swal2-file::placeholder, .swal2-popup .swal2-input::placeholder, .swal2-popup .swal2-textarea::placeholder {
            color: #000;
        }
    </style>
@endpush


@section('content')

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


            <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">

            <div class="m-portlet__body" id="filter_product">

                <div class="row top_row">
                    <div class="col-sm-4 col-lg-3">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12" id="select_categories_div">
                                <select class="form-control m-select2" id="select_categories">
                                    <option value="-2" selected disabled hidden>{{trans('admin.categories')}}</option>
                                    <option value="-1">{{trans('admin.all')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_with_parents_text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-3">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <select id="select_sort_status" class="form-control m-bootstrap-select m_selectpicker"
                                        tabindex="-98">
                                    {{--                                    <option {{$sort_by == 1 ? 'selected': ''}} value="1" selected>{{trans('admin.filter_by')}}</option>--}}
                                    <option {{$sort_by == 1 ? 'selected': ''}} value="1">{{trans('admin.latest')}}</option>
                                    <option {{$sort_by == 2 ? 'selected': ''}}  value="2">{{trans('admin.oldest')}}</option>
                                    <option {{$sort_by == 3 ? 'selected': ''}}  value="3">{{trans('admin.most_purchase')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-3">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <select id="select_stock_status" class="form-control m-bootstrap-select m_selectpicker"
                                        tabindex="-98">
                                    <option value="-1" disabled selected hidden>{{trans('admin.stock_status')}}</option>
                                    <option value="-1">{{trans('admin.all')}}</option>
                                    @foreach($stock_status as $stock)
                                        <option value="{{$stock->id}}">{{$stock->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4 col-lg-3">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12" id="select_brands_div">
                                <select class="form-control m-select2" id="select_brands">
                                    <option value="-1" selected disabled hidden>{{trans('admin.brands')}}</option>
                                    <option value="-1">{{trans('admin.all')}}</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row top_row mt-3">
                    <div class="col-sm-4 col-lg-3">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <select id="select_product_type_status"
                                        class="form-control m-bootstrap-select m_selectpicker"
                                        tabindex="-98">
                                    <option value="-1" selected hidden disabled>{{trans('admin.product_type')}}</option>
                                    <option value="-1">{{trans('admin.all')}}</option>
                                    <option value="1">{{trans('admin.simple_product')}}</option>
                                    <option value="2">{{trans('admin.variation_product')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-lg-3">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <select id="select_order_status"
                                        class="form-control m-bootstrap-select m_selectpicker selectSearch" tabindex="-98">
                                    <option value="-1">{{trans('admin.order_status')}}</option>
                                    @foreach(trans_order_status() as $key=>$status)

                                        <option value="{{$key}}">{{$status}}</option>

                                    @endforeach

                                </select>

                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4 col-lg-3">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12">
                                <input class="form-control m-bootstrap-select m_selectpicker" placeholder="ابحث" id="searchValue">
                            </div>
                        </div>
                    </div>

                    <div style="margin-right: 2rem">
                        <button @click="search" :disabled="loading" type="button" class="btn btn-primary btn-block"
                                :class="loading ? 'm-loader m-loader--light m-loader--left' : ''"
                                @click="add_or_remove_product(1)"
                                style="border-radius: 60px">
                            {{trans('admin.filter')}}
                        </button>
                    </div>



                </div>

                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable nowrap_table" id="product-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.image')}}</th>
                        <th>{{trans('admin.name_ar')}}</th>
                        <th>{{trans('admin.sku')}}</th>

                        <th>{{trans('admin.price')}} ({{get_currency()}})</th>
                        <th>{{trans('admin.price_after')}} ({{get_currency()}})</th>

                        <th>{{trans('admin.quantity')}} </th>
                        <th>{{trans('admin.order_count')}} </th>

                        <th>{{trans('admin.actions')}}</th>

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


    <script src="{{url('')}}/admin_assets/assets/general/js/products/order_status_list.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/products/product.js"
            type="text/javascript"></script>


@endpush

