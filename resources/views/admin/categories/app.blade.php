@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <link href="{{url('')}}/admin_assets/assets/vendors/custom/jquery-ui/jquery-ui.bundle.css" rel="stylesheet"
          type="text/css"/>


    <link href="{{url('')}}/admin_assets/assets/general/css/nested_sortable/nested_sortable.css" rel="stylesheet"
          type="text/css"/>

    <style>
        #select_categories_div .select2-container {
            width: 100% !important;
        }

        #select_categories_2_div .select2-container {
            width: 100% !important;
        }

        #select_banners_div select2-container {
            width: 100% !important;
        }

    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->
    <!-- END: Subheader -->
    <div class="m-content" id="app_categories">

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                        <h3 class="m-portlet__head-text">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
            <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            {{--
                            <a href="javascript:;" id="add_new_category"
                               class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la la-user-plus"></i>
													<span>{{trans('admin.add_new')}}</span>
												</span>
                            </a>
                            --}}
                        </li>

                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>


                <div class="row top_row mb-3">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6"><h5 style="font-weight: 600">{{trans('admin.app_categories_in_home')}}</h5>
                    </div>
                </div>
                <div class="row top_row top_row">

                    <div class="col-sm-10">
                        <div class="row top_row">
                            <div class="col-sm-4">
                                <div id="select_categories_div">
                                    <select class="form-control m-select2" id="select_categories">

                                        <option value="-1">اختر تصنيفات</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->category_with_parents_text}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div style="margin-top: 15px;" id="select_banners_div">
                                    <select class="form-control m-select2" id="select_banners">

                                        <option value="-1">اختر البانر</option>
                                        @foreach($banners as $banner)
                                            <option value="{{$banner->id}}">{{$banner->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <select class="form-control mt-3" id="select_orderby_type">
                                        <option value="0">اختار نوع</option>
                                        <option value="-1">{{trans('api.latest_product')}}</option>
                                        <option value="-2">{{trans('api.most_sales_products')}}</option>
                                    </select>
                                </div>
                                <div class="mt-5">
                                    <span class="m-badge m-badge--primary m-badge--wide" style="padding: 0"></span>
                                    تصنيفات
                                    <br>
                                    <span class="m-badge m-badge--success m-badge--wide" style="padding: 0"></span> بانر
                                    اعلاني
                                    <br>
                                    <span class="m-badge m-badge--danger m-badge--wide" style="padding: 0"></span>
                                    الاكثر بيعا وجديدنا

                                </div>
                            </div>
                            <div class="col-sm-8">
                                <ul id="sortable" class="list-group">
                                    <li class="list-group-item" v-for="(category , index) in categories"
                                        :value="category.id">
                                        <span class="m-badge"
                                              :class="get_list_class(category.type)"
                                              style="padding: 0"></span>
                                        <span v-text="category.name"></span>
                                        <input type="hidden" :value="category.type" class="type">


                                        <div class="row">
                                            <div class="col-sm-4">الاسم المستعار(عربي)</div>
                                            <div class="col-sm-4">الاسم المستعار(انجليزي)</div>
                                            <div v-show="[1,5,6].includes(category.type)" class="col-sm-4">عدد المنتجات</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4"><input type="text" class="name_ar form-control" v-model="category.name_ar"></div>
                                            <div class="col-sm-4"><input type="text" class="name_en form-control" v-model="category.name_en"></div>
                                            <div v-show="[1,5,6].includes(category.type)" class="col-sm-4">
                                                <input type="text" class="in_home_products_count form-control" v-model="category.in_home_products_count">
                                                <input type="hidden" :value="category.type" class="type">
                                            </div>
                                        </div>

                                        <span style="float: left;"><a href="javascript:;"
                                                                      @click="delete_category(index)"
                                                                      class="delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                                      title="Delete">
                                                    <i class="la la-remove"></i>
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button" @click="add_home_categories" :disabled="loading"
                                class="btn m-btn btn-primary" style="width: 100px;"
                                v-text="'{{trans('admin.save')}}'"
                                :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                        </button>
                    </div>

                </div>

                <div class="row top_row mb-3 mt-5">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6"><h5 style="font-weight: 600">{{trans('admin.app_categories_in_sidebar')}}</h5>
                    </div>
                    <div class="col-sm-3"></div>
                </div>

                <div class="row top_row">

                    <div class="col-sm-10">
                        <div class="row top_row">
                            <div class="col-sm-6" id="select_categories_2_div">
                                <select class="form-control m-select2" id="select_categories_2">

                                    <option value="-1">اختر تصنيفات</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_with_parents_text }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <tree :tree-data="categories_sidebar"></tree>

                                {{--<ul id="sortable2" class="list-group">--}}
                                    {{--<li class="list-group-item" v-for="(category , index) in categories_sidebar"--}}
                                        {{--:key="category.id"--}}
                                        {{--:value="category.id">--}}
                                        {{--<span v-text="category.name"></span>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="col-sm-6">الاسم المستعار(عربي)</div>--}}
                                            {{--<div class="col-sm-6">الاسم المستعار(انجليزي)</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="col-sm-6"><input type="text" class="nickname_ar form-control" v-model="category.nickname_ar"></div>--}}
                                            {{--<div class="col-sm-6"><input type="text" class="nickname_en form-control" v-model="category.nickname_en"></div>--}}
                                        {{--</div>--}}
                                        {{--<span style="float: left;"><a href="javascript:;"--}}
                                                                      {{--@click="delete_category2(index)"--}}
                                                                      {{--class="delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"--}}
                                                                      {{--title="Delete">--}}
                                                    {{--<i class="la la-remove"></i>--}}
                                            {{--</a>--}}
                                        {{--</span>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button" @click="add_sidebar_categories" :disabled="loading2"
                                class="btn m-btn btn-primary" style="width: 100px;"
                                v-text="'{{trans('admin.save')}}'"
                                :class="loading2 ? 'm-loader m-loader--light m-loader--left' : ''">
                        </button>
                    </div>

                </div>
                <hr>

            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')


    <script src="{{url('')}}/admin_assets/assets/vendors/custom/jquery-ui/jquery-ui.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/tree.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/nested_sortable/jquery.nestable.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/website/website-nested_sortable.js"
            type="text/javascript"></script>

    <script>


        function arrange_sidebar_categories(sidebar_categories) {
            var sidebar_categories_after_arrange = [];
            sidebar_categories.forEach(function (t) {
                let data = {order : t.in_sidebar_order ,id : t.id , name: t.name,nickname_ar : t.nickname_ar , nickname_en : t.nickname_en ,};
                if(t.parent_app) {
                    data.parent = t.parent_app;
                }
                sidebar_categories_after_arrange.push(data);
            });
            var tree = new Tree(sidebar_categories_after_arrange);
            tree = Object.values(tree.nodes);
            let list_items = [];
            tree.forEach(function (t) {
                if(!t.hasOwnProperty('parent')) {
                    list_items.push(t);
                }
            });

            list_items = list_items.sort(function(a, b) {
                return parseFloat(a.order) - parseFloat(b.order);
            });
            return list_items;

        }

        var app_home_banner_categories = {!! $app_home_banner_categories !!};
        var sidebar_categories = {!! $sidebar_categories !!};
        var all_categories = {!! $categories !!};
        var banners = {!! $banners !!};

        var vm = new Vue({
            el: '#app_categories',
            data: {
                all_categories : all_categories ,
                banners : banners ,
                categories: [],
                categories_sidebar: [],
                loading: false,
                loading2: false,
                msg: {
                    success: '',
                    error: ''
                }
            },
            methods: {
                delete_category: function (index) {
                    this.categories.splice(index, 1);
                },
                delete_category2: function (index) {
                    this.categories_sidebar.splice(index, 1);
                },

                add_home_categories: function () {

                    this.loading = true;
                    let categories = [];
                    $('#sortable li').each(function () {
                        categories.push({
                            id: $(this).val(),
                            in_home_products_count: $(this).find('.in_home_products_count').val(),
                            type: $(this).find('.type').val() ,
                            name_ar : $(this).find('.name_ar').val(),
                            name_en : $(this).find('.name_en').val(),
                        });
                    });

                    categories = JSON.stringify(categories);
                    axios.post('categories/add-home-categories', {
                        categories: categories
                    }).then(function (res) {
                        vm.loading = false;
                        var get_res = handle_response(res.data);
                        scroll_to_div('#app_categories');

                    }).catch(function (err) {

                    });
                },
                add_sidebar_categories: function () {

                    this.loading2 = true;
                    let categories = [];
                    let get_tree = $('.dd').nestable('serialize');
                    categories = JSON.stringify(get_tree);

                    axios.post('categories/add-sidebar-categories', {
                        categories: categories
                    }).then(function (res) {
                        vm.loading2 = false;
                        var get_res = handle_response(res.data);
                        scroll_to_div('#app_categories');
                    }).catch(function (err) {

                    });
                },

                get_list_class : function (type) {
                    if(type == 1) {
                        return 'm-badge--primary m-badge--wide';
                    }else if(type == 5 || type == 6) {
                        return 'm-badge--danger m-badge--wide';
                    }else {
                        return 'm-badge--success m-badge--wide';
                    }
                }
            }
        });
        $(function () {

            $('#select_categories').select2();
            $('#select_banners').select2();
            $('#select_categories_2').select2();

            app_home_banner_categories.forEach(function (t) {
                vm.categories.push({
                    id: t.id,
                    name: t.name,
                    name_ar: t.name_ar,
                    name_en: t.name_en,
                    in_home_products_count: t.product_counts,
                    type: t.type,
                });
            });
            vm.categories_sidebar = arrange_sidebar_categories(sidebar_categories);

            $('#select_categories').change(function () {

                let value = $(this).val();
                if (value == -1) return;

                var check = vm.categories.find(function (el) {
                    return el.id == value && el.type == 1;
                });
                var get_item = all_categories.find(el => el.id == value);
                if (!check) {
                    vm.categories.push({
                        id: $(this).select2('data')[0].id,
                        name: $(this).select2('data')[0].text,
                        name_ar: get_item.name_ar,
                        name_en: get_item.name_en,
                        in_home_products_count: 5,
                        type: 1,
                    });
                }

                $(this).val('-1').trigger('change');
            });
            $('#select_banners').change(function () {

                let value = $(this).val();
                if (value == -1) return;

                var check = vm.categories.find(function (el) {
                    return el.id == value && el.type == 2;
                });
                var get_item = banners.find(el => el.id == value);
                if (!check) {
                    vm.categories.push({
                        id: $(this).select2('data')[0].id,
                        name: $(this).select2('data')[0].text,
                        name_ar: get_item.name_ar,
                        name_en: get_item.name_en,
                        in_home_products_count: 0,
                        type: 2,
                    });
                }

                $(this).val('-1').trigger('change');
            });
            $('#select_categories_2').change(function () {

                let value = $(this).val();
                if (value == -1) return;

                var check = vm.categories_sidebar.find(function (el) {
                    return el.id == value;
                });
                var get_item = all_categories.find(el => el.id == value);
                if (!check) {
                    vm.categories_sidebar.push({
                        id: $(this).select2('data')[0].id,
                        name: $(this).select2('data')[0].text,
                        nickname_ar: get_item.name_ar,
                        nickname_en: get_item.name_en ,
                    });
                }

                $(this).val('-1').trigger('change');
            });
            $('#select_orderby_type').change(function () {

                let value = $(this).val();
                let text =  $(this).children("option:selected").text();
                let type = value == -1 ? 5 : 6;

                let name_ar = "";
                let name_en = "";
                if(type == 5) {
                    name_ar = translations.latest_product_ar;
                    name_en = translations.latest_product_en;
                }else {
                    name_ar = translations.most_sales_ar;
                    name_en = translations.most_sales_en;
                }
                var check = vm.categories.find(function (el) {
                    return el.id == value;
                });
                if (value == 0) return;

                if(!check) {
                    vm.categories.push({
                        id: value,
                        name: text,
                        name_ar: name_ar,
                        name_en: name_en,
                        in_home_products_count: 5,
                        type: type,
                    });
                }


            });


            $("#sortable").sortable();
            $("#sortable").disableSelection();

            $("#sortable2").sortable();
            $("#sortable2").disableSelection();


        });
    </script>

    <script>
        $(document).ready(function () {
            $('.dd').nestable({/* config options */});
        });
    </script>
@endpush

