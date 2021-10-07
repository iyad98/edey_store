<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row">

            <div class="col-lg-4">
                <label>{{trans('admin.name_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="bank.name_ar"
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
                <input type="text" class="form-control m-input" v-model="bank.name_en"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('name_en') ? 'vue_border_error': ''"
                       name="name_en"
                       placeholder="{{trans('admin.name_en')}}">

                <span class="m-form__help"
                      :class="errors.has('name_en') ? 'vue_error': ''"
                      v-text="errors.has('name_en') ? errors.first('name_en') : ''"></span>
            </div>

            <div class="col-lg-4">
                <label>{{trans('admin.account_number')}}:</label>
                <input type="text" class="form-control m-input" v-model="bank.account_number"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('account_number') ? 'vue_border_error': ''"
                       name="account_number"
                       placeholder="{{trans('admin.account_number')}}">

                <span class="m-form__help"
                      :class="errors.has('account_number') ? 'vue_error': ''"
                      v-text="errors.has('account_number') ? errors.first('account_number') : ''"></span>
            </div>

            <div class="col-lg-4">
                <label>{{trans('admin.iban')}}:</label>
                <input type="text" class="form-control m-input" v-model="bank.iban"
                       v-validate="'required'"
                       :class="errors.has('iban') ? 'vue_border_error': ''"
                       name="iban"
                       placeholder="{{trans('admin.iban')}}">

                <span class="m-form__help"
                      :class="errors.has('iban') ? 'vue_error': ''"
                      v-text="errors.has('iban') ? errors.first('iban') : ''"></span>
            </div>

            <div class="col-lg-5">
                <label>{{trans('admin.image')}}:</label>
                <div class="input-group m-input-group m-input-group--square">
                    <input type="file" @change="get_file($event , '#image')" class="form-control m-input"
                           placeholder="{{trans('admin.image')}}">
                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image" width="100" height="100"
                                             :src="bank.image == ''? '{{get_general_path_default_image('banks')}}' :bank.image">
                                    </span>
                    </div>
                </div>

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
