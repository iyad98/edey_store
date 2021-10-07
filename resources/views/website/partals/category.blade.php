

    <div class="shopping-now">
        <div class="container">
            <div class="title">
{{$title}}
            </div>

            <div class="categories">
                @foreach($products as $product)
                <div class="category-box">
                    <a href="{{get_pointer_url($product)}}">
                    <img class="lazyload"  data-src="  {{$product['image_website']}}" alt="boys">
                    {{--<h3 class="box-title">{{$product['name']}}</h3>--}}
                    <div class="layer"></div>
                    </a>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    <!--Shopping now section end-->