<!DOCTYPE html>
<html>
<head>
    <title>q8store Email</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="telephone=no" name="format-detection" />
    <title></title>
    <style type="text/css" data-premailer="ignore">
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
    </style>

    <style type="text/css">
        body, table, td {
            font-family: Montserrat, -apple-system, BlinkMacSystemFont, Roboto, Helvetica Neue, Helvetica, Arial, sans-serif;
        }
        @media screen and (max-width: 640px), screen and (max-device-width: 640px) {

            table[class="table-responsive"]{
                width: 100%;
            }
            table[class="table-responsive"] td{
                display: block;
                width: 48%;
                float: right;
            }

            table[class="table-responsive"] tr{
                display: block;
                /*width: 50%;*/
            }
            table[class="table-responsive"] td img[class="img_"]{
                width: 100%;
            }
            td.td_padding{
                padding-right: 15px !important;
                padding-left: 15px !important;
            }

        }

        @media screen and (max-width: 450px), screen and (max-device-width: 400px) {
            table[class="table-responsive"] td{
                /*display: block;*/
                width: 100%;
            }
            table[class="offer-table"] {
                margin-top: 20px;
                margin-bottom: 20px;
            }
            table[class="offer-table"] td {
                width: 100%;
                display: block;
                text-align: center;
            }
            table[class="offer-table"] td span{
                margin-top: 5px !important;
                margin-bottom: 5px !important;
            }
            .img-logo{
                max-width: 150px;
            }
            .float_none{
                float: none !important;
                text-align: center;
            }
            a.float_none{
                display: table !important;
                margin-left: auto;
                margin-right: auto;
            }
        }
        .img-logo > img{
            max-width: 100%;
        }
    </style>
</head>
<?php
app()->setLocale(isset($_lang_) ? $_lang_ : 'ar');
$lang = app()->getLocale();
$get_social_medial = get_social_medial_urls();
?>
<body style="margin: 0; padding: 0; direction: rtl; text-align: right;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%; max-width:650px; margin:auto; background-color: #fff;">
    <tr>
        <td style="padding: 20px 20px;" class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="right">
                        <a href="#" class="img-logo">
                            <img src="assets/logo.png" alt="">
                        </a>
                    </td>

                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 20px; background-color: #E81F34;border-radius:28px" class="td_padding" align="center">
            <img src="assets/send.png" alt="" style="">
            <h2 style="color: #ffffff; font-size: 24px; font-weight: 700;">{{$_subject_}} : {{$order->id}}</h2>
            <p style="color: #ffffff; font-size: 18px; line-height: 1.5;font-weight: 500;">{!! $_message_ !!}	 </p>
            <p style="color: #ffffff; font-size: 18px; line-height: 1.5;font-weight: 500;">شكرآ لك ... </p>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 70px;" class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <div style="padding: 20px 0; border-top:1px solid rgba(112,112,112,0.14);">
                            <p style="margin-top: 0; color: #000000; font-size: 16px;">لمزيد من المعلومات ، قم بزيارة<a href="https://www.q8store.co/" target="_blank" style="display: inline-block; color: #E81F34; text-decoration: none; font-weight: 700; margin: 0 2px;">الكويتية ستور </a>أو تواصل عبر <a href="mailto:{{$get_social_medial['email']}}" style="display: inline-block; color: #E81F34; text-decoration: none; font-weight: 700; margin: 0 2px;" target="_blank">البريد الإلكتروني </a>مباشرة</p>
                            <div class="social_block" style="display: table; margin: auto;">
                                <a href="{{$get_social_medial['facebook']}}" target="_blank" style="margin-right: 5px; float: left;"><img src="https://www.q8store.co/website_v2/email_assets/facebook.png" alt=""></a>
                                <a href="{{$get_social_medial['twitter']}}" target="_blank" style="margin-right: 5px; float: left;"><img src="https://www.q8store.co/website_v2/email_assets/twitter.png" alt=""></a>
                                <a href="{{$get_social_medial['instagram']}}" target="_blank" style="margin-right: 5px; float: left;"><img src="https://www.q8store.co/website_v2/email_assets/instgram.png" alt=""></a>
                                <a href="{{$get_social_medial['snapchat']}}" target="_blank" style="margin-right: 0; float: left;"><img src="https://www.q8store.co/website_v2/email_assets/snapchat.png" alt=""></a>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>