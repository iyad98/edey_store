<div class="mobile-menu">
    <div class="menu-mobile">
        <div class="brand-area">
            <a href="/website_v2/index.html">
                <img src="/website_v2/images/logo.png" alt="">
            </a>
        </div>
        <div class="mmenu">


            <ul class="menu_xs">
                <li><a href="{{url('')}}">الرئيسية </a></li>
                <li><a href="{{LaravelLocalization::localizeUrl('shop') . "?orderby=date"}}">أحدث المنتجات </a></li>
                @foreach($main_categories_shop as $cat_shop)
                    <?php
                    $slug = get_slug_data_by_lang(get_category_slug_data_from_id($all_categories, $cat_shop->id));
                    $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $cat_shop->id;
                    ?>
                    <li><a href="{{$href}}"> {{$cat_shop->$category_name}}</a></li>
                @endforeach


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>جميع الأقسام</span></a>
                    <ul class="dropdown-menu">

                        <li class="dropdown-submenu">
                        @foreach($main_categories as $main_category)
                            <?php
                            $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $main_category->id;
                            ?>
                            @if(count($main_category->website_children) > 0)
                                <li class="dropdown-submenu">
                                    <a href="{{$href}}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$main_category->name}}</a>
                                    <ul class="dropdown-menu">
                                        @foreach($main_category->website_children as $children)
                                            <?php
                                            $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $children->id;
                                            ?>
                                            <li><a href="{{$href}}">{{$children->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li><a href="{{$href}}">{{$main_category->name}}</a></li>
                            @endif
                        @endforeach
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-overlay"></div>
</div><!--mobile-menu-->


