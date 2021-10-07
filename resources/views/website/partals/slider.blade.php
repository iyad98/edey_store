<!--Slider section start-->
@if(count($home_data['data']['main_slider']) > 0)

    <div class="slider">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @for($i=0 ; $i < count($home_data['data']['main_slider']) ; $i++)
                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class=" @if($i == 0) active @endif"></li>
                @endfor
            </ol>
            <div class="carousel-inner">
                @for($i=0 ; $i < count($home_data['data']['main_slider']) ; $i++)
                    <div class="carousel-item @if($i == 0) active @endif">
                        <img class="lazyload d-block w-100" style="max-height: 500px"  data-src="{{$home_data['data']['main_slider'][$i]['image_website']}}"
                             alt="collection">
                    </div>
                @endfor


            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
@endif
<!--Slider section end-->

