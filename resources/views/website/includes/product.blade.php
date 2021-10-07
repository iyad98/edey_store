<div class="product-inner pr">
    <div class="product-image pr">
        <div class="yith-wcwl-add-to-wishlist ts__03 mg__0 pa add-to-wishlist-489">
            <div class="yith-wcwl-add-button show wishlist_comp_{{$product['id']}}">
                <a href="javascript:;" onclick="add_to_wishlist('{{$product['id']}}' , '{{$product['in_favorite']}}')"
                   data-product-id="489"
                   data-product-type="variable"
                   class=" cw"><i
                            class="fa_wishlist {{$product['in_favorite'] ? 'fa fa-heart in_favorite' : 'fa fa-heart-o'}} ">
                        <div id="add_to_wishlist_loading_{{$product['id']}}" class="blockUI blockOverlay hidden"
                             style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: -7px; left: 0px; opacity: 0.6; cursor: wait;"></div>
                    </i>


                </a>
                <i
                        class="fa fa-spinner fa-pulse ajax-loading pa"
                        style="visibility:hidden"></i>


            </div>
            <div class="yith-wcwl-wishlistaddedbrowse hide"
                 style="display:none;"><a class="chp" href="wishlist.html"><i
                            class="fa fa-heart"></i></a></div>
            <div class="yith-wcwl-wishlistexistsbrowse hide"
                 style="display:none"><a href="wishlist.html" class="chp"><i
                            class="fa fa-heart"></i></a></div>


        </div>
        <a class="db"
           href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" >
            <div class="badge badge-onsale tc fs__12"><i
                        class="onsale pa right">عرض</i></div>
            <img width="500" height="692"
                 src="{{$product['thumb_image']}}"
                 class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                 alt=""
                 srcset="{{$product['thumb_image']}} 500w"
                 sizes="(max-width: 500px) 100vw, 500px"/></a>
        <div class="product-btn pa flex column ts__03">
            <a rel="nofollow"
               href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}"
               class="button product_type_simple add_to_cart_button ajax_add_to_cart pr br-36 mb__10"><i
                        class="fa fa-shopping-cart mr__10"></i>اضف إلى السلة</a>
        </div>
        {{--<div class="product-attr pa ts__03 cw">--}}
            {{--<p>4, 6, 8, 10</p>--}}
        {{--</div>--}}
    </div>
    <div class="product-info mt__15">
        <h3 class="product-title pr fs__14 mg__0 fwm"><a class="cd chp"
                                                         href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}"            >
                {{$product['name']}}
            </a></h3>
        <span class="price">
            @if($product['is_discount'])
                <del>
                                                        <span class="woocommerce-Price-amount amount">{{$product['price']}}
                                                            &nbsp;<span
                                                                    class="woocommerce-Price-currencySymbol">{{$product['currency']}}</span></span>
                                                    </del>
            @endif
            <ins>
                                                    <span class="woocommerce-Price-amount amount">{{$product['price_after']}}
                                                        &nbsp;<span
                                                                class="woocommerce-Price-currencySymbol">{{$product['currency']}}</span>
                                                    </span>
                                                </ins>
        </span>
        {{--<a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" data-quantity="1"--}}
           {{--class="button product_type_variable add_to_cart_button"--}}
           {{--data-product_id="489" data-product_sku="E6"--}}
           {{--rel="nofollow">{{trans('website.add_to_cart')}}</a>--}}
    </div>
</div>