<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <div style="padding: 10px;">
            <gallery-comp @get-advance-emit-file="getAdvanceEmitFile" :default_image="pop_up.default_image"
                          :attr_name="attr_name" :selector_id_image="selector_id_image" :obj="obj">
            </gallery-comp>
            <success-error-msg-component  :success="msg.success" :error="msg.error"></success-error-msg-component>

        </div>

        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                    <h3 class="m-portlet__head-text">{{trans('admin.popup_ads')}}</h3>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-4 show_select_pointer">
                <label>{{trans('admin.select_pointer')}}:</label>
                <select class="form-control select_pointer">
                    <option value="-1">{{trans('admin.not_found')}}</option>
                    <option value="1">{{trans('admin.category')}}</option>
                    <option value="2">{{trans('admin.product')}}</option>
                </select>

            </div>
            <div class="col-lg-4 show_select_category hidden">
                <label>{{trans('admin.categories')}}:</label>
                <br>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_category_form_div">
                    <select class="form-control m-select2 " id="m_select_category_form" name="param"
                            data-select2-id="m_select_category_form" tabindex="-1" aria-hidden="true">
                        <option value=""></option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-lg-4 show_select_product hidden">
                <label>{{trans('admin.products')}}:</label>
                <div id="m_select_remote_marketing_products_div">
                    <select class="form-control m-select2" id="m_select_remote_marketing_products"
                            name="param"
                            data-select2-id="m_select_remote_marketing_products">

                    </select>
                </div>


            </div>

            <div class="col-lg-3">
                <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                        @click="SelectImageFromGalleryV2('image' , 'image' ,'pop_up')">
                    {{__('admin.select_image')}}
                </button>
                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image" selector_id_image="image"
                                 :shock_event="shock_event" :default_image="pop_up.default_image" obj="pop_up">

                </show-image-comp>
            </div>
            <div class="col-lg-4" style="margin-top: -5%">

                <div class="row">

                    <div class="col-sm-5">
                        تفعيل / الغاء تفعيل
                    </div>
                    <div class="col-sm-6">
                        <span class="get_status change_status m-switch m-switch--outline m-switch--icon m-switch--info">

                    <label>
                         <input type="checkbox" name="" id="pop_up_status">
	                     <span></span>
                    </label>
                </span>
                    </div>
                </div>


                {{--<select class="form-control" v-model="pop_up.status">--}}
                    {{--<option value="1">{{trans('admin.active')}}</option>--}}
                    {{--<option value="0">{{trans('admin.not_active')}}</option>--}}
                {{--</select>--}}

            </div>
        </div>


        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                    <h3 class="m-portlet__head-text">{{trans('admin.splash_ads')}}</h3>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-lg-4 show_select_pointer">
                <label>{{trans('admin.select_pointer')}}:</label>
                <select class="form-control select_pointer_2">
                    <option value="-1">{{trans('admin.not_found')}}</option>
                    <option value="1">{{trans('admin.category')}}</option>
                    <option value="2">{{trans('admin.product')}}</option>
                </select>

            </div>
            <div class="col-lg-4 show_select_category_2 hidden">
                <label>{{trans('admin.categories')}}:</label>
                <br>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_category_form_div_2">
                    <select class="form-control m-select2 " id="m_select_category_form_2" name="param"
                            data-select2-id="m_select_category_form_2" tabindex="-1" aria-hidden="true">
                        <option value=""></option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col-lg-4 show_select_product_2 hidden">
                <label>{{trans('admin.products')}}:</label>
                <div id="m_select_remote_marketing_products_div_2">
                    <select class="form-control m-select2" id="m_select_remote_marketing_products_2"
                            name="param"
                            data-select2-id="m_select_remote_marketing_products_2">

                    </select>
                </div>


            </div>
            <div class="col-lg-3">
                <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                        @click="SelectImageFromGalleryV2('image' , 'image2' , 'splash')">
                    {{__('admin.select_image')}}
                </button>
                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image" selector_id_image="image2"
                                 :shock_event="shock_event" :default_image="splash.default_image" obj="splash">

                </show-image-comp>
            </div>
            <div class="col-lg-4"  style="margin-top: -5%">

                <div class="row">

                    <div class="col-sm-5">
                        تفعيل / الغاء تفعيل
                    </div>
                    <div class="col-sm-6">
                          <span class="get_status change_status m-switch m-switch--outline m-switch--icon m-switch--info">
                    <label>

                         <input type="checkbox" name="" id="splash_status">
	                     <span></span>
                    </label>
                </span>
                    </div>
                </div>


                {{--<select class="form-control" v-model="splash.status">--}}
                    {{--<option value="1">{{trans('admin.active')}}</option>--}}
                    {{--<option value="0">{{trans('admin.not_active')}}</option>--}}
                {{--</select>--}}
            </div>
        </div>

    </div>


    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <button type="button" :disabled="loading" @click="update_advertisement" class="btn m-btn btn-primary"
                            v-text="add ? '{{trans('admin.add')}}' : '{{trans('admin.save')}}'"
                            :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                    </button>

                    <button type="reset" id="cancel" class="btn btn-secondary"> {{trans('admin.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>
