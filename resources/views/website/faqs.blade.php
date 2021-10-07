@extends('website.layout')

@push('css')

    <style>
        .vc_row-fluid , .wpb_text_column   {
            padding:12px!important;
        }
    </style>
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
        <div class="container">
            <div class="row">
                <div class="col-md-12 margin-t-b">
                    <div class="single-page">
                        <div class="row">
                            <div class="col-md-12 margin-t-b">
                                <div class="des-10 page-vc">
                                    <div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h4><strong>&nbsp; &nbsp;ما هو الرقم الموحد للإتصال بالشركة ؟</strong></h4>
                                                            <p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;الرقم الموحد للشركة هو&nbsp;920010584</strong></p>

                                                        </div>
                                                    </div>
                                                </div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h5>ما هي طرق الدفع المتاحة للشراء من المتجر ؟</h5>
                                                            <p><strong>&nbsp;يمكن الشراء من المتجر عن طريق البطاقة الائتمانية ( فيزا – أمريكان اكسبرس )</strong></p>
                                                            <p><strong>&nbsp;وعن طريق الدفع عن الإستلام</strong></p>
                                                            <p><strong>&nbsp;وعن طريق التحويل البنكي إلى حسابات الشركة في بنك الراجحي أو بنك الإنماء</strong></p>
                                                            <h3 class="wc-bacs-bank-details-account-name">&nbsp;شركة محمد راشد الفوزان وشركاه:</h3>
                                                            <ul class="wc-bacs-bank-details order_details bacs_details">
                                                                <li class="bank_name">&nbsp;المصرف:<strong>الراجحي</strong></li>
                                                                <li class="account_number">&nbsp;رقم الحساب:<strong>116608016666613</strong></li>
                                                                <li class="iban">&nbsp;IBAN (رقم الآيبان):<strong>SA4280000116608016666613</strong></li>
                                                            </ul>
                                                            <p>&nbsp;</p>
                                                            <h3 class="wc-bacs-bank-details-account-name">&nbsp;شركة محمد الفوزان وشركاه:</h3>
                                                            <ul class="wc-bacs-bank-details order_details bacs_details">
                                                                <li class="bank_name">&nbsp;المصرف:<strong>الإنماء</strong></li>
                                                                <li class="account_number">&nbsp;رقم الحساب:<strong>68290000003001</strong></li>
                                                                <li class="iban">&nbsp;IBAN (رقم الآيبان):<strong>SA9505000068290000003001</strong></li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">

                                                        </div>
                                                    </div>
                                                </div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <p>ما هي مدة استلام البضاعة بعد الشراء ؟</p>
                                                            <p><strong>&nbsp;من 48 ساعة&nbsp; إلى 72 ساعة من تنفيذ الطلب حسب شركة الشحن</strong></p>

                                                        </div>
                                                    </div>
                                                </div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h5>ما هو سبب اختلاف أسعار منتجات برومان للملابس الداخلية من موديل الى موديل ؟</h5>
                                                            <p><strong>&nbsp;اختلاف الأسعار سببه اختلاف الخامات ونوعية النسيج من موديل الى موديل</strong></p>

                                                        </div>
                                                    </div>
                                                </div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h5>هل يتوفر شحن مجاني ؟</h5>
                                                            <p><strong>&nbsp;نعم&nbsp;يتوفر شحن مجاني عند الشراء بمبلغ&nbsp; 500&nbsp;خمسمائة ريال</strong></p>

                                                        </div>
                                                    </div>
                                                </div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div>
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h5>ماهي شركات الشحن و التوصيل؟</h5>
                                                            <p><strong>شركات الشحن سمسا&nbsp;</strong><strong>و البريد السعودي&nbsp;</strong></p>

                                                        </div>
                                                    </div>
                                                    <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div></div></div></div></div><div class="vc_row wpb_row vc_row-fluid"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner "><div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h5>كم تكلفة شركات الشحن ؟</h5>
                                                            <p><strong>تكلفة الشحن عبر سمسا 30 ريال و تكلفة شركة الشحن عبر البريد السعودي 25 ريال&nbsp;</strong></p>

                                                        </div>
                                                    </div>
                                                    <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div>
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h5>هل يوجد توصيل لخارج المملكة العربية السعودية ؟</h5>
                                                            <p><strong>نعتذر لا يوجد توصيل لخارج السعودية</strong></p>

                                                        </div>
                                                    </div>
                                                    <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div>
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h5>ما هي متطلبات الشحن عن طريق البريد السعودي ؟</h5>
                                                            <p><strong>&nbsp;عند اختيار الشحن عن طريق البريد السعودي يجب ادخال بيانات العنوان الوطني كاملة و صحيحة&nbsp;</strong></p>
                                                            <p><strong>(العنوان الوطني،&nbsp;</strong><strong>رقم المبنى،</strong>&nbsp;<strong>الرمز البريدي،</strong>&nbsp;<strong>رقم الوحدة،</strong>&nbsp;<strong>الرقم الاضافي) </strong></p>
                                                            <p><strong>و يجب أن تكون طريقة السداد اما فيزا أو حوالة بنكية&nbsp;</strong></p>

                                                        </div>
                                                    </div>
                                                    <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div>
                                                    <div class="wpb_text_column wpb_content_element ">
                                                        <div class="wpb_wrapper">
                                                            <h5>كم تكلفة رسوم الدفع نقداً عند الاستلام&nbsp; ؟</h5>
                                                            <p><b>تكلفة رسوم الدفع نقداً 17 ريال عند الشراء بمبلغ&nbsp;</b><b>أقل&nbsp;</b><b>من 1000 ريال </b></p>
                                                            <p><b>و تكلفة رسوم الدفع نقداً 20ريال عند الشراء&nbsp;بمبلغ أكثر من 1000 ريال</b></p>

                                                        </div>
                                                    </div>
                                                    <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_blue"><span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
                                                    </div></div></div></div></div>                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')


@endpush
