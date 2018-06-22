<!-- local: {{url('/')}}/img/mail -->
<!-- server: http://the.nett.mx/quiniela-innovasport/img/mail -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> -->
    <meta name="viewport" content="width=device-width" />
    <title>SID - CONFIRMATION</title>
    <style type="text/css">
        body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
        body{
            height:100% !important;
            margin:0;
            padding:0;
            width:100% !important;
        }
        #contenedor-mail {
            width: 600px;
        }

        .cuerpo-mail {
            color: #0F0F0F;
        }

        .borde-mail {
            width: 100%;
            height: 1px;
            max-width: 100%;
        }

        .footer-mail {
            text-align: center;
        }

        @media only screen and (max-width: 600px){
            body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:none !important;} /* Prevent Webkit platforms from changing default text sizes */
            body{width:100% !important; min-width:100% !important;}

            #contenedor-mail {
                width: 100% !important;
                max-width: 600px !important;
            }

            .footer-mail,
            .footer-social,
            .footer-column-left-td,
            .footer-column-right-td {
                text-align: center!important;
            }

            .footer-column-left,
            .footer-column-right {
                /*display: block!important;*/
                width: 100%!important;
            }

            .copyright {
                padding-bottom: 16px;
            }
        }
    </style>
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="margin: 0; padding: 0; font-family: Helvetica">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <table id="contenedor-mail" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 600px; background-color: #FFFFFF;">
                <tr>
                    <td align="center">
                        <img height="80" src="{{url("/")}}/img/logo_SID.png" alt="Bienvenido">
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom: 36px; padding-top: 37px; padding-left: 15px; padding-right: 15px; font-size: 16px; line-height: 24px;">
                        <table align="center" cellpadding="0" border="0" cellspacing="0" style="max-width: 400px; width: 100%">
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <div class="cuerpo-mail">¡Hola <span style="color: #4337FF;">{{$data['nombre']}} {{$data['apellidos']}}</span>!</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <div class="cuerpo-mail">Bienvenido a <b>Stratup Identification</b>.</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-bottom: 20px;">
                                    <div class="cuerpo-mail">Para terminar tu registro es necesario que verifiques esta cuenta de correo dando click en el siguiente botón:</div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding-top: 11px;">
                                    <table>
                                        <tr>
                                            <td align="center" style="-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px;" bgcolor="#1D2B36"><a href="{{url('/')}}/confirmation/{{$data['email_token']}}" target="_blank" style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #fff; text-decoration: none; text-decoration: none; -webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px; padding: 12px 34px; border: 1px solid #1D2B36; display: inline-block;"><b>Verificar correo</b></a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="border-top: 1px solid #E7E7E7; padding-top: 29px; padding-bottom: 27px; padding-left: 30px; padding-right: 30px;">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="270" class="footer-column-left">
                            <tr>
                                <td class="footer-column-left-td">
                                    <div class="copyright" style="font-size: 12px; line-height: 18px; letter-spacing: 1px; color: #B7B7B7;">© SID {{date('Y')}} </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>