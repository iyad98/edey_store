
@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection
<style>#sort_by_orderby {
        width: auto !important;
    }</style>
@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')


    <div class="contact-page" id="details_page">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                @foreach($breadcrumb_arr as $key=>$breadcrumb)
                    @if($key+1 == count($breadcrumb_arr))
                        {{$breadcrumb['name']}}
                    @else
                        <li class="breadcrumb-item">  <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a></li>
                    @endif
                @endforeach

            </ol>
        </nav>

        <div class="container">
            <div class="head-title">
                تواصل معنا
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="img-slide">
                        <img class="lazyload"  data-src="/website/img/Group 9951.png" alt="img-slide">
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="alert alert-danger dan_alert hidden" role="alert">

                    </div>
                    <div class="alert alert-success suc_alert hidden" role="alert ">
                    </div>


                    <div class="about-inputs">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <input type="text" placeholder="الاسم كاملا"  v-model="contact.name">
                            </div>
                            <div class="col-12 col-md-6">
                                <input type="email" placeholder="البريد الالكتروني"   v-model="contact.email">
                            </div>
                            <div class="col-12">
                                <textarea name="msg" id="msg" cols="30" rows="10" placeholder="نص رسالتك"  v-model="contact.message"></textarea>
                            </div>
                            <div class="col-12 col-md-6">
                                <button class="btn send-btn"
                                        @click="send_contact"

                                >تأكيد وارسال</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-4">
                    <div class="about-text">
                        <p>شرح عن طريقة الدفع، هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص
                            من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى
                            زيادة عدد الحروف التى يولدها التطبيق.
                            إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد،
                            النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه
                            الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.

                        </p>
                        <div class="keep-in-touch">
                            <h4>
                                ابقى على تواصل
                            </h4>
                            <p>العنوان : {{$footer_data['place']}}</p>

                            <p>رقم الجوال :{{$footer_data['phone']}}</p>
                            <p>الايميل :{{$footer_data['email']}}</p>
                            <div class="social-links">

                                <a href="{{$footer_data['instagram']}}">
                                    <button class="btn btn-link">
                                        <i class="fab fa-instagram"></i>
                                    </button>
                                </a>
                                <a href="{{$footer_data['snapchat']}}">
                                    <button class="btn btn-link">
                                        <i class="fab fa-snapchat-ghost"></i>
                                    </button>
                                </a>
                                <a href="{{$footer_data['twitter']}}">
                                    <button class="btn btn-link">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                </a>
                                <a href="{{$footer_data['facebook']}}">
                                    <button class="btn btn-link">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('website.partals.services')
    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()

@section('js')

    <script src="{{url('')}}/website/general/js/contact/contact.js" type="text/javascript"></script>

@stop()

