@if( $header_image )
    <div class="header-bnr">
        <button type="button" class="btn btn-light closeBnr"><i class="fas fa-times"></i></button>
        <a target="_blank" href="{{$pointer_header_image}}"><img
                    src="{{$header_image}}"></a>
    </div>
@endif
<header id="headerStore">
    <div id="cs-rewards-bar" class="top-info-bar cs-rewards-bar">
        <div class="copy-wrap">الدفع عند الاستلام متاح الآن في جميع مناطق الممكلة العربية السعودية <i
                    class="fi fi-cs-rewards"></i>
        </div>
    </div>
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-md-4 right-side">
                    <div class="top-links">
                        <div class="menu-trigger is-closed"><span>Menu</span>
                        </div>
                        <div class="cart">
                            <a  href="javascript:;" class="cb chp btn_open_search"> <i class="pe-7s-search"></i>
                            </a>
                            <a class="cb chp db" href="{{LaravelLocalization::localizeUrl('wishlist')}}"> <i
                                        class="pe-7s-like"></i>
                            </a>
                            <a class="cb chp db" href="{{LaravelLocalization::localizeUrl('my-account')}}"> <i
                                        class="pe-7s-user"></i>
                            </a>
                            <div class="jas-icon-cart pr" id="get-cart-simple-data">
                                <a class="cart-contents pr cb chp db" href="javascript:;" @click="show_cart_data"
                                   title="View your shopping cart"> <i
                                            class="pe-7s-shopbag"></i>
                                    <span class="pa count bgb br__50 cw tc" v-text="count_quantity"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="logo">
                        <a href="{{LaravelLocalization::localizeUrl('/')}}" title="{{trans('website.site_name')}}">
                            <img src="{{url('')}}/website/wp-content/upload/nlogo.png" alt="{{trans('website.site_name')}}"
                                 class="img-responsive">
                        </a>
                    </div>
                </div>
                <div class="col-md-4 top-menu">
                    <ul class="social-list">
                        <li>
                            <a href="{{$footer_data['facebook']}}" class="fa fa-facebook" data-toggle="tooltip"
                               title="فيسبوك"></a>
                        </li>
                        <li>
                            <a href="{{$footer_data['twitter']}}" class="fa fa-twitter" data-toggle="tooltip"
                               title="تويتر"></a>
                        </li>
                        <li>
                            <a href="{{$footer_data['snapchat']}}" class="fa fa-snapchat-ghost"
                               data-toggle="tooltip" title="سناب شات"></a>
                        </li>
                        <li>
                            <a href="{{$footer_data['instagram']}}" class="fa fa-instagram" data-toggle="tooltip"
                               title="انستجرام"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tags-list">

                        <ul id="menu-%d8%a7%d9%84%d8%b1%d8%a6%d9%8a%d8%b3%d9%8a%d8%a9-1" class="">
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home page_item page-item-27781 {{!isset($in_selected_category) || count($in_selected_category) <= 0 ? 'current-menu-item current_page_item': '' }} menu-item-27803">
                                <a href="{{LaravelLocalization::localizeUrl('/')}}" aria-current="page">الرئيسية</a>
                            </li>

                            @foreach($main_categories as $main_category)
                                <?php
                                $slug = get_slug_data_by_lang(get_category_slug_data_from_id($all_categories, $main_category->id));
                                $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $slug;
                                ?>
                                <li class="mega-menu menu-item menu-item-type-taxonomy menu-item-object-product_cat {{isset($in_selected_category) && ($main_category->id == $category  || $main_category->slug == $category ) ? 'current-menu-item current_page_item': ''}} menu-item-has-children menu-item-7039">
                                    <a href="{{$href}}">{{$main_category->$category_name}}</a>
                                    <?php
                                    echo build_menu($all_categories, $category_name, $all_categories, $main_category->id, isset($category) ? $category : null);
                                    ?>

                                </li>

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>