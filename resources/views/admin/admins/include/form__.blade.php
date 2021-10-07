<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <div class="alert alert-success success_msg hidden" style="margin: 10px;">
            @{{ msg.success }}
        </div>
        <div class="alert alert-danger error_msg hidden" style="margin: 10px;">
            @{{ msg.error }}
        </div>
        <div class="form-group m-form__group row top_row">
            <div class="col-lg-4">
                <label>{{trans('admin.name')}}:</label>
                <input type="text" class="form-control m-input" v-model="user.name"
                       v-validate="'required'"
                       :class="errors.has('name') ? 'vue_border_error': ''"
                       name="name"
                       placeholder="{{trans('admin.name')}}">

                <span class="m-form__help"
                      :class="errors.has('name') ? 'vue_error': ''"
                      v-text="errors.has('name') ? errors.first('name') : ''"></span>
            </div>
            <div class="col-lg-4">
                <label class="">{{trans('admin.username')}}:</label>
                <input type="text" class="form-control m-input" v-model="user.username"
                       v-validate="'required'"
                       :class="errors.has('username') ? 'vue_border_error': ''"
                       name="username"
                       placeholder="{{trans('admin.username')}}">

                <span class="m-form__help"
                      :class="errors.has('username') ? 'vue_error': ''"
                      v-text="errors.has('username') ? errors.first('username') : ''"></span>


            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.password')}}:</label>
                <input type="password" class="form-control m-input" v-model="user.password"
                       name="password"
                       placeholder="{{trans('admin.password')}}">


            </div>
            {{--
            <div class="col-lg-3">

                <label >{{trans('admin.role')}}</label>
                <div >
                    <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                        <select id="select_role" v-model="user.role"
                                class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                            <option value="1">{{trans('admin.admin_role')}}</option>
                            <option value="2">{{trans('admin.pharmacy_role')}}</option>
                        </select>

                    </div>
                </div>

            </div>
            --}}
        </div>
        <div class="form-group m-form__group row top_row">
            <div class="col-lg-4">
                <label class="">{{trans('admin.email')}}:</label>
                <input type="text" class="form-control m-input" v-model="user.email"
                       v-validate="'required'"
                       :class="errors.has('email') ? 'vue_border_error': ''"
                       name="email"
                       placeholder="{{trans('admin.email')}}">

                <span class="m-form__help"
                      :class="errors.has('email') ? 'vue_error': ''"
                      v-text="errors.has('email') ? errors.first('email') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label class="">{{trans('admin.phone')}}:</label>
                <input type="text" class="form-control m-input" v-model="user.phone"
                       v-validate="'required'"
                       :class="errors.has('phone') ? 'vue_border_error': ''"
                       name="phone"
                       placeholder="{{trans('admin.phone')}}">

                <span class="m-form__help"
                      :class="errors.has('phone') ? 'vue_error': ''"
                      v-text="errors.has('phone') ? errors.first('phone') : ''"></span>
            </div>
            <div class="col-lg-5">
                <label>{{trans('admin.image')}}:</label>
                <div class="input-group m-input-group m-input-group--square">
                    <input type="file" @change="get_file($event , '#image')" class="form-control m-input"
                           placeholder="{{trans('admin.image')}}">
                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image" width="100" height="100"
                                             :src="user.image == ''? '{{get_path_default_image()}}' :user.image">
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
