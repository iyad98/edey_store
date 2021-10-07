@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')

    <!--Corona Header end-->
    <div class="send-form-page">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">قائمة الطلبات</li>
            </ol>
        </nav>
        <div class="container">
            <div class="row head-title">
                <div class="col-8"> قائمة الطلبات</div>
                {{--<div class="order-btn col-4">--}}
                    {{--<button class="btn"><img src="/img/order-re.svg" alt="..."> الطلبات المسترجعة </button>--}}
                {{--</div>--}}
            </div>

            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="payment-serch">
                        <h6>الاستعلام عن حركات الطلب</h6>
                        <form method="get">
                        <div class="input-group mb-3">
                            <input type="text" name="order_id"  value="{{isset(request()->order_id) ? request()->order_id : ""}}" id="order_id" class="form-control" placeholder="ابحث برقم الطلب"
                                   aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-prepend">
                                <button  class="btn btn-outline-secondary" type="submit" value="بحث" id="button-addon1">بحث</button>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
                @if(!auth()->user())
                <div class="col-md-4 col-12 code-auth pt-3">
                    <a class="btn forget-pass-btn d-block pb-2 text-right">ليس لديك حساب في ممنون ؟</a>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        <i class="fas fa-mobile-alt"></i>
                                        تأكيد رقم الجوال
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="get" action="{{LaravelLocalization::localizeUrl('my-account/orders')}}/{{request()->order_id}}">
                                <div class="modal-body">
                                    <p>تم ارسال كود تحقق إلى رقم الجوال المرتبط بالطلب المستعلم عنه</p>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">كود التحقق</label>
                                        <input type="hidden" name="order_id"  value="{{isset(request()->order_id) ? request()->order_id : ""}}" >
                                        <input type="text" name="sms_code" class="form-control" id="exampleInputEmail1"
                                               aria-describedby="emailHelp" placeholder="كود التحقق">

                                    </div>
                                </div>
                                <div class="modal-footer">

                                    <button type="submit" class="btn">إرسال</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <span class="auth-text"> *  سوف يتم ارسال كود تحقق لرقم جوالك المرتبط بالطلب </span>
                </div>
                    @endif
            </div>
            <div class="about-table">
                <table>
                    <thead>
                    <tr>
                        <td>رقم الطلب</td>
                        <td>تاريخ الطلب</td>
                        <td>حالة الطلب</td>
                        <td>الإجمالي</td>
                        <td>الإجراءات</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="bold-text"><a href="{{LaravelLocalization::localizeUrl('my-account/orders')}}/{{$order->id}}">@if(in_array($order->status , [6,9,10]))R @endif{{$order->id}}          </a> </td>
                        <td class="bold-text">
                            <time datetime="{{$order->created_at}}">{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d h:i a')}}</time>
                        </td>
                        <td> {{trans_order_status()[$order->status]}}</td>
                        <td>{{$order->total_price}} <span>{{$order->currency->symbol}}</span></td>
                        <td class="order-details-btn">
                            <button class="btn">
                                <a  href="{{LaravelLocalization::localizeUrl('my-account/orders')}}/{{$order->id}}">
                                تفاصيل الطلب
                                </a></button>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()



@section('js')
    <script>

        if ($('#order_id').val() != ''){
            $('#exampleModal').modal('show');

        }

    </script>
@endsection