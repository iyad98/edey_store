@extends('website.layout')

@push('css')

@endpush


@section('content')
    <div class="page-header page_">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{$breadcrumb_title}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="breadcrumb">
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main" role="main">
                                <nav class="woocommerce-breadcrumb">
                                    @foreach($breadcrumb_arr as $breadcrumb)
                                        <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a>
                                    @endforeach

                                    {{$breadcrumb_last_item}}
                                </nav>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="map-branch" style="margin-bottom: 60px">
            <script src="https://maps.google.com/maps/api/js?key=AIzaSyAsVCH2AY7nJecNz41eiAGCMdupbk0qNnE&amp;sensor=false" type="text/javascript"></script>
            <!-- <div id="map" style="width: 100%; height: 600px;"></div> -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14950981.751009569!2d54.10987682938013!3d23.813548029519964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2z2KfZhNiz2LnZiNiv2YrYqQ!5e0!3m2!1sar!2sus!4v1568527498648!5m2!1sar!2sus" width="100%" height="600" frameborder="0" style="border:0;" allowfullscreen=""></iframe>


            <script type="text/javascript">
                var locations = [
                    ['فرع النسيم', , 4,'حي النسيم شارع سعد بن أبي وقاص','',''],
                    ['فرع سكاكا الجوف', , 4,'شارع المواصلات - حي الشلهوب مقابل بنك الإنماء','0136240009',''],
                    ['فرع الاحساء', , 4,' شارع الظهران - حي المبرز','0135313526',''],
                    ['فرع الاحساء', , 4,'شارع الملك عبدالله - حي الشهابية','0135819697',''],
                    ['فرع جدة', , 4,'باب شريف (جملة) - خلف شرطة البلد سابقاً - شارع الملك عبدالعزيز','0126479981',''],
                    ['فرع بريدة', , 4,'طريق الملك خالد - حي الربيع جوار كارفور','63236832',''],
                    ['فرع الرس', , 4,'شارع الملك عبدالعزيز طريق عنيزة - حي الشفاء','0163512636',''],
                    ['فرع عنيزة', , 4,'شارع طريق الملك عبدالعزيز مقابل محطة الدريس','3625002',''],
                    ['فرع الدمام', , 4,'حي النخيل شارع الثامن و العشرون المزارع سابقاً','0138124496',''],
                    ['فرع الخرج', , 4,'شارع طريق الملك فهد القاعدة - حي السلام','0115483090',''],
                    ['فرع المعيقلية', , 4,'الديرة أسواق المعيقلية برج (أ)','0114117331',''],
                    ['فرع الروضة', , 4,'حي الروضة - شارع خالد بن وليد','0112370789',''],
                    ['فرع العريجاء', , 4,'حي العريجاء - شارع أبي حنيفة','0114365051',''],
                    ['فرع البطحاء &#8211; جملة', , 4,'البطحاء (جملة)- شارع الرس - حي ثليم','0114069695',''],
                    ['فرع البديعة', , 4,'البديعة حي البديعة - شارع الدنية','0114490127',''],
                    ['فرع المعيقلية &#8211; جملة', , 4,'المعيقلية الجملة - شارع الأمير تركي','4131731',''],
                    ['فرع السلام', , 4,'حي السلام - شارع الزبير بن عوام','0112279045',''],
                    ['فرع الفيحاء', , 4,'حي الفيحاء - شارع سعد بن عبدالرحمن الاول','0112448550',''],
                    ['فرع أسواق العويس', , 4,'أسواق العويس - شارع العليا العام - حي الملك فهد','0112695952',''],
                    ['فرع حائل', , 4,' شارع الملك خالد - حي الوسيطاء','016532744',''],

                ];

                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 5,
                    center: new google.maps.LatLng(24.7691567,46.7618841),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });



                var infowindow = new google.maps.InfoWindow();

                var marker, i;
                var image = '';
                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        icon: image,
                    });

                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent('<div style="padding:20px; margin:0px;"><h3>'+locations[i][0]+'</h3><p>رابط المعرض : <a href="'+locations[i][6]+'" target="_blank">'+locations[i][6]+'</a></p><p>العنوان: '+locations[i][4]+'</p><p> للتواصل : '+locations[i][5]+'</p></div>');
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
            </script>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 margin-t-b">
                    <div class="single-page">
                        <div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع الاحساء<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع الاحساء</h3>
                                        <p><i class="fa fa-map-marker"></i> شارع الظهران - حي المبرز</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0135313526">0135313526</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع الاحساء</h3>
                                        <p><i class="fa fa-map-marker"></i>شارع الملك عبدالله - حي الشهابية</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0135819697">0135819697</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع الخرج<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع الخرج</h3>
                                        <p><i class="fa fa-map-marker"></i>شارع طريق الملك فهد القاعدة - حي السلام</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0115483090">0115483090</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع الدمام<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع الدمام</h3>
                                        <p><i class="fa fa-map-marker"></i>حي النخيل شارع الثامن و العشرون المزارع سابقاً</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0138124496">0138124496</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع الرس<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع الرس</h3>
                                        <p><i class="fa fa-map-marker"></i>شارع الملك عبدالعزيز طريق عنيزة - حي الشفاء</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0163512636">0163512636</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع بريدة<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع بريدة</h3>
                                        <p><i class="fa fa-map-marker"></i>طريق الملك خالد - حي الربيع جوار كارفور</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:63236832">63236832</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع جدة<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع جدة</h3>
                                        <p><i class="fa fa-map-marker"></i>باب شريف (جملة) - خلف شرطة البلد سابقاً - شارع الملك عبدالعزيز</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0126479981">0126479981</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع حائل<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع حائل</h3>
                                        <p><i class="fa fa-map-marker"></i> شارع الملك خالد - حي الوسيطاء</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:016532744">016532744</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع سكاكا الجوف<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع سكاكا الجوف</h3>
                                        <p><i class="fa fa-map-marker"></i>شارع المواصلات - حي الشلهوب مقابل بنك الإنماء</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0136240009">0136240009</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فرع عنيزة<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع عنيزة</h3>
                                        <p><i class="fa fa-map-marker"></i>شارع طريق الملك عبدالعزيز مقابل محطة الدريس</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:3625002">3625002</a></p>                                                                             </div>
                                </div>

                            </div></div><div class="row"><div class="col-md-12">
                                <h5 style="text-align: center;margin-bottom: 30px;font-size:  22px;color: #303077;">
                                    <strong><span style="color: #999999;">=====</span>فروع الرياض<span style="color: #999999;">=====</span></strong>
                                </h5>
                            </div></div><div class="row"><div class="branches ">
                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع النسيم</h3>
                                        <p><i class="fa fa-map-marker"></i>حي النسيم شارع سعد بن أبي وقاص</p>                                                                                                                     </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع المعيقلية</h3>
                                        <p><i class="fa fa-map-marker"></i>الديرة أسواق المعيقلية برج (أ)</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0114117331">0114117331</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع الروضة</h3>
                                        <p><i class="fa fa-map-marker"></i>حي الروضة - شارع خالد بن وليد</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0112370789">0112370789</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع العريجاء</h3>
                                        <p><i class="fa fa-map-marker"></i>حي العريجاء - شارع أبي حنيفة</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0114365051">0114365051</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع البطحاء – جملة</h3>
                                        <p><i class="fa fa-map-marker"></i>البطحاء (جملة)- شارع الرس - حي ثليم</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0114069695">0114069695</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع البديعة</h3>
                                        <p><i class="fa fa-map-marker"></i>البديعة حي البديعة - شارع الدنية</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0114490127">0114490127</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع المعيقلية – جملة</h3>
                                        <p><i class="fa fa-map-marker"></i>المعيقلية الجملة - شارع الأمير تركي</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:4131731">4131731</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع السلام</h3>
                                        <p><i class="fa fa-map-marker"></i>حي السلام - شارع الزبير بن عوام</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0112279045">0112279045</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع الفيحاء</h3>
                                        <p><i class="fa fa-map-marker"></i>حي الفيحاء - شارع سعد بن عبدالرحمن الاول</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0112448550">0112448550</a></p>                                                                             </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="item">
                                        <h3>فرع أسواق العويس</h3>
                                        <p><i class="fa fa-map-marker"></i>أسواق العويس - شارع العليا العام - حي الملك فهد</p>                                          <p><i class="fa fa-phone"></i> للتواصل : ت / <a href="tel:0112695952">0112695952</a></p>                                                                             </div>
                                </div>

                            </div></div>                </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')


@endpush
