<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Rejection of Request for Authorized Signatory Update</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#70bbd9"
                            style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <h2>PLI Portal</h2>
                            <p>
                                @if($change_type == 'A')
                                    <h5 style="color:rgb(168, 39, 39);">Your request to update Authorize Signatory Information is rejected.
                                    </h5>
                                @elseif($change_type == 'C')
                                    <h5 style="color:rgb(168, 39, 39);">Your request to update Corporate Address is rejected.
                                    </h5>
                                @elseif($change_type == 'R')
                                    <h5 style="color:rgb(168, 39, 39);">Your request to update Registered Address is rejected.
                                    </h5>
                                @endif 
                            </p>    
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;"
                                        width="75%">
                                        &reg; PLI Portal 2020<br />
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
