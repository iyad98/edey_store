@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <link href="{{url('')}}/admin_assets/assets/general/css/map.css" rel="stylesheet"
          type="text/css"/>

    <style>
        #m_select_city_form_div .select2-container {
            width: 100% !important;
        }

        #m_select_nighboor_form_div .select2-container {
            width: 100% !important;
        }
        #m_select_category_form_div .select2-container {
            width: 100% !important;
        }

        #m_select_sub_category_form_div .select2-container {
            width: 100% !important;
        }



        #m_select_city_form_div_add .select2-container {
            width: 100% !important;
        }

        #m_select_nighboor_form_div_add .select2-container {
            width: 100% !important;
        }
        #m_select_category_form_div_add .select2-container {
            width: 100% !important;
        }

        #m_select_sub_category_form_div_add .select2-container {
            width: 100% !important;
        }

        #m_select_remote_user_name_div .select2-container {
            width: 100% !important;
        }



    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">{{trans('admin.ads')}}</h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{route('admin.index')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>

                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('admin.ads.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{trans('admin.ads')}} </span>
                        </a>
                    </li>

                </ul>
            </div>
            <div>
                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                     m-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#"
                       class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                        <i class="la la-plus m--hide"></i>
                        <i class="la la-ellipsis-h"></i>
                    </a>
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__section m-nav__section--first m--hide">
                                            <span class="m-nav__section-text">Quick Actions</span>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                <span class="m-nav__link-text">Activity</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                <span class="m-nav__link-text">Messages</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                <span class="m-nav__link-text">FAQ</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                <span class="m-nav__link-text">Support</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__separator m-nav__separator--fit">
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="#"
                                               class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            v-text="add ? '{{trans('admin.ads_new')}}' : '{{trans('admin.ads_edit')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->

        @include('admin.ads.include.form_')

        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('admin.ads')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="javascript:;" id="add_new_offer"
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

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-sm-3">{{trans('admin.select_status')}}</label>
                            <div class="col-md-6 col-sm-12">
                                <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                    <select id="select_ads_type"
                                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                                        <option value="-1">{{trans('admin.all_status')}}</option>
                                        <option value="1">{{trans('admin.active')}}</option>
                                        <option value="0">{{trans('admin.not_active')}}</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-sm-12">
                            <input type="hidden" id="date_from" value="">
                            <input type="hidden" id="date_to" value="">
                            <div class="input-group" id="m_daterangepicker_ads_date">
                                <input type="text" class="form-control m-input" readonly="" placeholder="Select date range">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-3" data-select2-id="80" id="m_select_city_form_div">
                        <label>{{trans('admin.city_name')}}</label>
                        <select class="form-control m-select2 " id="m_select_city_form" name="param"
                                data-select2-id="m_select_city_form" tabindex="-1" aria-hidden="true">
                            <option value="-1">{{ trans('admin.all') }}</option>
                            @foreach($cities as $city)
                                <option value="{{$city->id}}">{{$city->name_en}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3" data-select2-id="80" id="m_select_nighboor_form_div">
                        <label>{{trans('admin.neighborhood_name')}}</label>
                        <select class="form-control m-select2 " id="m_select_nighboor_form" name="param"
                                data-select2-id="m_select_nighboor_form" tabindex="-1" aria-hidden="true">
                            <option value="-1">{{ trans('admin.all') }}</option>
                            <option v-for="neighborhood in neighborhoods" :value="neighborhood.id"
                                    v-text="neighborhood.name"></option>
                        </select>
                    </div>

                    <div class="col-sm-3" data-select2-id="80" id="m_select_category_form_div">
                        <label>{{trans('admin.category_name')}}</label>
                        <select class="form-control m-select2 " id="m_select_category_form" name="param"
                                data-select2-id="m_select_category_form" tabindex="-1" aria-hidden="true">
                            <option value="-1">{{ trans('admin.all') }}</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name_en}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3" data-select2-id="80" id="m_select_sub_category_form_div">
                        <label>{{trans('admin.sub_category_name')}}</label>
                        <select class="form-control m-select2 " id="m_select_sub_category_form" name="param"
                                data-select2-id="m_select_sub_category_form" tabindex="-1" aria-hidden="true">
                            <option value="-1">{{ trans('admin.all') }}</option>
                            <option v-for="sub_category in sub_categories" :value="sub_category.id"
                                    v-text="sub_category.name"></option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3" style="margin-bottom: 15px">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <button @click="search" :disabled="loading" type="button" class="btn btn-primary btn-block" :class="loading ? 'm-loader m-loader--light m-loader--left' : ''" @click="add_or_remove_product(1)">
                            بحث
                        </button>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
                <hr>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="ads-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin.name_en')}}</th>
                        <th>{{trans('admin.description_en')}}</th>
                        <th>{{trans('admin.phone')}}</th>
                        <th>{{trans('admin.status')}}</th>
                        <th>{{trans('admin.username')}}</th>
                        <th>{{trans('admin.category_name')}}</th>
                        <th>{{trans('admin.sub_category_name')}}</th>
                        <th>{{trans('admin.city_name')}}</th>
                        <th>{{trans('admin.neighborhood_name')}}</th>
                        <th>{{trans('admin.date')}}</th>
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

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/bootstrap-daterangepicker.js" type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/dropzone.js" type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/ads/list.js"
            type="text/javascript"></script>

    <script src="https://cdn.staticaly.com/gist/mpryvkin/49dafa457b9f0072b07a974969a94a27/raw/6316f8f0367ef7c4b036b9d8b465e94b95986efe/select2_extended_ajax_adapter.js"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/ads/ads.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/ads/map.js"
            type="text/javascript"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places&callback=initMap"></script>

@endpush

