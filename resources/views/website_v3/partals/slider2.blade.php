<div class="sec_block_home wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.1s">
    <div class="container-general">
        <div class="gallery-wrap wrap-effect-1">
            {{--            <div class="item">--}}
            {{--                <div class="layer">--}}
            {{--                    <div class="layer_widget">--}}
            {{--                        <img src="{{asset('website_v3/img/icon1.svg')}}" alt="">--}}
            {{--                        <h3>أعمال فنية</h3>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="item">--}}
            {{--                <div class="layer">--}}
            {{--                    <div class="layer_widget">--}}
            {{--                        <img src="{{asset('website_v3/img/icon2.svg')}}" alt="">--}}
            {{--                        <h3>اكسسوارات</h3>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="item">--}}
            {{--                <div class="layer">--}}
            {{--                    <div class="layer_widget">--}}
            {{--                        <img src="{{asset('website_v3/img/icon3.svg')}}" alt="">--}}
            {{--                        <h3>أكواب</h3>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="item">--}}
            {{--                <div class="layer">--}}
            {{--                    <div class="layer_widget">--}}
            {{--                        <img src="{{asset('website_v3/img/icon4.svg')}}" alt="">--}}
            {{--                        <h3>فخاريات</h3>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            @foreach($main_categories as $k => $cat_shop)
                @if($k < 4)
                    <?php
                    $slug = get_slug_data_by_lang(get_category_slug_data_from_id($all_categories, $cat_shop->id));
                    $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $cat_shop->id;
                    ?>
                    <div class="item">
                        <div class="layer">
                            <div class="layer_widget">
                                <img src="{{asset('website_v3/img/icon5.svg')}}'" alt="">
                                <h3><a href="{{$href}}" style="color: white"> {{$cat_shop->$category_name}}</a></h3>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach


        </div>
    </div>


</div>
