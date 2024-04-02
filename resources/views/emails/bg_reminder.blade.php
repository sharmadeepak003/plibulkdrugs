<!DOCTYPE html>
<html>
<style>
    h1, h2, h3, h4, h5, h6 {
        text-align: center;
    }
    #t01,#t02,#t03 {
        border: 1px solid black;
}
#t03 {
  text-align: center;
}
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Application Submitted!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table style="width: 100%">
        <tr>
            <td style="padding: 10px 0 20px 0;">
                <table style="border: 1px solid #cccccc; border-collapse: collapse; width:600px;">
                    <tr>
                        <td style=" color: #153643; font-size: 24px; font-weight: bold; font-family: Arial, sans-serif; background-color:#A9CCE3;text-justify-center">
                            <h2>PLI Scheme for Bulk Drugs</h2>
                            <p>
                                <h5 style="color:rgb(168, 39, 39);">BG Roll Over</h5>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td   style="padding: 40px 30px 40px 30px; background-color:#ffffff;">
                            <table  style="width : 100%;">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <p>Dear<br><b>{{$name}}</b></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
                                         <p>In reference to your approval under PLI Scheme for Bulk Drugs for eligible product <b>{{$product}}</b>, we are in receipt of Bank Guarantee with following particulars.
                                        </p>
                                        <p>
                                        <table id="t01" style="width: 100%">
                                            <tr>
                                                <th id="t02">BG Number</th>
                                                <th id="t02">Amount (in ₹)</th>
                                                <th id="t02">Issuing Bank</th>
                                                <th id="t02">Issue Date</th>
                                                <th id="t02">Expiry Date</th>
                                            </tr>
                                            <tr>
                                                <td class="text-center" id="t03">{{$bg_no}}</td>
                                                <td class="text-center" id="t03">{{$bg_amount}}</td>
                                                <td class="text-center" id="t03">{{$bank_name}}</td>
                                                <td class="text-center" id="t03">{{$issued_dt}}</td>
                                                <td class="text-center" id="t03">{{$expiry_dt}}</td>
                                            </tr>
                                        </table>
                                        </p>
                                        <p>
                                            In this regard as per clause 12.6 of the Scheme Guidelines “selected applicant shall submit, within two weeks of date of issuance of approval letter by the PMA, a bank guarantee of an amount mentioned along with undertaking as per Appendix D, in favour of DoP, valid for 365 days <b>to be rolled over till the proposed date of commercial production</b>”.
                                        </p>
                                        <p>
                                            Since expiry date of existing BG is approaching, you are requested to submit rolled over Bank Guarantee for period of 365 days, before expiry of the existing Bank Guarantee.
                                        </p>
                                        <p>
                                            Regards<br>
                                            IFCI Ltd.
                                        </p>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding: 0px 30px 0px 30px; background-color:#ee4c50; ">
                            <table style="width: 100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;width: 75%;">
                                        <h4>@ PLI Bulk Drugs Portal 2020</h4>
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


