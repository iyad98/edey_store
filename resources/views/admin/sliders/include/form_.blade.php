<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <gallery-comp @get-advance-emit-file="getAdvanceEmitFile" :default_image="default_image"
                      :attr_name="attr_name" :selector_id_image="selector_id_image" obj="slider">
        </gallery-comp>

        <div class="form-group m-form__group row top_row">

            <div class="col-lg-4">
                <label>{{trans('admin.name_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="slider.name_ar"
                       v-validate="'required'"
                       :class="errors.has('name_ar') ? 'vue_border_error': ''"
                       name="name_ar"
                       placeholder="{{trans('admin.name_ar')}}">

                <span class="m-form__help"
                      :class="errors.has('name_ar') ? 'vue_error': ''"
                      v-text="errors.has('name_ar') ? errors.first('name_ar') : ''"></span>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.name_en')}}:</label>
                <input type="text" class="form-control m-input" v-model="slider.name_en"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('name_en') ? 'vue_border_error': ''"
                       name="name_en"
                       placeholder="{{trans('admin.name_en')}}">

                <span class="m-form__help"
                      :class="errors.has('name_en') ? 'vue_error': ''"
                      v-text="errors.has('name_en') ? errors.first('name_en') : ''"></span>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.slider_parent')}}:</label>
                <br>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_slider_form_div">
                    <select class="form-control m-select2 " id="m_select_slider_form" name="param"
                            data-select2-id="m_select_slider_form" tabindex="-1" aria-hidden="true">
                        <option value="-1">{{trans('admin.slider_parent')}}</option>
                        <option v-for="parent_slider in parent_sliders" :value="parent_slider.id"
                                v-text="parent_slider.name"></option>

                    </select>
                </div>

            </div>

        </div>
        <div class="form-group m-form__group row top_row">

            <div class="col-lg-4 show_select_pointer">
                <label>{{trans('admin.select_pointer')}}:</label>
                <select class="form-control select_pointer">
                    <option value="-1">{{trans('admin.not_found')}}</option>
                    <option value="1">{{trans('admin.category')}}</option>
                    <option value="2">{{trans('admin.product')}}</option>
                </select>

            </div>

            <div class="col-lg-4 show_select_category">
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
            <div class="col-lg-4 show_select_product">
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
                        @click="SelectImageFromGallery('image_ar' , 'image_ar')">
                    {{__('admin.image_ar')}}
                </button>
                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image_ar" selector_id_image="image_ar"
                                 :shock_event="shock_event" :default_image="default_images.image_ar" obj="slider">

                </show-image-comp>
            </div>
            <div class="col-lg-3">
                <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                        @click="SelectImageFromGallery('image_en' , 'image_en')">
                    {{__('admin.image_en')}}
                </button>
                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image_en" selector_id_image="image_en"
                                 :shock_event="shock_event" :default_image="default_images.image_en" obj="slider">

                </show-image-comp>
            </div>
            <div class="col-lg-3">
                <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                        @click="SelectImageFromGallery('image_website_ar' , 'image_website_ar')">
                    {{__('admin.image_website_ar')}}
                </button>
                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image_website_ar" selector_id_image="image_website_ar"
                                 :shock_event="shock_event" :default_image="default_images.image_website_ar" obj="slider">

                </show-image-comp>
            </div>
            <div class="col-lg-3">
                <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                        @click="SelectImageFromGallery('image_website_en' , 'image_website_en')">
                    {{__('admin.image_website_en')}}
                </button>
                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image_website_en" selector_id_image="image_website_en"
                                 :shock_event="shock_event" :default_image="default_images.image_website_en" obj="slider">

                </show-image-comp>
            </div>
        </div>

    </div>


    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row top_row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <button type="button" :disabled="loading" @click="validateForm" class="btn m-btn btn-primary"
                            v-text="add ? '{{trans('admin.add')}}' : '{{trans('admin.save')}}'"
                            :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                    </button>

                    <button type="reset" id="cancel" class="btn btn-secondary"> {{trans('admin.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>
