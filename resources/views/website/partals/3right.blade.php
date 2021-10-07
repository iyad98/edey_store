
<!--Girl Clothes section start-->
<div class="girl-clothes">
    <div class="container">

        <div class="title">
            {{$title}}
        </div>
        <div class="owl-carousel carousel-responsive d-block d-md-none">
            @foreach($products as $product)
                @include('website.partals.product' , ['product' => $product])
            @endforeach
        </div>
        <div class="whole-section sec-2 row my-5">
            <div class="products-section d-block col-9 p-0">

                <div class="col-12">
                    <div class="related-products">
                        <div class="owl-carousel m">
                            @foreach($products as $product)
                                @include('website.partals.product' , ['product' => $product])
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>


            <div class=" col-3">
                <div class="lazyload1">
                    <img class="lazyload"  data-src="{{$bannar}}" alt="">
                </div>
            </div>


            <div class="sale-responsive">
                <div class="lazyload1">
                    <img class="lazyload"  data-src="{{$bannar}}" alt="">
                </div>
            </div>
        </div>


    </div></div>