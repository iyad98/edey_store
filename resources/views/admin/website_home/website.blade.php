@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <link href="{{url('')}}/admin_assets/assets/vendors/custom/jquery-ui/jquery-ui.bundle.css" rel="stylesheet"
          type="text/css"/>

    <link href="{{url('')}}/admin_assets/assets/general/css/nested_sortable/nested_sortable.css" rel="stylesheet"
          type="text/css"/>


    <style>

        #m_select_remote_marketing_products_div .select2-container {
            width: 100%!important;
        }
        #m_select_category_form_div .select2-container {
            width: 100%!important;
        }

        #select_categories_div .select2-container {
            width: 100% !important;
        }

        #select_categories_2_div .select2-container {
            width: 100% !important;
        }

        #select_banners_div select2-container {
            width: 100% !important;
        }

    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->
    <!-- END: Subheader -->
    <div class="m-content" id="app_categories">

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                        <h3 class="m-portlet__head-text">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
            <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">

            <div class="m-portlet__body">

                <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

{{--                @include('admin.website_home.partals.note_image')--}}

                @include('admin.website_home.partals.note1')

                @include('admin.website_home.partals.note2')

                @include('admin.website_home.partals.widget')

                @include('admin.website_home.partals.category')

                <hr>

            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection
@push('js')
    <script>

        var app_home_banner_categories = {!! $app_home_banner_categories !!};
        var sidebar_categories = {!! $sidebar_categories !!};
        var all_categories = {!! $categories !!};
        var banners = {!! $banners !!};

        var website_note = {!! $website_note !!};
        var website_note_text_first = {!! $website_note_text_first !!};

        var website_note_text_second = {!! $website_note_text_second !!};

    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/jquery-ui/jquery-ui.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/tree.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/nested_sortable/jquery.nestable.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/website/website-nested_sortable.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/website/website_home.js"
            type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $('.dd').nestable({/* config options */});
        });
    </script>
@endpush

