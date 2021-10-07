
@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection
<style>#sort_by_orderby {
        width: auto !important;
    }</style>
@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')

    @if($count_transformation >= 2  )
    <div class="send-form-page">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">نموذج اشعار التحويل</li>
            </ol>
        </nav>
        <div class="container">
            <div class="send-form-broken text-center">
                <img src="/website/img/broken.png" alt="...">
                <h3 class="my-4">نموذج إشعار التحويل أصبح غير صالحا</h3>
                <a href="{{LaravelLocalization::localizeUrl('/')}}"> <button class="btn">الرجوع للرئيسة</button></a>

            </div>
        </div>
    </div>
    @else

    <div class="send-form-page" id="bank_transfer">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">نموذج اشعار التحويل</li>
            </ol>
        </nav>
        <div class="container">
            <div class="alert alert-danger dan_alert hidden" role="alert">

            </div>
            <div class="alert alert-success suc_alert hidden" role="alert">
            </div>
            <div class="head-title">
                نموذج إشعار تحويل
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <input type="text" placeholder="رقم الطلب" v-model="bank.order_id">
                </div>
                <div class="col-12 col-md-4">
                    <input type="text" placeholder="المبلغ" v-model="bank.price">
                </div>

                <div class="col-12 col-md-4 transfer-input">
                    <div class="custom-file-upload">
                        <input type="file" id="file" @change="get_file($event , '#file')" name="myfiles[]" placeholder="صورة من الحوالة (اختياري)" multiple />
                    </div>
                </div>



                <div class="col-12 col-md-4">
                    <select class="custom-select border-0 bg-light"  v-model="bank.bank_id">
                        @foreach($banks as $bank)
                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <input type="text" placeholder="اسم صاحب الحساب" v-model="bank.name">
                </div>
                <div class="col-12 col-md-4">
                    <input type="text" placeholder="رقم الحساب المحول منه (اختياري) "  v-model="bank.account_number">
                </div>

                <div class="col-12 col-md-3">
                    <button class="btn send-btn"   @click="send_bank_transfer">تأكيد وارسال</button>
                </div>
            </div>



        </div>
    </div>

    @endif

    @include('website.partals.services')
    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()

@section('js')
    <script>
        var order = {!! $order !!};
    </script>
    <script src="{{url('')}}/website/general/js/bank/bank.js" type="text/javascript"></script>

@stop()

