<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row top_row">

            <div class="col-lg-6">
                <label>{{trans('admin.name_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="shipping_company.name_ar"
                       v-validate="'required'"
                       :class="errors.has('name_ar') ? 'vue_border_error': ''"
                       name="name_ar"
                       placeholder="{{trans('admin.name_ar')}}">

                <span class="m-form__help"
                      :class="errors.has('name_ar') ? 'vue_error': ''"
                      v-text="errors.has('name_ar') ? errors.first('name_ar') : ''"></span>
            </div>
            <div class="col-lg-6">
                <label>{{trans('admin.name_en')}}:</label>
                <input type="text" class="form-control m-input" v-model="shipping_company.name_en"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('name_en') ? 'vue_border_error': ''"
                       name="name_en"
                       placeholder="{{trans('admin.name_en')}}">

                <span class="m-form__help"
                      :class="errors.has('name_en') ? 'vue_error': ''"
                      v-text="errors.has('name_en') ? errors.first('name_en') : ''"></span>
            </div>
            <div class="col-lg-6">

                <label>{{trans('admin.image_app')}}:</label>
                <div class="input-group m-input-group m-input-group--square">
                    <input type="file" @change="get_file($event , 'image')" class="form-control m-input"
                           placeholder="{{trans('admin.image')}}">
                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image" width="100" height="100"
                                             :src="shipping_company.image == '' ? '{{get_general_path_default_image('shipping_companies')}}' : shipping_company.image">
                                    </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">

                <label>{{trans('admin.image_web')}} :</label>
                <div class="input-group m-input-group m-input-group--square">
                    <input type="file" @change="get_file($event , 'image_web')" class="form-control m-input"
                           placeholder="{{trans('admin.image_web')}}">
                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image_web" width="100" height="100"
                                             :src="shipping_company.image_web == '' ? '{{get_general_path_default_image('shipping_companies')}}' : shipping_company.image_web">
                                    </span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <label>{{trans('admin.phone')}}:</label>
                <input type="text" class="form-control m-input" v-model="shipping_company.phone"
                       v-validate="'required'"
                       :class="errors.has('phone') ? 'vue_border_error': ''"
                       name="phone"
                       placeholder="{{trans('admin.phone')}}">

                <span class="m-form__help"
                      :class="errors.has('phone') ? 'vue_error': ''"
                      v-text="errors.has('phone') ? errors.first('phone') : ''"></span>
            </div>
            <div class="col-lg-8">
                <label>{{trans('admin.tracking_url')}}:</label>
                <input type="text" class="form-control m-input" v-model="shipping_company.tracking_url"
                       v-validate="'required'"
                       :class="errors.has('tracking_url') ? 'vue_border_error': ''"
                       name="tracking_url"
                       placeholder="{{trans('admin.tracking_url')}}">

                <span class="m-form__help"
                      :class="errors.has('tracking_url') ? 'vue_error': ''"
                      v-text="errors.has('tracking_url') ? errors.first('tracking_url') : ''"></span>
            </div>

            <div class="col-lg-4" >
                <label class="col-form-label col-sm-3">{{trans('admin.country')}}</label>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_city_form_div">
                    <select dir="rtl" class="form-control m-select2" multiple id="m_select_country_form" name="param"
                            data-select2-id="m_select_city_form_div" tabindex="-1" aria-hidden="true"
                            autocomplete="false">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-4" >
                <label class="col-form-label col-sm-5">{{trans('admin.accept_user_shipping_address')}}</label>
                <div class="col-lg-12 col-md-12 col-sm-12" >
                    <select dir="rtl" class="form-control m-select"  name="accept_user_shipping_address"
                            v-model="shipping_company.accept_user_shipping_address"
                            autocomplete="false">

                        <option value="0">لا</option>
                        <option value="1">نعم</option>

                    </select>
                </div>
            </div>

            <div class="col-lg-4">
                <label>{{trans('admin.note')}}:</label>
                <input type="text" class="form-control m-input" v-model="shipping_company.note"
                       v-validate="'required'"
                       :class="errors.has('note') ? 'vue_border_error': ''"
                       name="phone"
                       placeholder="{{trans('admin.note')}}">

                <span class="m-form__help"
                      :class="errors.has('note') ? 'vue_error': ''"
                      v-text="errors.has('note') ? errors.first('note') : ''"></span>
            </div>
        </div>


        <div class="m-form__group form-group">
            <label for="">{{trans('admin.bill_address')}}</label>
            <div class="m-checkbox-inline">
                <label class="m-checkbox">
                    <input type="checkbox" id="billing_national_address"
                           value="1"> {{trans('admin.billing_national_address')}}
                    <span></span>
                </label>
                <label class="m-checkbox">
                    <input type="checkbox" id="billing_building_number"
                           value="1"> {{trans('admin.billing_building_number')}}
                    <span></span>
                </label>
                <label class="m-checkbox">
                    <input type="checkbox" id="billing_postalcode_number"
                           value="1">{{trans('admin.billing_postalcode_number')}}
                    <span></span>
                </label>
                <label class="m-checkbox">
                    <input type="checkbox" id="billing_unit_number" value="1">{{trans('admin.billing_unit_number')}}
                    <span></span>
                </label>
                <label class="m-checkbox">
                    <input type="checkbox" id="billing_extra_number" value="1">{{trans('admin.billing_extra_number')}}
                    <span></span>
                </label>
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
