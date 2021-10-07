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

                <div class="row top_row mb-5">
                    <div class="col-lg-12">
                        <label>{{trans('admin.image_ads_ar')}}:</label>
                        <div class="input-group m-input-group m-input-group--square">
                            <input type="file" @change="get_file($event , '#image_ar' , 'image_ar')"
                                   class="form-control m-input"
                                   placeholder="{{trans('admin.image')}}">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image_ar" width="100" height="100"
                                             :src="widget.image_ar == ''? '{{get_general_path_default_image('settings')}}' :widget.image_ar">
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>{{trans('admin.image_ads_en')}}:</label>
                        <div class="input-group m-input-group m-input-group--square">
                            <input type="file" @change="get_file($event , '#image_en' , 'image_en')"
                                   class="form-control m-input"
                                   placeholder="{{trans('admin.image')}}">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image_en" width="100" height="100"
                                             :src="widget.image_en == ''? '{{get_general_path_default_image('settings')}}' :widget.image_en">
                                    </span>
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-12">
                        <label>{{trans('admin.image_ads_image_mobile')}}:</label>
                        <div class="input-group m-input-group m-input-group--square">
                            <input type="file" @change="get_file($event , '#image_mobile_ar' , 'image_mobile_ar')"
                                   class="form-control m-input"
                                   >
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image_mobile_ar" width="100" height="100"
                                             :src="widget.image_mobile_ar == ''? '{{get_general_path_default_image('settings')}}' :widget.image_mobile_ar">
                                    </span>
                            </div>
                        </div>


                    </div>


                    <div  class="col-lg-12">
                        <select class="form-control mt-3" id="widget_type" v-model="widget.widget_type">
                            <option value="">اختار نوع</option>
                            <option value="1">٦ شمال</option>
                            <option value="2">٦ يمين</option>
                            <option value="3">٣ شمال</option>
                            <option value="4">٣ يمين</option>
                        </select>
                    </div>


                    <div class="col-lg-2 mt-2">
                        <button type="button" @click="add_widget" :disabled="website_note_loading"
                                class="btn m-btn btn-primary" style="width: 100px;"
                                v-text="'{{trans('admin.save')}}'"
                                :class="website_note_loading ? 'm-loader m-loader--light m-loader--left' : ''">
                        </button>
                    </div>



                </div>



                </div>



                <hr>

            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->

@endsection






@push('js')



    <script>


        var widget = {!! $widget !!}


    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/jquery-ui/jquery-ui.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/tree.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/nested_sortable/jquery.nestable.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/website/website-nested_sortable.js"
            type="text/javascript"></script>


    <script src="{{url('/admin_assets/assets/general/js/widget/edit.js')}}"
            type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $('.dd').nestable({/* config options */});
        });
    </script>



@endpush

