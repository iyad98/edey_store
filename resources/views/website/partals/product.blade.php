
<div class="product-box">

    <div class="about-img">
        <div class=" wishlist_comp_{{$product['id']}} fav-fav @if($product['in_favorite'] == true) infav @endif" >
            <a  href="javascript:;" onclick="add_to_wishlist('{{$product['id']}}' , '{{$product['in_favorite']}}')"   class="btn" >
                <i class="far fa-heart "></i>
            </a>
        </div>

        <img class="lazyload"  data-src="{{$product['image']}}" alt="">
        <div class="overlay">
            <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" class="btn">
                أضف إلى السلة
            </a>
            <div class="colors-title">
                @if($product['attributes'])
                    {{$product['attributes'][0]['name']}}
                    @for($i=0 ; $i < count($product['attributes'][0]['attribute_values']) ; $i++)
                        , {{$product['attributes'][0]['attribute_values'][$i]['name']}}
                    @endfor
                @endif
            </div>
        </div>
    </div>
    <div class="description">
        <div class="name">
            <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}">   <h6>{{$product['name']}} </h6></a>
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