@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <style>
        #m_select_city_form_div .select2-container {
            width: 100% !important;
        }

        #m_select_type_form_div2 .select2-container {
            width: 100% !important;
        }
        .comment_status_item {
            margin-right: 10px;
            margin-left: 10px;
        }

        #comment-table th{
            text-align: center;
        }

        .comment_status_active {
            color: black;
            font-weight: 600;
        }
    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->
    <!-- END: Subheader -->
    <div class="m-content" id="app">

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                        <h3 class="m-portlet__head-text"
                            v-text="add ? '{{trans('admin.new_comment')}}' : '{{trans('admin.edit_comment')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->

        {{-- @include('admin.comments.include.form_') --}}

        <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">

                        <div class="order-status" style="background-color: white;">
                            <a @click="get_comment_status = 1" href="javascript:;" :class="get_comment_status == 1 ? 'comment_status_active' : ''" class="comment_status_item" v-text="'{{trans('admin.all')}} ( ' + comment_status.all +' ) '"></a><span
                                    class="span-slash">|</span>
                            <a @click="get_comment_status = 2" href="javascript:;" :class="get_comment_status == 2 ? 'comment_status_active' : ''" class="comment_status_item" v-text="'{{trans('admin.pending_comment')}} ( ' + comment_status.pending +' ) '"></a><span
                                    class="span-slash">|</span>
                            <a @click="get_comment_status = 3" href="javascript:;" :class="get_comment_status == 3 ? 'comment_status_active' : ''" class="comment_status_item" v-text="'{{trans('admin.approved_comment')}} ( ' + comment_status.approve +' ) '"></a><span
                                    class="span-slash">|</span>
                            <a @click="get_comment_status = 4" href="javascript:;" :class="get_comment_status == 4 ? 'comment_status_active' : ''" class="comment_status_item" v-text="'{{trans('admin.disapproved_comment')}} ( ' + comment_status.disapprove +' ) '"></a><span
                                    class="span-slash">|</span>
                            <a @click="get_comment_status = 5" href="javascript:;" :class="get_comment_status == 5 ? 'comment_status_active' : ''" class="comment_status_item" v-text="'{{trans('admin.trash')}} ( ' + comment_status.trash +' ) '"></a><span
                                    class="span-slash">|</span>

                        </div>

                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">

                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <div class="row top_row">
                                        <div class="col-sm-4 col-lg-3 custom_col custom_search">
                                            <div class="form-group m-form__group row top_row">
                                                <div class="col-sm-12 col_sm_custom">
                                                    <div class="dropdown bootstrap-select form-control m-bootstrap-select m_ dropup">
                                                        <input type="text" class="form-control m-input"
                                                               placeholder="ابحث" id="searchValue">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                </div>

                <!--begin: Datatable -->
                <table class="table table-striped table-bordered table-hover table-checkable" id="comment-table">
                    <thead>
                    <tr>
                        <th class="hidden">#</th>
                        <th>{{trans('admin.user')}}</th>
                        <th class="hidden">{{trans('admin.user')}}</th>
                        <th class="hidden">{{trans('admin.user')}}</th>
                        <th class="hidden">{{trans('admin.user')}}</th>
                        <th>{{trans('admin.comment')}}</th>
                        <th>{{trans('admin.product')}}</th>
                        <th>{{trans('admin.date')}}</th>
                        <th>{{trans('admin.actions')}}</th>

                    </thead>
                </table>
            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')

    <script>

    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/comments/list.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/comments/comments.js"
            type="text/javascript"></script>



@endpush

