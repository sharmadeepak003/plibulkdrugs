<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Request for Authorized Signatory Update</title>
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
                            <h2>PLI Scheme for Bulk Drugs</h2>
                            @if($change_type == 'A')
                                <p>
                                <h5 style="color:rgb(168, 39, 39);">Your request has been sent Successfully.
                                </h5>
                                </p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b></b>
                                    </td>
                                </tr>
                                @if($change_type == 'A')
                                <tr>
                                    <td>
                                        <table cellspacing="0" width="100%"
                                            class="table table-sm table-bordered table-hover">
                                            <tbody>
                                                
                                                <tr>
                                                    <th>Old</th>
                                                    <th>Current</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table cellspacing="0" width="100%"
                                                            class="table table-sm table-bordered table-hover"
                                                            id="table1">
                                                            <tr>
                                                                <th>Name</th>
                                                                <td>{{ $old_contact_person }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Designation</th>
                                                                <td>{{ $old_designation }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Phone</th>
                                                                <td>{{ $old_mobile }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>E-Mail</th>
                                                                <td>{{ $old_email }}</td>
                                                            </tr>
                                                </tr>
                                        </table>
                                    <td>
                                        <table cellspacing="0" width="100%"
                                            class="table table-sm table-bordered table-hover" id="table2">
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $new_contact_person }}</td>
                                            </tr>
                                            <tr>
                                                <th>Designation</th>
                                                <td>{{ $new_designation }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $new_mobile }}</td>
                                            </tr>
                                            <tr>
                                                <th>E-Mail</th>
                                                <td>{{ $new_email }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @elseif($change_type == 'C')
                                <tr>{{$organization_name}} request has been sent successfully for Corporate Address Change.</tr>
                                @elseif($change_type == 'R')
                                <tr>{{$organization_name}} request has been sent successfully for Registered Address Change.</tr>
                                @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
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
<style>
    #table1,
    #table2 {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #table1 td,
    #table1 th,
    #table2 td,
    #table2 th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #table1 tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #table2 tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #table1 tr:hover {
        background-color: #ddd;
    }

    #table2 tr:hover {
        background-color: #ddd;
    }

    #table1 th,
    #table2 th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;

    }
</style>
