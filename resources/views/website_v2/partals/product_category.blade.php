<div class="col-xl-3 col-lg-4 col-sm-6">
    <div class="product_item">
        <div class="cn_product_thumb">
            <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" class="thumb_pro img-hover">
                <img src="{{$product['image']}}" alt="">
            </a>
        </div>
        <div class="cn_product_txt">
            <h3 class="cate_title">{{  $product['categories'] }}</h3>
            <h2><a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}">{{$product['name']}} </a></h2>
            <div class="pro_evaluate">
                @for ($i = 5; $i > 0; $i--)
                    @if ($i <= $product['rate'])
                        <i class="fas fa-star checked"></i>
                    @else
                        <i class="fas fa-star"></i>
                    @endif
                @endfor

            </div>
            <div class="sale_pro">
                @if($product['is_discount'])

                        <div class="sale_old"><p><span> {{$product['price']}}</span>{{$product['currency']}}</p></div>

                @endif
                <div class="sale_new"><p><span>{{$product['price_after']}}</span> {{$product['currency']}}</p></div>


            </div>
            @if($product['in_cart'])
                <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" class="btn btn_add_cart cart_aded">في عربة التسوق</a>
            @else
                <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" class="btn btn_add_cart">أضف إلى عربة التسوق</a>

            @endif

        </div>
    </div>
</div>
