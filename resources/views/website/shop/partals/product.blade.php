
<div class="product-box">

    <div class="about-img">


        <img class="lazyload"  data-src="{{$product['thumb_image']}}" alt="">
        <div class="overlay">
            <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" class="btn">
                أضف إلى السلة
            </a>
            <div class="colors">
                {{$product['categories']}}
            </div>
        </div>
    </div>
    <div class="description">
        <div class="name">
            <h6> {{$product['name']}}</h6>
        </div>
        <div class="price">
            @if($product['is_discount'])
            <div class="old-price">
                {{$product['price']}}  {{$product['currency']}}
            </div>
            @endif
            <div class="new-price">
                {{$product['price_after']}}  {{$product['currency']}}
            </div>
        </div>
    </div>

</div>