<!--Girl Clothes section start-->
<div class="girl-clothes">
    <div class="container">
        <div class="title">
            {{$title}}
        </div>
        <div class="whole-section">
            <div class="products-section">

                <?php
                $products_count = count($products);
                $slider_count =  ceil($products_count / 6);

                ?>
                <div class="owl-carousel carousel-responsive d-block d-md-none">
                    @foreach($products as $product)
                        @include('website.shop.partals.product' , ['product' => $product])
                    @endforeach
                </div>


                <div id="carouselExampleIndicators1" class="carousel slide d-none d-md-block" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php $index  = 0 ;?>

                        @foreach($products  as $k => $product)
                            @if($k % 6 == 0)
                            <li data-target="#carouselExampleIndicators1" data-slide-to="{{$index}}" class="  @if($k == 0) active  @endif"></li>
                                    <?php $index  = $index + 1 ;?>
                            @endif
                        @endforeach


                    </ol>
                    <div class="carousel-inner">

                        <?php $active = 0 ;?>
                        @for($i = 0 ; $i < $slider_count ; $i++)

                            <?php $count_start =  $i * 6; ?>
                        <div class="carousel-item @if($active == 0) active @endif">
                            <div class="girl-products">
                                @foreach($products as $k => $product)
                                    @if($k >= $count_start)
                                    @include('website.partals.product' , ['product' => $product])
                                        @if($k % 5  == 0 && $k != 0)
                                            <?php $active = 1; ?>
                                            @break

                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endfor
                    </div>

                    <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button"
                       data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button"
                       data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>

                </div>
            </div>


            <div class="sale">

                <div class="about-img">
                    <img class="lazyload"  data-src="{{$bannar}}" alt="">
                </div>

            </div>
            <div class="sale-responsive">


                    <img class="lazyload"  data-src="{{$bannar_mobile}}" alt="">


            </div>
        </div>

    </div>
</div>
<!--Girl Clothes section end-->
<br><br>