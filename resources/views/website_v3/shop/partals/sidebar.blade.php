<div class="col-lg-3 col-md-4">
    <div class="box_side_cate">
        <div class="box_s_head">
            <h2>{{$category_name_title}}</h2>
        </div>
        <ul class="category_type">
            @foreach($category_shop as $category)
                <?php
                $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $category->id;
                ?>
                <li><a href="{{$href}}">{{$category->name}}<span>{{$category->product_count}}</span></a></li>
                @foreach($category->website_children as $sub_category)
                    <?php
                    $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $sub_category->id;
                    ?>
                    <li><a href="{{$href}}">{{$sub_category->name}}<span>{{$sub_category->product_count}}</span></a></li>
                @endforeach
            @endforeach

        </ul>
    </div>
    {{--<div class="box_side_cate">--}}
        {{--<div class="box_s_head">--}}
            {{--<h3>الأسعار (د.ك)</h3>--}}
        {{--</div>--}}
        {{--<div class="box_s_body">--}}
            {{--<div class="filter_range">--}}
                {{--<p>من - إلى</p>--}}
            {{--</div>--}}
            {{--<div class="wg-body">--}}
                {{--<div class="price-range-selector needsclick" data-min="0" data-max="500"></div>--}}
                {{--<div class="wgpf-label">--}}
                    {{--<p class="price-range-label" data-currency-sign="د.ك" data-cursign-before="true"></p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="box_side_cate">--}}
        {{--<div class="box_s_head">--}}
            {{--<h3>الألوان</h3>--}}
        {{--</div>--}}
        {{--<div class="box_s_body">--}}
            {{--<div class="color_cate_list">--}}
                {{--<div class="owl-carousel" id="color_cate_slider">--}}
                    {{--<div class="item">--}}
                        {{--<div class="itm_color">--}}
                            {{--<input type="radio" class="radio_sty" name="color" checked>--}}
                            {{--<div class="color_btn" style="background-color: #006CFF;"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="item">--}}
                        {{--<div class="itm_color">--}}
                            {{--<input type="radio" class="radio_sty" name="color">--}}
                            {{--<div class="color_btn" style="background-color: #FC3E39;"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="item">--}}
                        {{--<div class="itm_color">--}}
                            {{--<input type="radio" class="radio_sty" name="color">--}}
                            {{--<div class="color_btn" style="background-color: #171717;"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="item">--}}
                        {{--<div class="itm_color">--}}
                            {{--<input type="radio" class="radio_sty" name="color">--}}
                            {{--<div class="color_btn" style="background-color: #FFF600;"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="item">--}}
                        {{--<div class="itm_color">--}}
                            {{--<input type="radio" class="radio_sty" name="color">--}}
                            {{--<div class="color_btn" style="background-color: #FF00B4;"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="item">--}}
                        {{--<div class="itm_color">--}}
                            {{--<input type="radio" class="radio_sty" name="color">--}}
                            {{--<div class="color_btn" style="background-color: #EFDFDF;"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="item">--}}
                        {{--<div class="itm_color">--}}
                            {{--<input type="radio" class="radio_sty" name="color">--}}
                            {{--<div class="color_btn" style="background-color: #FF00B4;"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="box_side_cate">
        <div class="box_s_head">
            <h3>الماركات</h3>
        </div>
        <div class="box_s_body">
            <div class="markat_list">
                @foreach($category_brands as $brand)
                    <div class="marka_itm">
                        <input type="radio" value="{{$brand->slug}}" class="radio_sty" name="marka">
                        <div class="marka_label">
                            <p>{{$brand->name}}</p>
                            <span>{{$brand->products_count}}</span>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    {{--<div class="box_side_cate">--}}
        {{--<div class="box_s_head">--}}
            {{--<h3>النقوش</h3>--}}
        {{--</div>--}}
        {{--<div class="inscriptions_list">--}}
            {{--<div class="inscriptions_itm">--}}
                {{--<input type="radio" class="radio_sty" name="inscription" checked>--}}
                {{--<div class="inscription_label">--}}
                    {{--<img src="/website_v2/images/n1.png" alt="">--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="inscriptions_itm">--}}
                {{--<input type="radio" class="radio_sty" name="inscription">--}}
                {{--<div class="inscription_label">--}}
                    {{--<img src="/website_v2/images/n2.png" alt="">--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="inscriptions_itm">--}}
                {{--<input type="radio" class="radio_sty" name="inscription">--}}
                {{--<div class="inscription_label">--}}
                    {{--<img src="/website_v2/images/n3.png" alt="">--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="inscriptions_itm">--}}
                {{--<input type="radio" class="radio_sty" name="inscription">--}}
                {{--<div class="inscription_label">--}}
                    {{--<img src="/website_v2/images/n4.png" alt="">--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="box_side_cate">--}}
        {{--<div class="box_s_head">--}}
            {{--<h3>المقاس/الحجم</h3>--}}
        {{--</div>--}}
        {{--<div class="box_s_body">--}}
            {{--<div class="markat_list">--}}
                {{--<div class="marka_itm">--}}
                    {{--<input type="radio" class="radio_sty" name="size">--}}
                    {{--<div class="marka_label">--}}
                        {{--<p>Small(S)</p>--}}
                        {{--<span>99</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="marka_itm">--}}
                    {{--<input type="radio" class="radio_sty" name="size" checked>--}}
                    {{--<div class="marka_label">--}}
                        {{--<p>Large(L)</p>--}}
                        {{--<span>99</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="marka_itm">--}}
                    {{--<input type="radio" class="radio_sty" name="size">--}}
                    {{--<div class="marka_label">--}}
                        {{--<p>Extra Large(XL)</p>--}}
                        {{--<span>99</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="marka_itm">--}}
                    {{--<input type="radio" class="radio_sty" name="size">--}}
                    {{--<div class="marka_label">--}}
                        {{--<p>Extra Small(XS)</p>--}}
                        {{--<span>99</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>