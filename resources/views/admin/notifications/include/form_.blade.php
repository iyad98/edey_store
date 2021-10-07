<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <div style="padding: 10px;">
            <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        </div>

        {{--        <div class="m-portlet__head">--}}
        {{--            <div class="m-portlet__head-caption">--}}
        {{--                <div class="m-portlet__head-title">--}}
        {{--												<span class="m-portlet__head-icon m--hide">--}}
        {{--													<i class="la la-gear"></i>--}}
        {{--												</span>--}}
        {{--                    <h3 class="m-portlet__head-text">{{trans('admin.notifications')}}</h3>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <div class="form-group m-form__group row top_row">
            <div class="col-sm-4">
                <label>{{trans('admin.title')}}</label>
                <input type="text" v-model="notification.title"
                       name="title"
                       class="form-control m-input"
                       placeholder="{{trans('admin.title')}}">

            </div>
            <div class="col-sm-4">
                <label>{{trans('admin.message')}}</label>
                <textarea class="form-control" v-model="notification.message"
                          placeholder="{{trans('admin.message')}}"></textarea>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.image')}}:</label>
                <div class="input-group m-input-group m-input-group--square">
                    <input type="file" @change="get_file($event , '#image')" class="form-control m-input"
                           placeholder="{{trans('admin.image')}}">
                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="image" width="100" height="100"
                                             :src="notification.image == ''? '{{get_general_path_default_image('notifications')}}' :notification.image">
                                    </span>
                    </div>
                </div>

            </div>

            <div class="col-lg-4 show_select_pointer">
                <label>{{trans('admin.select_type')}}:</label>
                <select class="form-control select_pointer">
                    <option value="1">{{trans('admin.external_url')}}</option>
                    <option value="2">{{trans('admin.category')}}</option>
                    <option value="3">{{trans('admin.product')}}</option>
                    <option value="4">{{trans('admin.only_text')}}</option>
                </select>

            </div>
            <div class="col-lg-5 show_select_category hidden">
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
            <div class="col-lg-5 show_select_product hidden">
                <label>{{trans('admin.products')}}:</label>
                <div id="m_select_remote_marketing_products_div">
                    <select class="form-control m-select2" id="m_select_remote_marketing_products"
                            name="param"
                            data-select2-id="m_select_remote_marketing_products">

                    </select>
                </div>


            </div>
            <div class="col-lg-5 external_url">
                <label>{{trans('admin.external_url')}}:</label>
                <input type="text" class="form-control" v-model="notification.external_url"
                       placeholder="{{trans('admin.external_url')}}"
                       value="">
            </div>


        </div>

        <div class="form-group m-form__group row">
            <div class="col-lg-3">
                <label>{{trans('admin.platform')}}:</label>
                <select id="m_select_platform" class="form-control" v-model="notification.platform">
                    <option value="all">{{trans('admin.all')}}</option>
                    <option value="android">android</option>
                    <option value="ios">ios</option>
                </select>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.countries')}}:</label>
                <br>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_remote_countries_div">
                    <select dir="rtl" class="form-control m-select2" multiple id="m_select_remote_countries" name="param"
                            data-select2-id="m_select_remote_countries" tabindex="-1" aria-hidden="true">
                        <option value=""></option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-5">
                <label>{{trans('admin.users')}}:</label>
                <div id="m_select_remote_users_div">
                    <select dir="rtl" class="form-control m-select2" multiple id="m_select_remote_users"
                            name="param"
                            data-select2-id="m_select_remote_users">

                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row top_row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <button type="button" :disabled="loading" @click="send_notifications" class="btn m-btn btn-primary"
                            v-text="'{{trans('admin.send_notification')}}'"
                            :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                    </button>

                </div>
            </div>
        </div>
    </div>
</form>
