@extends('admin.layout')


@push('css')
    <style>


        #m_select_remote_marketing_products_div .select2-container {
            width: 100%!important;
        }
        #m_select_category_form_div .select2-container {
            width: 100%!important;
        }

        #m_select_remote_marketing_products_div_2 .select2-container {
            width: 100%!important;
        }
        #m_select_category_form_div_2 .select2-container {
            width: 100%!important;
        }
        #m_select_remote_users_div .select2-container {
            width: 100%!important;
        }
        #m_select_remote_countries_div .select2-container {
            width: 100%!important;
        }
    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->
    <div class="m-content" id="app">

        <div class="m-portlet add_form">
            <!--begin::Form-->
        @include('admin.notifications.include.form_')

        <!--end::Form-->
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')

    <script src="{{url('')}}/admin_assets/assets/general/js/notifications/notification.js"
            type="text/javascript"></script>
@endpush

