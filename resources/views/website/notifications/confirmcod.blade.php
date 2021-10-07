<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
app()->setLocale(isset($_lang_) ? $_lang_ : 'ar');
$lang = app()->getLocale();
$get_social_medial = get_social_medial_urls();
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
    <title>Mamnon</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #7a7a7a;
            margin: 0;
            padding: 0;
            direction: rtl;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }

        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        span.preheader {
            display: none;
            font-size: 1px;
        }

        html {
            width: 100%;
        }

        table {
            font-size: 12px;
            border: 0;
        }

        .menu-space {
            padding-right: 25px;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        tr,
        td {
            direction: rtl !important;
            margin: 0;
            padding: 0;
        }

        @media only screen and (max-width: 640px) {
            body {
                width: auto !important;
            }

            body[yahoo] .main {
                width: 440px !important;
            }

            body[yahoo] .two-left {
                width: 420px !important;
                margin: 0px auto;
            }

            body[yahoo] .full {
                width: 100% !important;
                margin: 0px auto;
            }

            body[yahoo] .alaine {
                text-align: center;
            }

            body[yahoo] .menu-space {
                padding-right: 0px;
            }

            body[yahoo] .banner {
                width: 438px !important;
            }

            body[yahoo] .menu {
                width: 438px !important;
                margin: 0px auto;
                border-bottom: #e1e0e2 solid 1px;
            }

            body[yahoo] .date {
                width: 438px !important;
                margin: 0px auto;
                text-align: center;
            }

            body[yahoo] .two-left-inner {
                width: 400px !important;
                margin: 0px auto;
            }

            body[yahoo] .menu-icon {
                display: block;
            }

            body[yahoo] .two-left-menu {
                text-align: center;
            }
        }

        @media only screen and (max-width: 479px) {
            body {
                width: auto !important;
            }

            body[yahoo] .main {
                width: 310px !important;
            }

            body[yahoo] .two-left {
                width: 300px !important;
                margin: 0px auto;
            }

            body[yahoo] .full {
                width: 100% !important;
                margin: 0px auto;
            }

            body[yahoo] .alaine {
                text-align: center;
            }

            body[yahoo] .menu-space {
                padding-right: 0px;
            }

            body[yahoo] .banner {
                width: 308px !important;
            }

            body[yahoo] .menu {
                width: 308px !important;
                margin: 0px auto;
                border-bottom: #e1e0e2 solid 1px;
            }

            body[yahoo] .date {
                width: 308px !important;
                margin: 0px auto;
                text-align: center;
            }

            body[yahoo] .two-left-inner {
                width: 280px !important;
                margin: 0px auto;
            }

            body[yahoo] .menu-icon {
                display: none;
            }

            body[yahoo] .two-left-menu {
                width: 310px !important;
                margin: 0px auto;
            }
        }
    </style>

</head>

<body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!--Main Table Start-->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#7a7a7a"
       style="background:#F7F7F7;-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; margin-bottom: 0px; margin-left: 0px; margin-right: 0px; margin-top: 0px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; font-family: Tahoma;">
    <tr>
        <td align="center" valign="top">

            <!--Header Start-->

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="top">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="left" valign="top" bgcolor="#242323"
                                    style="background: #242323 height:530px;">
                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="100%" border="0" align="right" cellpadding="0"
                                                       cellspacing="0" class="full">
                                                    <tr>
                                                        <td align="left" valign="top" bgcolor="#e20048"
                                                            style="background:#e20048;">

                                                            <table width="100%" border="0" align="right" cellpadding="0"
                                                                   cellspacing="0" class="full">
                                                                <tr>
                                                                    <td align="center" valign="top" bgcolor="#FFFFFF"
                                                                        style="background:#F7F7F7; width: 100%;padding: 17px;">
                                                                        <a href="{{url('')}}"><img editable="true"
                                                                                                   mc:edit="logo"
                                                                                                   src="http://67.205.147.150/admin_assets/assets/demo/default/media/img/logo/logo-1.png"
                                                                                                   width="165" height=""
                                                                                                   alt=""
                                                                                                   style="display:block;"/></a>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <!--
                                                                                    <tr>
                                                                                        <td height="190" align="center" valign="top" style="line-height:190px; background: #FFFFFF;"><img src="{{url('')}}/email/images/register.png" width="auto" height="100%" alt="" style="display:block;" /></td>
                                                                                    </tr>
                                        -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" class="main">
                                                    <tr>
                                                        <td align="left" valign="middle" bgcolor="#e20048"
                                                            style="background:#e20048; height:150px;">
                                                            <table width="80%" border="0" align="center" cellpadding="0"
                                                                   cellspacing="0">

                                                                <tr>
                                                                    <td align="right" valign="top"
                                                                        style=" font-size:30px; color:#FFF; line-height:30px; font-weight:bold;"
                                                                        mc:edit="twitter-text">
                                                                        <multiline style="font-family: Arial;">
                                                                            {{trans('website.thank_you_for_order' , [] , isset($_lang_) ? $_lang_ : 'ar')}}
                                                                        </multiline>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="right" valign="top" bgcolor="#FFFFFF"
                                                style="background:#ffffff;">
                                                <table width="615" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" class="two-left-inner">

                                                    <tbody>
                                                    <tr>
                                                        <td align="left" valign="top">

                                                            <table width="100%" border="0" align="left" cellpadding="0"
                                                                   cellspacing="0">

                                                                <tbody>
                                                                <tr>
                                                                    <br>
                                                                    <td align="right" valign="top"
                                                                        style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:56px; color:#161616; font-weight:normal;"
                                                                        mc:edit="text-title">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="right" valign="top"
                                                                        style="font-family: Arial; font-size:17px; color:#4b4b4b; line-height:28px; font-weight:normal; padding:20px 0px;"
                                                                        mc:edit="text-inner">
                                                                        <multiline>
                                                                            {{$_message_}}
                                                                        </multiline>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!--Header End-->


            <!--Welcome text Start-->

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="top">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="left" valign="top" bgcolor="#ffffff" style="background:#ffffff;">
                                    <table width="580" border="0" align="center" cellpadding="0" cellspacing="0"
                                           class="two-left-inner">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="100%" border="0" align="center" cellpadding="0"
                                                       cellspacing="0">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <table width="200" border="0" align="center" cellpadding="0"
                                                                   cellspacing="0">
                                                                @if(isset($platform) && $platform == 'web' )
                                                                    <tr>
                                                                        <td align="center" valign="top"
                                                                            style="font-family:Arial, Helvetica, sans-serif; font-size:22px; color:#e20048; font-weight:normal; padding-bottom:14px; padding-top:8px;"
                                                                            mc:edit="get-in-touch">
                                                                            @if(isset($pointer))
                                                                                <multiline><a href="{{$pointer['url']}}"
                                                                                              style="color: #e20048;">{{$pointer['name']}}</a>
                                                                                </multiline>
                                                                            @else
                                                                                <multiline><a
                                                                                            href="{{\LaravelLocalization::getNonLocalizedURL("/$lang/")}}"
                                                                                            style="color: #e20048;">{{trans('website.raq_shop' , [] , isset($_lang_) ? $_lang_ : 'ar')}}</a>
                                                                                </multiline>
                                                                            @endif

                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!--Welcome text End-->


            <!--Copyright part Start-->

            <table width="100%" style="margin-bottom: 100%;" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="top">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="left" valign="top" bgcolor="#e20048" style="background:#e20048;">
                                    <table width="610" border="0" align="center" cellpadding="0" cellspacing="0"
                                           class="two-left-inner">
                                        <tr>
                                            <td align="left" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top">

                                                <table border="0" align="right" cellpadding="0" cellspacing="0"
                                                       class="two-left-inner">
                                                    <tr>
                                                        <td align="center" valign="top"
                                                            style="font-family: Tahoma;font-size:14px; color:#FFF; line-height:24px; font-weight:normal;"
                                                            mc:edit="copyright">
                                                            <multiline>{{trans('website.copyright', [] , isset($_lang_) ? $_lang_ : 'ar')}} {{carbon\Carbon::now()->year}}
                                                            </multiline>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table border="0" align="left" cellpadding="0" cellspacing="0"
                                                       class="two-left-inner">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <table width="155" border="0" align="center" cellpadding="0"
                                                                   cellspacing="0">
                                                                <tr>
                                                                    <td align="center" valign="middle">
                                                                        <table width="100%" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    <a target="_blank" href="{{$get_social_medial['facebook']}}"><img editable="true"
                                                                                                     mc:edit="facebook"
                                                                                                     src="{{url('')}}/email/images/facebook.png"
                                                                                                     width="26"
                                                                                                     height="26" alt=""
                                                                                                     style="display:block;"/></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" valign="middle">
                                                                        <table width="100%" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    <a target="_blank" href="{{$get_social_medial['twitter']}}"><img editable="true"
                                                                                                     mc:edit="twitter"
                                                                                                     src="{{url('')}}/email/images/twitter.png"
                                                                                                     width="26"
                                                                                                     height="26" alt=""
                                                                                                     style="display:block;"/></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    {{--<td align="center" valign="middle">--}}
                                                                        {{--<table width="100%" border="0" align="center"--}}
                                                                               {{--cellpadding="0" cellspacing="0">--}}
                                                                            {{--<tr>--}}
                                                                                {{--<td align="center" valign="middle">--}}
                                                                                    {{--<a href="#"><img editable="true"--}}
                                                                                                     {{--mc:edit="google-plus"--}}
                                                                                                     {{--src="{{url('')}}/email/images/google-plus.png"--}}
                                                                                                     {{--width="26"--}}
                                                                                                     {{--height="26" alt=""--}}
                                                                                                     {{--style="display:block;"/></a>--}}
                                                                                {{--</td>--}}
                                                                            {{--</tr>--}}
                                                                        {{--</table>--}}
                                                                    {{--</td>--}}
                                                                    <td align="center" valign="middle">
                                                                        <table width="100%" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    <a target="_blank" href="{{$get_social_medial['youtube']}}"><img editable="true"
                                                                                                     mc:edit="youtube"
                                                                                                     src="{{url('')}}/email/images/you-tube.png"
                                                                                                     width="26"
                                                                                                     height="26" alt=""
                                                                                                     style="display:block;"/></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" valign="middle">
                                                                        <table width="100%" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    <a target="_blank" href="mailto:{{$get_social_medial['email']}}"><img editable="true"
                                                                                                     mc:edit="dribbble"
                                                                                                     src="{{url('')}}/email/images/gmail.png"
                                                                                                     width="26"
                                                                                                     height="26" alt=""
                                                                                                     style="display:block;"/></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!--Copyright part End-->

        </td>
    </tr>
</table>
{{app()->setLocale('ar')}}

<!--Main Table End-->

</body>

</html>
