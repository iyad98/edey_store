<div class="box_filter_cate d-flex -items-center">
    <h2>{{$category_name_title}}</h2>
    <div class="filter_group mr-auto">
        <div class="filter_itm">
            <label>فرز حسب</label>
            <div class="select_box form_st2" style="width: 170px;">
                <select id="sort_by_orderby" class="form-control  orderby js-example-basic-single">
                    <option value="menu_order" {{$orderBy == "menu_order" ? 'selected' : ''}}>الترتيب الافتراضي
                    </option>
                    <option value="date" {{$orderBy == "date" ? 'selected' : ''}}>الأحدث</option>
                    <option value="price" {{$orderBy == "price" ? 'selected' : ''}}>الأقل سعرا</option>
                    <option value="price_desc" {{$orderBy == "price_desc" ? 'selected' : ''}}>الأعلى سعرا</option>
                    <option value="most_sales" {{$orderBy == "most_sales" ? 'selected' : ''}}>الأعلى مبيعا</option>

                    <input type="hidden" name="page" value="1"/>
                    <input type="hidden" name="category" value="{{isset(request()->category) ? request()->category : ""}}">
                    <input type="hidden" name="brand" value="{{isset(request()->brand) ? request()->brand : ""}}">
                    <input type="hidden" name="min_price" value="{{isset(request()->min_price) ? request()->min_price : ""}}">
                    <input type="hidden" name="max_price" value="{{isset(request()->max_price) ? request()->max_price : ""}}">
                    <input type="hidden" name="search" value="{{isset(request()->search) ? request()->search : ""}}">
                </select>
            </div>
        </div>
        <div class="filter_itm">
            <label>عرض</label>
            <div  class="select_box form_st2 ">
                <select class="form-control per_page js-example-basic-single" id="sort_by_per_page">
                    <option value="16" {{$parPage == 16 ? 'selected' : ''}}>16</option>
                    <option value="24" {{$parPage == 24 ? 'selected' : ''}}>24</option>
                    <option value="32" {{$parPage == 32 ? 'selected' : ''}}>32</option>
                    <option value="40" {{$parPage == 40 ? 'selected' : ''}}>40</option>
                </select>
            </div>
        </div>
    </div>
</div>