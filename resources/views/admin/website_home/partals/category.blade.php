

<div class="row top_row mb-3 mt-5">
    <div class="col-sm-3"></div>
    <div class="col-sm-6"><h5
                style="font-weight: 600">{{trans('admin.categories_in_website_home')}}</h5>
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
                {{--<div class="col-sm-6"><input type="text" class="nickname_ar form-control"--}}
                {{--v-model="category.nickname_ar"></div>--}}
                {{--<div class="col-sm-6"><input type="text" class="nickname_en form-control"--}}
                {{--v-model="category.nickname_en"></div>--}}
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