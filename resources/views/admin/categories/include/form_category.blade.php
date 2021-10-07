<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <gallery-comp @get-advance-emit-file="getAdvanceEmitFile" :default_image="default_image" :attr_name="attr_name"
                      :selector_id_image="selector_id_image" obj="category"></gallery-comp>

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row top_row">
            <div class="col-lg-4">
                <label>{{trans('admin.name_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="category.name_ar"
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
                <input type="text" class="form-control m-input" v-model="category.name_en"
                       {{--  v-validate="'required'" --}}
                       :class="errors.has('name_en') ? 'vue_border_error': ''"
                       name="name_en"
                       placeholder="{{trans('admin.name_en')}}">

                <span class="m-form__help"
                      :class="errors.has('name_en') ? 'vue_error': ''"
                      v-text="errors.has('name_en') ? errors.first('name_en') : ''"></span>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.category_parent')}}:</label>
                <br>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_category_form_div">
                    <select class="form-control m-select2 " id="m_select_category_form" name="param"
                            data-select2-id="m_select_category_form" tabindex="-1" aria-hidden="true">
                        <option  v-for="category_parent in category" :value="category.id">@{{ category.name }}</option>


                    </select>
                </div>

            </div>

        </div>
        <div class="form-group m-form__group row top_row">

            <div class="col-lg-3">
                <label>{{trans('admin.description_ar')}}:</label>
                <textarea class="form-control m-input" v-model="category.description_ar"

                          :class="errors.has('description_ar') ? 'vue_border_error': ''"
                          name="description_ar"
                          placeholder="{{trans('admin.description_ar')}}"
                >
                </textarea>

                <span class="m-form__help"
                      :class="errors.has('description_ar') ? 'vue_error': ''"
                      v-text="errors.has('description_ar') ? errors.first('description_ar') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.description_en')}}:</label>
                <textarea class="form-control m-input" v-model="category.description_en"

                          :class="errors.has('description_en') ? 'vue_border_error': ''"
                          name="description_en"
                          placeholder="{{trans('admin.description_en')}}"
                >

                </textarea>

                <span class="m-form__help"
                      :class="errors.has('description_en') ? 'vue_error': ''"
                      v-text="errors.has('description_en') ? errors.first('description_en') : ''"></span>
            </div>
            <div class="col-lg-3">
                <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                        @click="SelectImageFromGallery('image' , 'image1')">
                    {{__('admin.select_image')}}
                </button>
                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image" selector_id_image="image1"
                                 :shock_event="shock_event" :default_image="default_image" obj="category">

                </show-image-comp>
            </div>
            <div class="col-lg-3">
                <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                        @click="SelectImageFromGallery('guide_image' , 'guide_image')">
                    {{__('admin.select_banner_image')}}
                </button>
                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="guide_image" selector_id_image="guide_image"
                                 :shock_event="shock_event" :default_image="default_guide_image" obj="category">

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
