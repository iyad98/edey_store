<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row top_row">

            <div class="col-lg-4">
                <label>{{trans('admin.name_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="country.name_ar"
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
                <input type="text" class="form-control m-input" v-model="country.name_en"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('name_en') ? 'vue_border_error': ''"
                       name="name_en"
                       placeholder="{{trans('admin.name_en')}}">

                <span class="m-form__help"
                      :class="errors.has('name_en') ? 'vue_error': ''"
                      v-text="errors.has('name_en') ? errors.first('name_en') : ''"></span>
            </div>

            <div class="col-lg-4 " >
                <label >{{trans('admin.payment_method')}}</label>
                <div data-select2-id="80" id="m_select_payment_method_form_div">
                    <select class="form-control m-select2" multiple id="m_select_payment_method_form" name="param"
                            data-select2-id="m_select_payment_method_form_div" tabindex="-1" aria-hidden="true"
                            autocomplete="false">
                        @foreach($payment_methods as $payment_method)
                            <option value="{{$payment_method->id}}">{{$payment_method->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.image')}}:</label>
                <div class="input-group m-input-group m-input-group--square">
                    <input type="file" @change="get_file($event , '#image')" class="form-control m-input"
                           placeholder="{{trans('admin.image')}}">
                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image" width="100" height="100"
                                             :src="country.flag == ''? '{{get_general_path_default_image('countries')}}' :country.flag">
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
