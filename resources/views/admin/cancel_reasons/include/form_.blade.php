<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">


        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row top_row">

            <div class="col-lg-6">
                <label>{{trans('admin.title_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="cancel_reasons.title_ar"
                       v-validate="'required'"
                       :class="errors.has('title_ar') ? 'vue_border_error': ''"
                       name="title_ar"
                       placeholder="{{trans('admin.title_ar')}}">

                <span class="m-form__help"
                      :class="errors.has('title_ar') ? 'vue_error': ''"
                      v-text="errors.has('title_ar') ? errors.first('title_ar') : ''"></span>
            </div>
            <div class="col-lg-6">
                <label>{{trans('admin.title_en')}}:</label>
                <input type="text" class="form-control m-input" v-model="cancel_reasons.title_en"
                       {{--  v-validate="'required'" --}}
                       :class="errors.has('title_en') ? 'vue_border_error': ''"
                       name="title_en"
                       placeholder="{{trans('admin.title_en')}}">

                <span class="m-form__help"
                      :class="errors.has('title_en') ? 'vue_error': ''"
                      v-text="errors.has('title_en') ? errors.first('title_en') : ''"></span>
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
