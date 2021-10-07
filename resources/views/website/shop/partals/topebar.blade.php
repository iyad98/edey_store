<div class="sort-header">
    <div class="item-number">
        <span> {{$products_count }} </span>  عنصر
    </div>
    <div class="select-group">
        <div class="form-group">
            <label for="exampleFormControlSelect1">فرز حسب</label>
            <select id="sort_by_orderby" name="orderby" class="form-control custom-select orderby">
                <option value="menu_order" {{$orderBy == "menu_order" ? 'selected' : ''}}>الترتيب الافتراضي
                </option>


                <option value="date" {{$orderBy == "date" ? 'selected' : ''}}>الأحدث</option>
                <option value="price" {{$orderBy == "price" ? 'selected' : ''}}> الأقل سعراً

                </option>
                <option value="price_desc" {{$orderBy == "price_desc" ? 'selected' : ''}}> الأعلى
                    سعراً
                </option>

                <input type="hidden" name="page" value="1"/>
                <input type="hidden" name="category" value="{{isset(request()->category) ? request()->category : ""}}">
                <input type="hidden" name="brand" value="{{isset(request()->brand) ? request()->brand : ""}}">
                <input type="hidden" name="min_price" value="{{isset(request()->min_price) ? request()->min_price : ""}}">
                <input type="hidden" name="max_price" value="{{isset(request()->max_price) ? request()->max_price : ""}}">
                <input type="hidden" name="search" value="{{isset(request()->search) ? request()->search : ""}}">
            </select>


        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">عرض</label>
            <select class="form-control custom-select" id="exampleFormControlSelect2">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
    </div>
</div>