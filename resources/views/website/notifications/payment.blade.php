<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
app()->setLocale(isset($_lang_) ? $_lang_ : 'ar');
$lang = app()->getLocale();
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

            .btn {
                background-color: #e20048; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
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
                                                                                                   src="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/logo-1.png"
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
                                                <table width="100%" border="0" align="right" cellpadding="0"
                                                       cellspacing="0" class="full">
                                                    <tr>
                                                        <td align="left" valign="top" bgcolor="#e20048"
                                                            style="background:#e20048;">

                                                            <table width="100%" border="0" align="right"
                                                                   cellpadding="0"
                                                                   cellspacing="0" class="full">
                                                                <tr>
                                                                    <td align="center" valign="top"
                                                                        bgcolor="#FFFFFF"
                                                                        style="background:#F7F7F7; width: 100%;padding: 17px;">
                                                                        <h3 style="color: {{$payment_status ? '#40a50f' : '#e20048' }};font-size: 22px;"> {{$payment_message}}</h3>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                    @if(isset($platform) && $platform == 'web')
                                                        <tr>
                                                            <td align="left" valign="top" bgcolor="#e20048"
                                                                style="background:#e20048;">

                                                                <table width="100%" border="0" align="right"
                                                                       cellpadding="0"
                                                                       cellspacing="0" class="full">
                                                                    <tr>
                                                                        <td align="center" valign="top"
                                                                            bgcolor="#FFFFFF"
                                                                            style="background:#F7F7F7; width: 100%;padding: 17px;">
                                                                            <a href="{{$pointer['url']}}" style=" background-color: #e20048; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                border-radius: 16px;
                font-weight: 700">

                                                                                {{$pointer['name']}}
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </table>

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

            <!--Header End-->


            <!--Copyright part Start-->

            <table width="100%" style="margin-bottom: 100%;" border="0" align="center" cellpadding="0" cellspacing="0">

            </table>

            <!--Copyright part End-->

        </td>
    </tr>
</table>
{{app()->setLocale('ar')}}

<!--Main Table End-->

</body>

</html>
