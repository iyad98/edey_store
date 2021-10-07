@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <style>
        #m_select_category_form_div .select2-container {
            width: 100%!important;
        }
        #m_select_category_form_div2 .select2-container {
            width: 100%!important;
        }

        #m_select_banner_value_form_div .select2-container {
            width: 100%!important;
        }
        #m_select_banner_value_form_div2 .select2-container {
            width: 100%!important;
        }
        #m_select_remote_marketing_products_div .select2-container {
            width: 100% !important;
        }
    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">{{trans('admin.banner_values')}}</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('admin.index')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>

                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('admin.banners.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{trans('admin.banners')}} </span>
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </div>

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
                            v-text="add ? '{{trans('admin.new_banner_value')}}' : '{{trans('admin.edit_banner_value')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->


        @include('admin.banners.include.form_banner_values')


        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('admin.banner_values') ." : "}} <span style="color: blue">{{$banner->name}}</span>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="javascript:;" id="add_new_banner_value"
                               class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-user-plus"></i>
													<span>{{trans('admin.add_new')}}</span>
												</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">


                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable" id="banner_value-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.image_app')}}</th>
                        <th>{{trans('admin.image_web')}}</th>
                        <th>{{trans('admin.name_ar')}}</th>
                        <th>{{trans('admin.select_pointer')}}</th>
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

    <script>
        var parent_id = {!! $banner->id !!};
        var default_image = "{{getImage('banners' ,'true')}}";

    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/banners/banner_value_list.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/banners/banner_value.js"
            type="text/javascript"></script>


@endpush

