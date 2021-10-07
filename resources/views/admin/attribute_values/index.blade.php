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
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">{{trans('admin.attribute_values')}}</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('admin.index')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>

                    <li class="m-nav__item">
                        <a href="{{route('admin.attributes.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{trans('admin.attributes')}} </span>
                        </a>
                    </li>

                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('admin.attribute_values.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{trans('admin.attribute_values')}} </span>
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
                            v-text="add ? '{{trans('admin.new_attribute_value')}}' : '{{trans('admin.edit_attribute_value')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->


        @include('admin.attribute_values.include.form_')


        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('admin.attribute_values') ." : "}} <span style="color: blue">{{$attribute->name}}</span>
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        @check_role('add_attributes')
                        <li class="m-portlet__nav-item">
                            <a href="javascript:;" id="add_new_attribute_value"
                               class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-user-plus"></i>
													<span>{{trans('admin.add_new')}}</span>
												</span>
                            </a>
                        </li>
                        @endcheck_role
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <div class="row">

                </div>
                <hr>
                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable"
                       id="attribute-value-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.name_ar')}}</th>
                       {{-- <th>{{trans('admin.name_en')}}</th> --}}
                        <th>{{trans('admin.value')}}</th>
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
        var attribute = {!! $attribute !!};
    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/attribute_values/list.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/attribute_values/attribute_values.js"
            type="text/javascript"></script>


@endpush

