<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>PLIWG - Correspondence</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        .ql-clipboard{
            display: none;
        }
        .ql-tooltip.ql-hidden{
            display: none;
        }
   </style>
</head>

<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#A9A9A9" style="padding: 0px 0 0px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <h2>PLIBD Portal</h2>
                            <p>
                                <h5 style="color:rgb(168, 39, 39);">You have received a new message.</h5>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>{{ $name }}!</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>A Message has been initiated in the 'Correspondence Module'. Check Correspondence Module in PLIBD Portal</p>
                                </br>
                                        <p>
                                            {!! $msg !!}
                                        </p>
                                    </br>
                                    <p>
                                        {!! $docExist !!}
                                    </p>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style = "  padding-left: 30px; ">
                            Regards 
                            <br>
                            {!!$reg!!}
                            </p> 

                        </td>  
                    </tr>
                    <tr>
                    <td>
                    <p style = "padding: 30px 30px 30px 30px; color:red">
                    Note:- Please respond through correspondence module only.
                    </p>  
                    </td>  
                    </tr>
                    <tr>
                        <td bgcolor="#A9A9A9" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;"
                                        width="75%">
                                        Copyright © 2020 IFCI Ltd. All rights reserved.<br>
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
