@extends('layouts.admin.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
<style>
    /* th {
      text-align: center;
      vertical-align: top !important;
    } */

    th {
      text-align: center;
      vertical-align: middle !important;
      font-size: 14px;
      background-color: #f8f9fa; /* Light gray background color */
      padding: 10px;
    }
    /* .pattern-table thead th:nth-child(odd) {
      background-color: #e9ecef;
    } */
</style>
@endpush

@section('title')
Claim - Incentive
@endsection

@section('content')
<div class="row">
    <div class="col-md-1">
                {{-- <div class="col-md-2 offset-md-0"> --}}
                    {{-- <div class="offset-md-1"> --}}
                        <a href="{{ route('admin.claims.incentive',['fy'=>'1']) }}"
                            class="btn btn-sm btn-warning" style="float:right;"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Back</a>
                    {{-- </div> --}}
                {{-- </div> --}}
    </div>
</div>
<div class="row py-4" >
    <div class="col-md-12">
        <div class="card border-primary" id="appTabContent">
            <div class="card-header text-center bg-primary text-white font-weight-bold">
                Summary Report
              </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered table-hover" id="apps">
                        <thead class="appstable-head">
                            <tr class="table-info">
                                <th class="text-center"></th>
                                <th class="text-center"></th>
                                <th class="text-center"></th> 
                                @foreach ($heads as $key=>$head)
                                <th class="text-center" colspan="2">{{$head}}</th>  
                                @endforeach                               
                                <th class="text-center" colspan="2">Total</th>
                            </tr>
                            <tr class="table-info">
                                <td  class="text-center">Scheme Name</td>
                                <td  class="text-center">HOD</td>
                                <td  class="text-center">Time Allowed</td>
                                @foreach ($heads as $key=>$head)
                                <td  class="text-center">No.of Claims</td>
                                <td  class="text-center">Amount</td>                                    
                                @endforeach      
                                <td  class="text-center">No.of Claims</td>
                                <td  class="text-center">Amount</td>                                
                            </tr>
                        </thead>
                        <tbody class="appstable-body">
                            <tr>
                                <td>{{$schemeDetails->scheme}}</td>
                                <td>{{$schemeDetails->hod}}</td>
                                <td>{{$schemeDetails->timeallowed}}</td>
                                @foreach ($heads as $key=>$head)
                                <td>{{$summary->where('head_id',$key)->count()}}</td>
                                <td>{{isset($summary->where('head_id',$key)->first()->appr_amount)?round($summary->where('head_id',$key)->sum('appr_amount')/10000000,2):0}}</td>
                                @endforeach
                                <td style="font-weight:bold;">{{$summary->count()}}</td>
                                <td style="font-weight:bold;">{{isset($summary->first()->appr_amount)?round($summary->sum('appr_amount')/10000000,2):0}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row pb-2">
    <div class="col-md-1">
        <a href="" onclick="printPage();"
            class="btn btn-primary btn-sm form-control form-control-sm">
            Print <i class="fas fa-print"></i>
        </a>
    </div>
</div>
@endsection

@push('scripts')
@include('partials.admin.shared.js.claimIncentive')
<script>

$(function () {
    $("#apps").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        "buttons": [{
            extend: 'csv',
            text: '<i class="fas fa-download"></i>  Download Summary Report', 
            className: 'btn-success',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14,15,16,17,18,19,20]
            },
            customize: function (csv) {
                // Modify the header row as needed
                var header = ",,,<=10,<=10,11<t<20,11<t<20,21<t<30,21<t<30,31<t<40,31<t<40,41<t<45,41<t<45,46<t<50,46<t<50,51<t<60,51<t<60,>60,>60,Total,Total\n";
                // var header = "Scheme Name,HOD,Time Allowed,No.of Claims,Amount,No.of Claims,Amount,No.of Claims,Amount,No.of Claims,Amount,No.of Claims,Amount,No.of Claims,Amount,No.of Claims,Amount,No.of Claims,Amount,No.of Claims,Amount\n";
                // var header = "Scheme Name,Company Name,Claim Duration,Incentive Amount,Date of Filing,Expected Date of Submission of Complete Information by Applicant,Expected Date of Submission of report to Ministry by PMA,No. of days between date of filing and submission of report to ministry,No. of days between receipt of complete information and submission of report to ministry,Remarks,Status,Approval Date,Approved Incentive Amount\n";
                csv = header + csv;
                return csv;
            }
        }]
    }).buttons().container().appendTo('#apps_wrapper .col-md-6:eq(0)');
});


// $(function () {
//     $("#apps").DataTable({
//         "responsive": true,
//         "lengthChange": true,
//         "autoWidth": true,
//         "buttons": [{
//             extend: 'csv',
//             text: '<i class="fas fa-download"></i>  Download Summary Report',
//             className: 'btn-success',
//             exportOptions: {
//                 columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
//             },
//             customize: function (csv) {
//                 // Split the CSV content into rows
//                 var rows = csv.split('\n');

//                 // Add borders and gray background to the first two rows
//                 rows[0] = '<tr style="border: 1px solid #000; background-color: gray;">' + rows[0] + '</tr>';
//                 rows[1] = '<tr style="border: 1px solid #000; background-color: gray;">' + rows[1] + '</tr>';

//                 // Modify the header row as needed
//                 var header = ",,,<=10,<=10,11<t<20,11<t<20,21<t<30,21<t<30,31<t<40,31<t<40,41<t<45,41<t<45,46<t<50,46<t<50,51<t<60,51<t<60,>60,>60,Total,Total\n";
//                 csv = header + rows.slice(2).join('\n');

//                 return csv;
//             }
//         }]
//     }).buttons().container().appendTo('#apps_wrapper .col-md-6:eq(0)');
// });

</script>
@endpush
