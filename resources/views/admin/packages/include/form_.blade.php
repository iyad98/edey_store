<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row top_row">

            <div class="col-lg-3">
                <label>{{trans('admin.name_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="package.name_ar"
                       v-validate="'required'"
                       :class="errors.has('name_ar') ? 'vue_border_error': ''"
                       name="name_ar"
                       placeholder="{{trans('admin.name_ar')}}">

                <span class="m-form__help"
                      :class="errors.has('name_ar') ? 'vue_error': ''"
                      v-text="errors.has('name_ar') ? errors.first('name_ar') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.name_en')}}:</label>
                <input type="text" class="form-control m-input" v-model="package.name_en"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('name_en') ? 'vue_border_error': ''"
                       name="name_en"
                       placeholder="{{trans('admin.name_en')}}">

                <span class="m-form__help"
                      :class="errors.has('name_en') ? 'vue_error': ''"
                      v-text="errors.has('name_en') ? errors.first('name_en') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.price_from')}}:</label>
                <input type="number" class="form-control m-input" v-model="package.price_from"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('account_number') ? 'vue_border_error': ''"
                       name="price_from"
                       placeholder="{{trans('admin.price_from')}}">

                <span class="m-form__help"
                      :class="errors.has('price_from') ? 'vue_error': ''"
                      v-text="errors.has('price_from') ? errors.first('price_from') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.price_to')}}:</label>
                <input type="number" class="form-control m-input" v-model="package.price_to"
                       v-validate="'required'"
                       :class="errors.has('price_to') ? 'vue_border_error': ''"
                       name="price_to"
                       placeholder="{{trans('admin.price_to')}}">

                <span class="m-form__help"
                      :class="errors.has('price_to') ? 'vue_error': ''"
                      v-text="errors.has('price_to') ? errors.first('price_to') : ''"></span>
            </div>


            <div class="col-lg-3">
                <label>{{trans('admin.discount_rate')}}:</label>
                <input type="number" class="form-control m-input" v-model="package.discount_rate"
                       v-validate="'required'"
                       :class="errors.has('discount_rate') ? 'vue_border_error': ''"
                       name="rate"
                       placeholder="{{trans('admin.discount_rate')}}">

                <span class="m-form__help"
                      :class="errors.has('rate') ? 'vue_error': ''"
                      v-text="errors.has('rate') ? errors.first('rate') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.replace_hours')}}:</label>
                <input type="number" class="form-control m-input" v-model="package.replace_hours"
                       v-validate="'required'"
                       :class="errors.has('replace_hours') ? 'vue_border_error': ''"
                       name="replace_hours"
                       placeholder="{{trans('admin.replace_hours')}}">

                <span class="m-form__help"
                      :class="errors.has('replace_hours') ? 'vue_error': ''"
                      v-text="errors.has('replace_hours') ? errors.first('replace_hours') : ''"></span>
            </div>
            <div class="col-lg-3">
                <div class="m-form__group form-group">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            <input type="checkbox" id="free_shipping"> {{trans('admin.free_shipping')}}
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.image')}}:</label>
                <div class="input-group m-input-group m-input-group--square">
                    <input type="file" @change="get_file($event , '#image')" class="form-control m-input"
                           placeholder="{{trans('admin.image')}}">
                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image" width="100" height="100"
                                             :src="package.image == ''? '{{get_general_path_default_image('packages')}}' :package.image">
                                    </span>
                    </div>
                </div>

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
