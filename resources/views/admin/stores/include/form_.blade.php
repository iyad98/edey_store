<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row top_row">

            <div class="col-lg-4">
                <label>{{trans('admin.name_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="store.name_ar"
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
                <input type="text" class="form-control m-input" v-model="store.name_en"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('name_en') ? 'vue_border_error': ''"
                       name="name_en"
                       placeholder="{{trans('admin.name_en')}}">

                <span class="m-form__help"
                      :class="errors.has('name_en') ? 'vue_error': ''"
                      v-text="errors.has('name_en') ? errors.first('name_en') : ''"></span>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.phone')}}:</label>
                <input type="text" class="form-control m-input" v-model="store.phone"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('phone') ? 'vue_border_error': ''"
                       name="phone"
                       placeholder="{{trans('admin.phone')}}">

                <span class="m-form__help"
                      :class="errors.has('phone') ? 'vue_error': ''"
                      v-text="errors.has('phone') ? errors.first('phone') : ''"></span>
            </div>

            <div class="col-lg-4">
                <label>{{trans('admin.address_en')}}:</label>
                <input type="text" class="form-control m-input" v-model="store.address_en"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('address_en') ? 'vue_border_error': ''"
                       name="address_en"
                       placeholder="{{trans('admin.address_en')}}">

                <span class="m-form__help"
                      :class="errors.has('address_en') ? 'vue_error': ''"
                      v-text="errors.has('address_en') ? errors.first('address_en') : ''"></span>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.address_ar')}}:</label>
                <input type="text" class="form-control m-input" v-model="store.address_ar"
                       {{-- v-validate="'required'" --}}
                       :class="errors.has('address_ar') ? 'vue_border_error': ''"
                       name="address_ar"
                       placeholder="{{trans('admin.address_ar')}}">

                <span class="m-form__help"
                      :class="errors.has('address_ar') ? 'vue_error': ''"
                      v-text="errors.has('address_ar') ? errors.first('address_ar') : ''"></span>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.city')}}:</label>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_city_form_div">
                    <select class="form-control m-select2"  id="m_select_city_form" name="param"
                            data-select2-id="m_select_city_form_div" tabindex="-1" aria-hidden="true"
                            autocomplete="false">
                        <option value="-1">{{trans('admin.select_city')}}</option>
                        @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{--<div class="col-lg-4">--}}
                {{--<label>{{trans('admin.image')}}:</label>--}}
                {{--<div class="input-group m-input-group m-input-group--square">--}}
                    {{--<input type="file" @change="get_file($event , '#image')" class="form-control m-input"--}}
                           {{--placeholder="{{trans('admin.image')}}">--}}
                    {{--<div class="input-group-prepend">--}}
                                    {{--<span class="input-group-text">--}}
                                        {{--<img id="image" width="100" height="100"--}}
                                             {{--:src="store.image == ''? '{{get_general_path_default_image('stores')}}' :store.image">--}}
                                    {{--</span>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}


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
