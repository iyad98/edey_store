@extends('admin.layout')


@push('css')

    <style>
        button:hover {
            cursor: pointer;
        }
    </style>
@endpush




@section('content')
    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->
    <div class="m-content" id="app">

        @include('admin.admins.include.control_order_status')
        <div class="m-portlet m-portlet--mobile show_users">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('admin.permissions')." : ".$admin->admin_name}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">

                </div>
            </div>
            <div class="m-portlet__body" id="permission">

                <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>


                @if($admin->super_admin != 1)
                    <div class="card-body">

                        <button type="button"
                                class="list-group-item list-group-item-action btn-ch-all">
                            <div class="custom-control custom-checkbox">
                                <input
                                        type="checkbox" class="custom-control-input"
                                        id="ch_all">
                                <label class="custom-control-label" for="ch_all">تحديد
                                    الكل</label>

                            </div>
                        </button>
                        <div class="row">
                            <input type="hidden" value="{{$admin->admin_id}}" id="admin_id">
                            @foreach($permissions as $key=>$permission)
                                <div class="col-sm-3" style="margin-top: 20px;">
                                    <div class="list-group">
                                        <button type="button"
                                                class="list-group-item list-group-item-action active">
                                            <h5>{{$key}}
                                                @if($key == "الطلبات")
                                                    <a href="javascript:;" @click="show_control_order_status()" class="btn btn-sm btn-success" style="color: white;float: left">التحكم بالحالات</a>
                                                @endif
                                            </h5>
                                        </button>
                                        @foreach($permission as $r)
                                            <button type="button"
                                                    class="list-group-item list-group-item-action btn-ch">
                                                <div class="custom-control custom-checkbox">
                                                    <input name="roles[]"
                                                           {{in_array($r->id , $admin_permissions) ?"checked" : ""}} value="{{$r->id}}"
                                                           value="{{$r->id}}"
                                                           type="checkbox"
                                                           class="custom-control-input ch_"
                                                           id="ch{{$r->id}}">
                                                    <label class="custom-control-label"
                                                           for="ch{{$r->id}}">{{$r->name}}</label>


                                                </div>
                                            </button>
                                        @endforeach

                                    </div>
                                </div>
                            @endforeach


                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8">
                                <button style="width: 205px;" type="button" :disabled="loading"
                                        @click="update_permissions" class="btn m-btn btn-primary"
                                        v-text="'{{trans('admin.save')}}'"
                                        :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                                </button>

                            </div>
                            <div class="col-lg-4"></div>
                        </div>

                    </div>
                @endif
                <hr>

            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')

    <script>
        var order_statuses = {!! json_encode(trans_order_status()) !!};
        var admin_order_statuses = {!! $admin_order_statuses !!};
    </script>
    <script src="{{url('')}}/admin_assets/assets/general/js/admin/permission.js"
            type="text/javascript"></script>
@endpush

