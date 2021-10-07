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
        .fa.fa-window-close {
            display: none;
        }
        video{
            display: none;
        }
    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->
    <!-- END: Subheader -->
    <div class="m-content" id="app">

        <div class="m-portlet add_form">
            <!--begin::Form-->
        @include('admin.advertisements.include.form_')

        <!--end::Form-->
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')

    <script>
        var pop_up = {!! $pop_up !!};
        var splash = {!! $splash !!};

    </script>
    <script src="{{url('')}}/admin_assets/assets/general/js/advertisements/advertisement.js"
            type="text/javascript"></script>
@endpush

