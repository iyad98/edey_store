
<div class="row top_row mt-3 mb-3">
    <div class="col-sm-3"></div>
    <div class="col-sm-6"><h5 style="font-weight: 600">{{trans('admin.website_home')}}</h5>
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
                    الاكثر بيعا وجديد راق

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
                            <div v-show="[1,5,6].includes(category.type)" class="col-sm-4">عدد
                                المنتجات
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4"><input type="text" class="name_ar form-control"
                                                         v-model="category.name_ar"></div>
                            <div class="col-sm-4"><input type="text" class="name_en form-control"
                                                         v-model="category.name_en"></div>
                            <div v-show="[1,5,6].includes(category.type)" class="col-sm-4">
                                <input type="text" class="in_home_products_count form-control"
                                       v-model="category.in_home_products_count">
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
