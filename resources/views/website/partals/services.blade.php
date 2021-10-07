    <!--Services section start-->
    <div class="services">
        <div class="container">
<!--            --><?php
//            $services = json_encode($services);
//            ?>


            @foreach($services as $service)




            <div class="service-box">
                <div class="logo">
                    <img src="{{$service['image']}} ">
                </div>
                <div class="name">
                {{$service['title']}}
                </div>
                <div class="description">
                    {{$service['description']}}
                </div>
            </div>

                @endforeach

        </div>
    </div>
    <!--Services section start-->