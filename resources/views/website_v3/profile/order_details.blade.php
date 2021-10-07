
@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content')

    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">تفاصيل الطلب</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage" id="order_el">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="title_page">تفاصيل الطلب<span>( {{$order->id}} )</span></h2>
                    <div class="block_table_details_order" id="accordion">
                        <div class="table-responsive">
                            <table class="table table_order">
                                <thead>
                                <tr>
                                    <th>تفاصيل المنتج</th>
                                    <th>تتبع الحالة</th>
                                    <th>السعر</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->order_products as $product)

                                    <tr>
                                        <td>
                                            <div class="order_itm_tb clearfix">
                                                <a href="#" class="thumb_order_tb">
                                                    <img src="{{$product->product->image}}" alt="">
                                                </a>
                                                <div class="txt_order_tb">
                                                    <h2><a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product->product->id}}">{{$product->product->name}}</a></h2>
                                                    <p>الكمية: {{$product->quantity}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="label_state_order order_confirmed clickable" data-toggle="collapse" data-target="#order_state{{$product->id}}">{{trans_order_status()[$product->product_variation->order_status]}}</div>
                                        </td>
                                        <td>
                                            {{ number_format($product->total_price_after , round_digit()) }} {{$order->currency->symbol}}
                                        </td>
                                    </tr>
                                    @if(in_array($order->status , [0,1,2]))
                                    <tr class="tr_collapse">
                                        <td colspan="3">
                                            <div class="collapse show" id="order_state{{$product->id}}">
                                                <div class="block_col_state_order">
                                                    <div class="timeline">
                                                        <?php $progress = ( $product->product_variation->order_status * 100) / 5 ?>
                                                        <div class="progress_line_state" style="height: {{$progress}}%;"></div>
                                                        @foreach(trans_order_status() as $key=>$value)
                                                            <div class="container left @if($key <= $product->product_variation->order_status) active @if($key == $product->product_variation->order_status) current @endif  @endif  first_child">

                                                                <div class="content">
                                                                    <h2>{{$value}} </h2>
                                                                    <?php   $get_date_order_status = get_date_note_orignal_order_status()[$key]; ?>
                                                                    <p>{{$product->product_variation->$get_date_order_status == 'null' ? '' : $product->product_variation->$get_date_order_status  }} </p>
                                                                </div>
                                                            </div>
                                                        @endforeach


                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    @endif


                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="block_table_details_order">
                        <div class="table-responsive">
                            <table class="table table_order">
                                <thead>
                                <tr>
                                    <th>التفاصيل</th>
                                    <th>السعر</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        السعر
                                    </td>
                                    <td>
                                        {{$order->price}}
                                    </td>
                                </tr>


                                @foreach($order->coupon as $coupon)
                                    <tr>
                                        <td>{{trans('admin.coupon_value')}}
                                            ( <span>{{$coupon->coupon_code}}</span> )
                                        </td>
                                        <td total_price>
                                            {{"-".number_format($coupon->coupon_price , round_digit()) }}

                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        اجمالي المبلغ بعد الخصم
                                    </td>
                                    <td>
                                        {{$order->price_after_discount_coupon}}
                                    </td>
                                </tr>


                                <tr>
                                    <td>
                                        تكاليف الشحن
                                    </td>
                                    <td>
                                        {{$order->shipping == 0 ? trans('admin.free_shipping'): $order->shipping}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        الضريبة المضافه
                                    </td>
                                    <td>
                                        {{$order->tax}}
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="order_total d-flex align-items-center">
                        <h3>الإجمالي</h3>
                        <p class="mr-auto"> {{$order->total_price}}   {{$order->currency->symbol}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="order_support">
                        <h2>لديك مشكلة أو استفسار يخص الطلب؟</h2>
                        <ul class="support_links">
                            <li><a href="#new_ticket" data-toggle="modal"><i class="fal fa-plus-circle"></i>إنشاء تذكرة جديدة</a></li>
                            <li><a data-toggle="collapse" class="coll-service " data-target="#customers_service"><i class="fas fa-headset"></i>تواصل مع خدمة العملاء</a>
                                <div class="collapse" id="customers_service">
                                    <div class="sub_support_link">
                                        <ul>

                                            <li onclick="open_chat()"><i class="fas fa-headset"></i>  <a href="javascript:;" class="call_number"><span>الدردشة الحية</span></a></li>

                                            <li><i class="fas fa-phone"></i><a href="tel:{{$footer_data['phone']}}" class="call_number"><span>رقم الجوال</span>({{$footer_data['phone']}}) </a> </li>
                                            <li><i class="fas fa-envelope"></i><a href="mailto:{{$footer_data['email']}}" class="call_number"> <span>الايميل</span> ({{$footer_data['email']}})</a></li>

                                        </ul>
                                    </div>
                                </div>
                            </li>

                            @if(in_array($order->status , [0,1]))
                            <li id="order_cancel_div"><a href=" @if($cancel_order_stutas) #order_cancel @else #order_cancel2 @endif" data-toggle="modal"><i class="fal fa-times-circle"></i>أرغب بإلغاء الطلب</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="bill_skin_box">
                        <div class="grp_bill">
                            <h2>طريقه الاستلام</h2>
                            <p> {{$order->order_user_shipping->billing_shipping_type_->name }}</p>

                        </div>
                        <div class="grp_bill">
                            <p> الاسم : {{$order->order_user_shipping->first_name }} {{$order->order_user_shipping->last_name }} </p>
                            <p> رقم الجوال : {{$order->order_user_shipping->phone }}</p>
                            <p> الايميل : {{$order->order_user_shipping->email }}</p>
                            <p> المحافظة : {{$order->order_user_shipping->shipping_city->name }}</p>

                            <p> القطعة : {{$order->order_user_shipping->state }} </p>

                            <p>  الشارع : {{$order->order_user_shipping->street }} </p>

                            <p> الجادة :  {{$order->order_user_shipping->avenue }}</p>
                            <p> رقم المبني :{{$order->order_user_shipping->building_number }} </p>

                            <p> رقك الطابق : {{$order->order_user_shipping->floor_number }} </p>

                            <p>  رقم الشقة : {{$order->order_user_shipping->apartment_number }}</p>


                        </div>
                        <div class="grp_bill">
                            <h2>مدة الشحن</h2>
                            <p>شهرين إلى ثلاث أشهر من تاريخ الطلب</p>
                        </div>
                        <div class="grp_bill">
                            <h2>طريقة الدفع</h2>
                            <p><img src="{{$order->payment_method->image}}" alt="" style="width: 50px;">{{$order->payment_method->name}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal_st" id="order_cancel" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button class="close_modal" data-dismiss="modal" aria-label="Close"><i class="far fa-times"></i></button>
                    <div class="modal_head">
                        <h2 class="modal_title">ما هو سبب الغاء الطلب؟</h2>
                    </div>
                    <div class="modal_body">
                        <div class="alert alert-danger dan_alert1 hidden" role="alert">

                        </div>
                        <div class="alert alert-success suc_alert1 hidden" role="alert ">

                        </div>

                        <p class="note_modal">نأسف لهذه التجربة، الرجاء اخبارنا عن سبب الغاء هذا الطلب !</p>

                            <div class="form-group">
                                <input type="hidden"
                                       id="get_order_id_hidden"
                                       value="{{$order->id}}">
                                <select class="form-control js-select" v-model="cancel_reasons" data-placeholder="اختر سبب الإلغاء">
                                    <option value="-1">اختر سبب الالغاء</option>
                                    @foreach($cancel_reasons as $reason)
                                        <option value="{{$reason->id}}">{{$reason->title}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <button type="button" @click="order_cancel_api" class="btn btn_prim btn_dt order_cancel">تأكيد
                                <div role="status" class="spinner-grow text-light spinner_ccancel_order hidden"><span class="sr-only">Loading...</span></div>

                                </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal_st" id="order_cancel2" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button class="close_modal" data-dismiss="modal" aria-label="Close"><i class="far fa-times"></i></button>
                    <div class="modal_head">
                        <h2 class="modal_title">تنويه !</h2>
                    </div>
                    <div class="modal_body">
                        <p class="note_modal">عزيزي العميل : لا يمكنك إلغاء طلبك الحالي بعد الان وذلك لتجاوز فترة صلاحية إلغاء الطلب وهي<span> {{$cancel_order_time}} أيام</span> من تاريخ إنشاء الطلب {{$order->created_at}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal_st" id="new_ticket" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button class="close_modal" data-dismiss="modal" aria-label="Close"><i class="far fa-times"></i></button>
                    <div class="modal_head">
                        <h2 class="modal_title"><i class="fas fa-plus-circle"></i> إنشاء تذكرة جديدة </h2>
                    </div>
                    <div class="modal_body">

                        <div class="alert alert-danger dan_alert hidden" role="alert">

                        </div>
                        <div class="alert alert-success suc_alert hidden" role="alert ">

                        </div>
                        <div class="note_modal">
                            <div class="h_tex">
                                <p>رقم الطلب  <span>{{$order->id}}</span></p>
                                <input type="hidden" id="ticket_order_id" value="{{$order->id}}" class="form-control" placeholder="ما هي مشكلتك؟">

                            </div>
                        </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">ما هي المشكلة ؟ </label>
                                        <input type="text" v-model="ticket_title" class="form-control" placeholder="ما هي المشكلة ؟ ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="fr_label">البريد الالكتروني</label>
                                        <input type="email"  v-model="ticket_email"  class="form-control" placeholder="البريد الالكتروني">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="fr_label">أضف تفاصيل المشكلة</label>
                                        <input type="text"  v-model="ticket_description" class="form-control" placeholder="أكتب التفاصيل هنا وسوف نتواصل معك">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="fr_label">صورة من المشكلة  (اختياري)</label>
                                        {{--<div class="box_file_upload">--}}
                                            {{--<p>صورة من المشكلة </p>--}}
                                            {{--<div class="btn_upload_file">--}}
                                                {{--<input type="file"  multiple v-on:change="onFileChange" accept="image/x-png,image/gif,image/jpeg"  class="file_st" >--}}
                                                {{--<i class="fal fa-paperclip"></i>--}}
                                                {{--أرفق ملف--}}
                                            {{--</div>--}}
                                           {{----}}
                                        {{--</div>--}}
                                        <div class="dropzone dropzone-default dropzone-brand" id="documentDropzone">
                                            <div class="dropzone-msg dz-message needsclick ">
                                                <h6 class="dropzone-msg-title">أفلت الملفات هنا أو انقر للتحميل .</h6>
                                                <span class="dropzone-msg-desc">قم بتحميل ما يصل إلى 5 ملفات</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="msg_thanks"><p> نشكر تجربتك معنا، ونعتذر عن أي خلل وسوف يصلك الرد بأسرع وقت على الإيميل المدرج أعلاه</p></div>
                                </div>
                            </div>
                            <button type="button" @click="send_ticket" class="btn btn_prim btn_dt add_ticket">تأكيد
                                <div class="spinner-grow text-light hidden" id="add_ticket_loader" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>

                    </div>
                </div>
            </div>
        </div>
    </div>


@stop()
@section('css')
    <link href="/website_v2/css/dropzone.css" rel="stylesheet">

@stop()

@section('js')

    <script src="{{url('')}}/website_v2/js/dropzone.js" type="text/javascript"></script>
    <script src="{{url('')}}/website/general/js/user/order.js" type="text/javascript"></script>

<script>

    $('.coll-service').click(function(){
        $(this).toggleClass("arr");
    });
    function open_chat() {
        LiveChatWidget.call('maximize')
    }
    $(".file_st").change(function () {
        var filename = $(this).val().split('\\').pop();
        if(filename != ''){
            $(".box_file_upload p").append(filename);
        }else{
            $(".box_file_upload p").html('صورة من المشكلة ');

        }
    })


</script>
    <script>
        var uploadedDocumentMap = {}
       var myDropzone = Dropzone.options.documentDropzone = {
            url: '/',
            maxFilesize: 25, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                profile.ticket_files.push(file);
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }


                const index = profile.ticket_files.indexOf(file);
                profile.ticket_files.splice(index, 1);

            },
            init: function () {

            }
        }
    </script>
@stop()

