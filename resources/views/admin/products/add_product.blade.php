@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <link href="{{url('')}}/admin_assets/assets/general/css/products/style.css" rel="stylesheet"
          type="text/css"/>


    <style>
        .dz-image img {
            width: 120px !important;
        }

    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->
    <div class="m-content" id="app">

        <div class="m-portlet add_form">

            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>

                        <h3 class="m-portlet__head-text"
                            v-text="add ? '{{trans('admin.new_product')}}' : '{{trans('admin.edit_product')}}'">
                        </h3>


                    </div>
                </div>
                <div style="width: 72%;">
                    <select class="form-control" v-model="product_type" style="width: 200px;margin: 10px;">
                        <option value="1">{{trans('admin.simple_product')}}</option>
                        <option value="2">{{trans('admin.variation_product')}}</option>
                    </select>
                </div>


            </div>

            <!--begin::Form-->

        @include('admin.products.include.form_')

        <!--end::Form-->
        </div>

    </div>
@endsection





@push('js')

    <script>
        var default_image = "{{getImage('products' ,'true')}}";
        var tax_status = {!! $tax_status !!};
        var stock_status = {!!  $stock_status!!};
        var attributes = {!! $attributes !!};
        var categories = {!! $categories !!};
        var brands = {!! $brands !!};
        var merchants = {!! $merchants !!};
        var main_categories = {!! $main_categories !!};
        var get_categories_with_children = {!! $get_categories_with_children !!};
        var countries = {!! $countries !!};

    </script>

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/dropzone.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/products/service.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/products/init.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/summernote.js"
            type="text/javascript"></script>


@endpush

