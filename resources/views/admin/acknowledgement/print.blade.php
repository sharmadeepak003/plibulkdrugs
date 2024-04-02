<html>

<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/master.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/preview.css') }}" rel="stylesheet">
</head>

<style>

table tr td { font-size: 20px; }
    </style>

<body onload="printPage();">

    <div class="wrapper" id="acknowledgement">
        <div class="row">
            <div class="col-lg-12">
                
        
                    <div class="row py-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-header bg-info">
                                    <b><div class="text-center" style="font-size: 20px;">Acknowledgement</div></b>
                                </div>
        
                                
                            <div style="margin: 30px; font-family: tahoma; font-size: 20px;"><div style="padding-bottom: 12px;">To,</div>
                            <address style="line-height: 25px; font-family: tahoma; font-size: 20px; padding-left: 18px">
                                {{ $user->name }}<br>
                                {{ $user->off_add }}<br>
                                {{ $user->off_city }}, {{ $user->off_state }}<br>
                                {{ $user->off_pin }}
                                </address>
                            </div>
        
                            <div style="padding: 13px; font-size:20px; font-family: tahoma; padding-top: 0px;">
                                This acknowledgement is being issued in connection with your application for PLI Scheme for Bulk Drugs. 
                        </div>
        
                                <div class="card-body">
                                    <table class="table table-sm table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <th style="width: 2%" class="text-center">S.no</th>
                                                <th style="width: 40%" colspan=2 class="text-center">Particulars</th>
                                                
                                            </tr>
        
                                            
                                            <tr>
                                                <th class="text-center">1</th>
                                                <th>Applicant Name</th>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">2</th>
                                                <th>Application No.</th>
                                                <td>{{ $appMast->app_no }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-center">3</th>
                                                <th>Application Submission Date </th>
                                                <td>{{  date('d/m/Y', strtotime($appMast->submitted_at)) }}</td>
                                            </tr>
        
                                            <tr>
                                                <th class="text-center">4</th>
                                                <th>Eligible Product applied for</th>
                                                <td>
                                                    <table class="sub-table">
                                                        <tr>
                                                            <th>Target Segment</th>
                                                            <th>Eligible Product</th>
                                                        </tr>
                                                       
                                                        <tr>
                                                            <td>@foreach($eligible_pro as $pro)@if($appMast->eligible_product==$pro->id){{ $pro->target_segment }}@endif @endforeach</td>
                                                            <td>@foreach($eligible_pro as $pro)@if($appMast->eligible_product==$pro->id){{ $pro->product }}@endif @endforeach</td>
                                                        </tr>
                                                        
                                                    </table>
                                                </td>
                                            </tr>
        
                                            <tr>
                                                <th class="text-center">5</th>
                                                <th>Net Worth of the Applicant (including Group Companies)</th>
                                                <td>Rs. {{ number_format($elgb->networth/10000000,2) }} crore</td>
                                            </tr>
        
                                            <tr>
                                                <th class="text-center">6</th>
                                                <th>Proposed Domestic Value Addition (DVA)</th>
                                                <td>{{ $elgb->dva }} % </td>
                                            </tr>
        
                                            <tr>
                                                <th class="text-center">7</th>
                                                <th>Whether project is Greenfield or not</th>
                                                <td>@if($elgb->greenfield=="Y") Yes @else No @endif</td>
                                            </tr>
        
                                            
        
                                            <tr>
                                                <th class="text-center">8</th>
                                                <th>Whether Applicant has been declared as bankrupt,wilful defaulter or reported 
                                                    as fraud by any Bank or Financial Institution
                                                    
                                                    
                                                </th>
                                                <td> 
        
                                                    @if($elgb->bankrupt=="Y") Yes @else No @endif
                                                    
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <th class="text-center">9</th>
                                                <th>Committed Annual Production Capacity</th>
                                                <td>{{ $evalDet->capacity }} MT</td>
                                            </tr>
                                            
                                            <tr>
                                                <th class="text-center">10</th>
                                                <th>Quoted Sales Price of Eligible Product</th>
                                                <td>Rs. {{ $evalDet->price }} per Kg</td>
                                            </tr>
        
                                            <tr>
                                                <th class="text-center">11</th>
                                                <th>Committed Investment</th>
                                                <td>Rs. {{ $evalDet->investment }} crore</td>
                                            </tr>
        
                                            <tr>
                                                <th class="text-center">12</th>
                                                <th>Application Fee Details</th>
                                                <td>
                                                    <table class="sub-table">
                                                        <tr>
                                                            <th style="width: 20%">Fee (Rs)</th>
                                                            <th style="width: 40%">Ref No</th>
                                                            <th style="width: 40%">Date of payment</th>
                                                           
                                                        </tr>
                                                       
                                                        <tr>
                                                            <td>{{ $fees->amount }}</td>
                                                            <td>{{ $fees->urn }}</td>
                                                            <td>{{ $fees->date }}</td>
                                                           
                                                        </tr>
        
                                                    </table>
                                                </td>
                                            </tr>
                                           
                                            
        
                                        </tbody>
                                        
                                    </table>
                                    
                                </div>
                                <b style="margin-left: 15px;padding-top: 15px; font-size:20px;">Important Note:-</b>
                                    <ol style=" margin-top: -4px; padding: 20px; font-size:20px; margin-left: 15px;">
                                        <li style="margin-bottom: 10px;"> This acknowledgement shall not be construed as approval under the Scheme.</li>
        
                                        <li style="margin-bottom: 10px;"> The above acknowledgement is being issued upon prima facie examination of the application form
                                            and based on data submitted by you. In case any further clarification documents are required during the appraisal process
                                            the same shall be intimated to you.</li>


                                             <li style="margin-bottom: 10px;">The acknowledgement issued based on above doesn't qualify an applicant for claiming the incentive under the Scheme.
                                                You will be eligible for incentive after approval of EC and in case you comply with the criteria stipulated under the Scheme Guidelines.
                                           
                                            </li>
        
                                        
                                    </ol>
                            </div>
                        </div>
                    </div>
                    
        
                   
        
                
            </div>
        </div>
</div>

</body>
</html>


<script>

    function printPage() {
    var div0ToPrint = document.getElementById('acknowledgement');
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><head><title></title>');
    newWin.document.write('<link href="{{ asset("css/app.css") }}" rel="stylesheet">');
    newWin.document.write('<link href="{{ asset("css/app/preview.css") }}" rel="stylesheet">'); 
    newWin.document.write('</head><body onload="window.print()">');
    newWin.document.write(div0ToPrint.innerHTML);
    newWin.document.close();
    };
    </script>


