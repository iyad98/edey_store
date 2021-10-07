<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed ">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>


        <div class="form-group m-form__group row">
            <div class="col-lg-3">
                <label>{{trans('admin.name_en')}}:</label>
                <input type="text" class="form-control m-input" v-model="ads.name_en"
                       v-validate="'required'"
                       :class="errors.has('name_en') ? 'vue_border_error': ''"
                       name="name_en"
                       placeholder="{{trans('admin.name_en')}}">

                <span class="m-form__help"
                      :class="errors.has('name_en') ? 'vue_error': ''"
                      v-text="errors.has('name_en') ? errors.first('name_en') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.description_en')}}:</label>
                <textarea class="form-control m-input" v-model="ads.description_en"
                          v-validate="'required'"
                          :class="errors.has('description_ar') ? 'vue_border_error': ''"
                          name="description_en"
                          placeholder="{{trans('admin.description_en')}}">

                </textarea>

                <span class="m-form__help"
                      :class="errors.has('description_en') ? 'vue_error': ''"
                      v-text="errors.has('description_en') ? errors.first('description_en') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.phone')}}:</label>
                <input type="text" class="form-control m-input" v-model="ads.phone"
                       v-validate="'required'"
                       :class="errors.has('description_ar') ? 'vue_border_error': ''"
                       name="phone"
                       placeholder="{{trans('admin.phone')}}">

                <span class="m-form__help"
                      :class="errors.has('phone') ? 'vue_error': ''"
                      v-text="errors.has('phone') ? errors.first('phone') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.user_name')}}: <span
                            v-text="!add ? ads.user.f_name+' - '+ads.user.l_name : ''"></span></label>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_remote_user_name_div">
                    <select class="form-control m-select2" id="m_select_remote_user_name" name="param"
                            data-select2-id="m_select_remote_user_name">
                        <option data-select2-id="32"></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <div class="col-sm-3" data-select2-id="80" id="m_select_city_form_div_add">
                <label>{{trans('admin.city_name')}}</label>
                <select class="form-control m-select2 " id="m_select_city_form_add" name="param"
                        data-select2-id="m_select_city_form_add" tabindex="-1" aria-hidden="true">
                    <option value="-1">{{ trans('admin.all') }}</option>
                    @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name_en}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3" data-select2-id="80" id="m_select_nighboor_form_div_add">
                <label>{{trans('admin.neighborhood_name')}}</label>
                <select class="form-control m-select2 " id="m_select_nighboor_form_add" name="param"
                        data-select2-id="m_select_nighboor_form_add" tabindex="-1" aria-hidden="true">
                    <option value="-1">{{ trans('admin.all') }}</option>
                    <option v-for="neighborhood in add_data.neighborhoods"
                            :selected="ads.neighborhood_id == neighborhood.id" :value="neighborhood.id"
                            v-text="neighborhood.name"></option>
                </select>
            </div>

            <div class="col-sm-3" data-select2-id="80" id="m_select_category_form_div_add">
                <label>{{trans('admin.category_name')}}</label>
                <select class="form-control m-select2 " id="m_select_category_form_add" name="param"
                        data-select2-id="m_select_category_form_add" tabindex="-1" aria-hidden="true">
                    <option value="-1">{{ trans('admin.all') }}</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name_en}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3" data-select2-id="80" id="m_select_sub_category_form_div_add">
                <label>{{trans('admin.sub_category_name')}}</label>
                <select class="form-control m-select2 " id="m_select_sub_category_form_add" name="param"
                        data-select2-id="m_select_sub_category_form_add" tabindex="-1" aria-hidden="true">
                    <option value="-1">{{ trans('admin.all') }}</option>
                    <option v-for="sub_category in add_data.sub_categories"
                            :selected="ads.sub_category_id == sub_category.id" :value="sub_category.id"
                            v-text="sub_category.name"></option>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">

            <div v-show="!add" class="col-sm-3">
                <label class="col-form-label col-lg-12 col-sm-12">{{trans('admin.ads_images')}}</label>
            </div>
            <div v-show="!add" class="col-sm-4">
                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table m-table m-table--head-bg-brand">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('admin.image')}}</th>
                                <th>{{trans('admin.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(image , index) in ads.images">
                                <th scope="row" v-text="index+1"></th>
                                <td><img :src="image.image" width="50" height="50"></td>
                                <td>
                                    <a href="javascript:;" @click="delete_image(index)"
                                       class="delete_ads_image m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="Delete">
                                        <i class="la la-remove"></i>
                                    </a>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div v-show="!add" class="col-sm-5"></div>
            <div class="col-lg-12">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12">{{trans('admin.ads_images')}}</label>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="m-dropzone dropzone m-dropzone--primary dz-clickable"
                             action="{{url('api/upload_empty')}}" id="m-dropzone-one">
                            <div class="m-dropzone__msg dz-message needsclick">
                                <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                                <span class="m-dropzone__msg-desc">Upload up to 10 files</span>
                            </div>
                        </div>
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


    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
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
