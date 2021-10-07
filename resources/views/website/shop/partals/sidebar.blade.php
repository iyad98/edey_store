<div class="categories-section">
    <div class="categories">
        <div class="category-title">
            التصنيفات
        </div>
        <ul class="list-unstyled">
            <?php

                    $cat  = json_decode(json_encode($category_shop , true));





            ?>
            @for($i=0 ; $i < count($cat) ; $i++)

                <a href="{{ LaravelLocalization::localizeUrl('shop') . "?category=" . $cat[$i]->id}}" class=" {{isset($in_selected_category) && ($cat[$i]->id == $category ) ? 'active': ''}}">
                    <li>{{$cat[$i]->name}}</li>
                    {{--<span>{{$cat[$i]->product_count?$cat[$i]->product_count:''}}</span>--}}
                </a>
                    @if(count($cat[$i]->children) >0 )
                    @for($ii=0 ; $ii < count($cat[$i]->children) ; $ii++)

                        <a href="{{ LaravelLocalization::localizeUrl('shop') . "?category=" . $cat[$i]->children[$ii]->id}}" class=" {{isset($in_selected_category) && ( $cat[$i]->children[$ii]->slug == $category ) ? 'active': ''}}">
                            <li>{{$cat[$i]->children[$ii]->name}}</li>
                            {{--<span>{{$cat[$i]->product_count?$cat[$i]->product_count:''}}</span>--}}
                        </a>

                    @endfor
                    @endif

            @endfor

        </ul>
    </div>
    <div class="prices">
        <div class="category-title">
            الاسعار
        </div>
        <form method="get">
            <div class="snippets">
                <p>
                    <label for="amount">من - إلى</label>
                    <input type="text" id="amount" readonly>
                </p>
                <div id="slider-range"></div>
                <button type="submit" class="button btn filterprice">تصفية</button>


            </div>
            <input type="hidden" id="min_price" name="min_price" value="{{isset($min_price) ?$min_price : 0 }}"
                   data-min="0" placeholder="أدنى سعر"/>
            <input type="hidden" id="max_price" name="max_price" value="{{isset($max_price) ?$max_price : 100 }}"
                   data-max="100" placeholder="أعلى سعر"/>

            <input type="hidden" name="page" value="1"/>
            <input type="hidden" name="category" value="{{isset(request()->category) ? request()->category : ""}}">
            <input type="hidden" name="brand" value="{{isset(request()->brand) ? request()->brand : ""}}">
            <input type="hidden" name="orderby" value="{{isset(request()->orderby) ? request()->orderby : ""}}">
            <input type="hidden" name="search" value="{{isset(request()->search) ? request()->search : ""}}">
        </form>

    </div>
    {{--<div class="colors">--}}
        {{--<div class="category-title">--}}
            {{--الألوان--}}
        {{--</div>--}}
        {{--<div class="radio-btns">--}}
            {{--<div class="circle">--}}
                {{--<input type="radio" name="color" id="blue-radio2">--}}
                {{--<label for="blue-radio2" class="blue-radio1"></label>--}}
            {{--</div>--}}
            {{--<div class="circle">--}}
                {{--<input type="radio" name="color" id="red-radio3">--}}
                {{--<label for="red-radio3" class="red-radio1"></label>--}}
            {{--</div>--}}
            {{--<div class="circle">--}}
                {{--<input type="radio" name="color" id="black-radio4">--}}
                {{--<label for="black-radio4" class="black-radio1"></label>--}}
            {{--</div>--}}
            {{--<div class="circle">--}}
                {{--<input type="radio" name="color" id="yellow-radio5">--}}
                {{--<label for="yellow-radio5" class="yellow-radio1"></label>--}}
            {{--</div>--}}
            {{--<div class="circle">--}}
                {{--<input type="radio" name="color" id="purple-radio6">--}}
                {{--<label for="purple-radio6" class="purple-radio1"></label>--}}
            {{--</div>--}}
            {{--<div class="circle">--}}
                {{--<input type="radio" name="color" id="gray-radio7">--}}
                {{--<label for="gray-radio7" class="gray-radio1"></label>--}}
            {{--</div>--}}

        {{--</div>--}}
    {{--</div>--}}
    <?php $brands  = json_decode(json_encode($category_brand , true) );

    ?>
    @if($brands)
    <div class="brands">
        <div class="category-title">
            الماركات
        </div>
        <ul class="list-unstyled">

            @for($i=0 ; $i < count($brands) ; $i++)
                <a href="{{ LaravelLocalization::localizeUrl('shop') . "?brand=" . $brands[$i]->name}}" class="">
                    <li>{{$brands[$i]->name}}</li><span></span>
                </a>
            @endfor



        </ul>
    </div>
        @endif
</div>