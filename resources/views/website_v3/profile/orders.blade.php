@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">قائمة الطلبات</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage">
        <div class="container">
            <h2 class="title_page">قائمة الطلبات</h2>
            <div class="block_search_order">
                <h3>الاستعلام عن حركات الطلب</h3>
                <div class="row">
                    <div class="col-md-8">
                        <form class="form_search_order" method="get">
                            <input name="order_id" value="{{isset(request()->order_id) ? request()->order_id : ""}}" type="text"  id="order_id" class="form-control" placeholder="ابحث برقم الطلب">
                            <span class="search_icon"><i class="far fa-search"></i></span>
                            <button type="submit" class="btn btn_search">بحث</button>
                        </form>
                    </div>
                    @if(!auth()->user())
                    <div class="col-md-4">
                        <div class="note_order_search">
                            <h3>ليس لديك حساب في الكويتية؟</h3>
                            <p>سوف يتم ارسال كود تحقق لرقم جوالك المرتبط بالطلب*</p>
                        </div>
                    </div>
                        @endif
                </div>
            </div>
            <div class="table-responsive">

                <table class="table table_st2 table-borderd">
                    <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>تاريخ الطلب</th>
                        <th>حالة الطلب</th>
                        <th>الإجمالي</th>
                        <th>الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><strong>{{$order->id}}   </strong></td>
                        <td><strong>{{Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</strong></td>
                        <td><strong>{{trans_orignal_order_status()[$order->status]}}</strong></td>
                        <td>{{number_format($order->total_price,round_digit(),'.','' )}} <span>{{$order->currency->symbol}}</span> </td>
                        <td>
                            @if(auth()->check())

                            <a href="{{LaravelLocalization::localizeUrl('my-account/orders')}}/{{$order->id}}"  class="btn btn_prim btn_order_dt">تفاصيل الطلب</a>
                              @else
                                <a href="#order_dt{{$order->id}}" data-toggle="modal"  class="btn btn_prim btn_order_dt">تفاصيل الطلب</a>
                                <div class="modal fade modal_st" id="order_dt{{$order->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <button class="close_modal" data-dismiss="modal" aria-label="Close"><i class="far fa-times"></i></button>
                                            <div class="modal_head">
                                                <h2 class="modal_title"><i class="fas fa-mobile-alt"></i>تأكيد رقم الجوال</h2>
                                            </div>
                                            <div class="modal_body">
                                                <p class="note_modal">{{$massage}}</p>
                                                <div class="code_number"> 965 5XX XXX XX <span> {{substr($order->user_phone, -2)}}</span></div>
                                                <form class="form_st1" method="get" action="{{LaravelLocalization::localizeUrl('my-account/orders')}}/{{$order->id}}">
                                                    <div class="form-group">
                                                        <label class="fr_label">كود التحقق</label>
                                                        <input type="text" name="sms_code" id="sms_code" class="form-control" value="{{$order->sms_code}}" placeholder="كود التحقق">
                                                    </div>
                                                    <button type="submit" class="btn btn_prim btn_dt">تحقق الآن</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection


@section('css')
@endsection

@section('js')

    <script>


        $('#order_id').change(function () {
            $('#order_id').val(convertNumber($('#order_id').val()));
        });

        $('#sms_code').change(function () {
            $('#sms_code').val(convertNumber($('#sms_code').val()));
        });



    </script>
@endsection
