@if(count($home_data['data']['main_slider']) > 0)


    <div class="col-lg-9 col-md-8 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.1s">
        <div class="owl-carousel dots_owl" id="home_banner_slider">

            @for($i=0 ; $i < count($home_data['data']['main_slider']) ; $i++)


                <div class="item">
                    <a href="{{get_pointer_home_slider_url($home_data['data']['main_slider'][$i])}}" class="itm_hm hover-effect">
                        <img src="{{$home_data['data']['main_slider'][$i]['image_website']}}" alt="">
                    </a>
                </div>
            @endfor

        </div>
    </div>



@endif
