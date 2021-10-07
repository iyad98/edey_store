@extends('admin.layout')


@push('css')

@endpush



@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">{{trans('admin.profile')}}</h3>
            </div>

        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content" id="app">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary"
                                role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab"
                                       href="#m_user_profile_tab_1" role="tab">
                                        <i class="flaticon-share m--hide"></i>
                                        {{trans('admin.profile')}}
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2"
                                       role="tab">
                                        {{trans('admin.change_password')}}
                                    </a>
                                </li>

                            </ul>
                        </div>
                        
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_user_profile_tab_1">
                            <form class="m-form m-form--fit m-form--label-align-right">
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group m--margin-top-10 m--hide">
                                        <div class="alert m-alert m-alert--default" role="alert">
                                            The example form below demonstrates common HTML form elements that receive
                                            updated styles from Bootstrap with additional classes.
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-10 ml-auto">
                                            <h3 class="m-form__section">{{trans('admin.data')}}</h3>
                                        </div>

                                    </div>
                                    <div class="alert alert-success success_msg hidden" style="margin: 10px;">
                                        @{{ msg.success }}
                                    </div>
                                    <div class="alert alert-danger error_msg hidden" style="margin: 10px;">
                                        @{{ msg.error }}
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-2 col-form-label">{{trans('admin.name')}}</label>
                                        <div class="col-7">
                                            <input class="form-control m-input" v-model="user.name" type="text"
                                                   value="{{Auth::guard('admin')->user()->admin_name}}">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-2 col-form-label">{{trans('admin.username')}}</label>
                                        <div class="col-7">
                                            <input class="form-control m-input" v-model="user.username" type="text"
                                                   value="{{Auth::guard('admin')->user()->admin_username}}">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-2 col-form-label">{{trans('admin.email')}}</label>
                                        <div class="col-7">
                                            <input class="form-control m-input" v-model="user.email" type="text"
                                                   value="{{Auth::guard('admin')->user()->admin_email}}">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-2 col-form-label">{{trans('admin.phone')}}</label>
                                        <div class="col-7">
                                            <input class="form-control m-input" v-model="user.phone" type="text"
                                                   value="{{Auth::guard('admin')->user()->admin_phone}}">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-2 col-form-label">{{trans('admin.image')}}</label>
                                        <div class="col-7">
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
                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions">
                                        <div class="row">
                                            <div class="col-2">
                                            </div>
                                            <div class="col-7">
                                                <button :disabled="loading" @click="update_user"
                                                        :class="loading ? 'm-loader m-loader--light m-loader--left' : ''"
                                                        class="btn btn-accent m-btn m-btn--air m-btn--custom">{{trans('admin.save')}}</button>&nbsp;&nbsp;
                                                <button class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{trans('admin.cancel')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane " id="m_user_profile_tab_2">
                            <form class="m-form m-form--fit m-form--label-align-right">
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group m--margin-top-10 m--hide">
                                        <div class="alert m-alert m-alert--default" role="alert">
                                            The example form below demonstrates common HTML form elements that receive
                                            updated styles from Bootstrap with additional classes.
                                        </div>
                                    </div>
                                    <div class="alert alert-success success_msg2 hidden" style="margin: 10px;">
                                        @{{ msg.success }}
                                    </div>
                                    <div class="alert alert-danger error_msg2 hidden" style="margin: 10px;">
                                        @{{ msg.error }}
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-10 ml-auto">
                                            <h3 class="m-form__section">{{trans('admin.change_password')}}</h3>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-2 col-form-label">{{trans('admin.new_password')}}</label>
                                        <div class="col-7">
                                            <input class="form-control m-input"  v-model="user_password.new_password" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input"
                                               class="col-2 col-form-label">{{trans('admin.re_new_password')}}</label>
                                        <div class="col-7">
                                            <input class="form-control m-input" v-model="user_password.re_new_password" type="password">
                                        </div>
                                    </div>


                                </div>
                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions">
                                        <div class="row">
                                            <div class="col-2">
                                            </div>
                                            <div class="col-7">
                                                <button type="button" @click="change_password"
                                                        :disabled="loading"
                                                        :class="loading ? 'm-loader m-loader--light m-loader--left' : ''"
                                                        class="btn btn-accent m-btn m-btn--air m-btn--custom">{{trans('admin.save')}}</button>&nbsp;&nbsp;
                                                <button type="reset"
                                                        class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{trans('admin.cancel')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection





@push('js')
    <script>
        var current_admin = {!! Auth::guard('admin')->user() !!};
    </script>
    <script src="{{url('')}}/admin_assets/assets/general/js/admin/profile.js"
            type="text/javascript"></script>
@endpush

