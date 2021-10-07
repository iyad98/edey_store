@extends('admin.layout')


@push('css')

    <style>
        #m_select_country_form_div .select2-container {
            width: 100% !important;
        }

        #m_select_country_form_div2 .select2-container {
            width: 100% !important;
        }
    </style>
@endpush


@section('content')


    <div class="m-content" id="app">

        <gallery-form-comp :data="data" :shock_event="shock_event" :add="add" :default_image="default_image"
                           :types="types">
        </gallery-form-comp>

        <div class="m-portlet m-portlet--mobile show_data" style="padding: 35px">
            <div class="row top_row mb-3">
                <div class="col-sm-4">
                    <a href="javascript:;"
                       class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air add-button">
							<span>
								<i class="la la-user-plus"></i>
							<span>{{trans('admin.add_new')}}</span>
							</span>
                    </a>
                </div>
            </div>

            <div class="m-portlet__body">
                <show-gallery-comp @edit-gallery="editGallery" @delete-gallery="deleteGallery"
                                   :types="types">
                </show-gallery-comp>
            </div>
        </div>
    </div>

@endsection





@push('js')

    <script>
        var default_image = "{{getImage('galleries' ,'true')}}";
        var types = {!! $types !!};
    </script>

    <script src="{{url('')}}/admin_assets/assets/general/js/galleries/gallery.js"></script>
    <script src="{{url('')}}/admin_assets/assets/general/js/galleries/service.js"></script>


@endpush

