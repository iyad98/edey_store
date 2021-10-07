@extends('admin.layout')


@push('css')

    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <link href="{{url('')}}/admin_assets/assets/general/css/slider.css" rel="stylesheet"
          type="text/css"/>

    <link href="{{url('')}}/admin_assets/assets/general/css/map.css" rel="stylesheet"
          type="text/css"/>
    
    <style>
        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table thead tr th {
            text-align: right !important;
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tbody tr td {
            text-align: center !important;
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__body table tfoot tr td {
            padding: 1rem 0 1rem 0;
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__head .m-invoice__container .m-invoice__items {
            padding: 2rem 0 3rem 0;
        }

        .m-invoice-2 .m-invoice__wrapper .m-invoice__footer {
            margin-top: 1rem;
        }

        .h-scroll {
            overflow-x: auto;
            white-space: nowrap;
        }

        .text-center {
            text-align: center;
        }

        /*********************/

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
                            <span class="m-nav__link-text">{{trans('admin.ads')}}</span>
                        </a>

                    </li>

                    {{--
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <i id="download" class="fa fa-file-pdf" style="color: red;font-size: 25px;cursor: pointer"></i>
                        <i class="load_pdf hidden fa fa-spin fa-spinner"></i>
                    </li>
                    --}}

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
                </div>
            </div>
        </div>
    </div>


    <!-- END: Subheader -->
    <div class="m-content" id="app">


        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">

                </div>
            </div>

            <!--begin::Form-->
            <!--end::Form-->
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__body m-portlet__body--no-padding">
                        <div class="m-invoice-2">
                            <div class="m-invoice__wrapper">
                                <div class="m-invoice__head">
                                    <div class="m-invoice__container m-invoice__container--centered"
                                         id="order_details_1">
                                        <input type="hidden" :value="ads.id" id="get_ads_id">
                                        <div class="m-invoice__logo">
                                            <a href="#">
                                                <h1>{{trans('admin.ads_details')}} : <span v-text="ads.id"></span>
                                                </h1>
                                            </a>
                                            <a href="" class="m-brand__logo-wrapper">
                                                <img alt=""
                                                     src="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/logo-1.png">
                                            </a>
                                        </div>
                                        <span class="m-invoice__desc">
															<span v-text="ads.city.name_en" style="font-weight: 600;"></span>
															<span v-text="ads.neighborhood ? ads.neighborhood.name_en : ''" style="font-weight: 600;"></span>

	                                                        <span style="float: right;color: black;font-weight: 600;">التقييم : @{{ ads.avg_rate+'/5' }}  </span>
                                        </span>


                                        <div class="m-invoice__items slide">
                                            <div class="slideshow-container">

                                                <div class="mySlides fade" v-for="(image , index) in ads.images">
                                                    <div class="numbertext"
                                                         v-text="(index+1)+'/'+ads.images.length"></div>
                                                    <img :src="image.image" style="width:100%">
                                                </div>

                                                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                                <a class="next" onclick="plusSlides(1)">&#10095;</a>

                                            </div>
                                            <br>

                                            <div style="text-align:center">
                                                <span v-for="(image , index) in ads.images" class="dot"
                                                      @click="currentSlide(index+1)"></span>

                                            </div>

                                        </div>

                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.ads_date')}}</span>
                                                <span class="m-invoice__text" v-text="ads.created_at"></span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.name')}}</span>
                                                <span class="m-invoice__text" v-text="ads.name_en"></span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.description')}}</span>
                                                <span class="m-invoice__text" v-text="ads.description_en"></span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.phone')}}</span>
                                                <span class="m-invoice__text" v-text="ads.phone"></span>
                                            </div>


                                        </div>
                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.user_name')}}</span>
                                                <span class="m-invoice__text"
                                                      v-text="ads.user.f_name + ' ' +ads.user.l_name"></span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.user_email')}}</span>
                                                <span class="m-invoice__text" v-text="ads.user.email"></span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.user_phone')}}</span>
                                                <span class="m-invoice__text" v-text="ads.user.phone"></span>
                                            </div>


                                        </div>
                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.category_name')}}</span>
                                                <span class="m-invoice__text" v-text="ads.category.name_en"></span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.sub_category_name')}}</span>
                                                <span class="m-invoice__text" v-text="ads.sub_category ?ads.sub_category.name_en : ''"></span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.city_name')}}</span>
                                                <span class="m-invoice__text" v-text="ads.city.name_en"></span>
                                            </div>
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.neighborhood_name')}}</span>
                                                <span class="m-invoice__text" v-text="ads.neighborhood.name_en"></span>
                                            </div>


                                        </div>


                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.comments')}}</span>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped- table-bordered table-hover table-checkable"
                                                               id="ads-comment-table">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>{{trans('admin.user_image')}}</th>
                                                                <th>{{trans('admin.name')}}</th>
                                                                <th>{{trans('admin.comment')}}</th>

                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.rates')}}</span>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped- table-bordered table-hover table-checkable"
                                                               id="ads-rate-table">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>{{trans('admin.user_image')}}</th>
                                                                <th>{{trans('admin.name')}}</th>
                                                                <th>{{trans('admin.rate')}}</th>

                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.follows')}}</span>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped- table-bordered table-hover table-checkable"
                                                               id="ads-follow-comment-table">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>{{trans('admin.user_image')}}</th>
                                                                <th>{{trans('admin.name')}}</th>

                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item">
                                                <span class="m-invoice__subtitle">{{trans('admin.contact_seller')}}</span>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-striped- table-bordered table-hover table-checkable"
                                                               id="ads-contact-seller-table">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>{{trans('admin.user_image')}}</th>
                                                                <th>{{trans('admin.name')}}</th>
                                                                <th>{{trans('admin.title')}}</th>
                                                                <th>{{trans('admin.message')}}</th>

                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12">
                                                <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                                                <div id="map"></div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





@push('js')

    <script>
        var ads = {!! $ads !!};
    </script>
    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/clipboard.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/ads/ads_details.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/ads/ads_list_details.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/slider.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/ads/map.js"
            type="text/javascript"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_API_KEY')}}&libraries=places&callback=initMap"></script>

    <script>
        var lat = {!! $ads->lat !!};
        var lng = {!! $ads->lng !!};

        var uluru = {lat:lat, lng: lng};
        marker.setPosition(uluru);
        map.setCenter(uluru);
    </script>
@endpush

