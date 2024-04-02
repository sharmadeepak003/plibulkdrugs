@extends('layouts.admin.master')

@section('title')
Admin Dashboard
@endsection

@section('content')
{{-- <div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Registered Applicants</span>
                <span class="info-box-number">{{$users}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-file-alt"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Draft Applications</span>
                <span class="info-box-number">{{$draftApps}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-clipboard-check"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Submitted Applications</span>
                <span class="info-box-number">{{$submittedApps}}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Acknowledged Applications</span>
                <span class="info-box-number">{{$acceptedApps}}</span>
            </div>
        </div>
    </div>

</div> --}}

{{-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Eligible Product wise Applicant Count
                </h5>
                <span class="float-right">
                    <button onclick="printChart()" class="btn btn-sm btn-warning">Print Chart</button>
                </span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="chart">
                            <canvas id="cntChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


<div class="row pt-2 ">

    <div class="col-2 col-sm-3  ">
        <div class="info-box border border-white">
            <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Approved Applicants</span>
                <a href="#"><span class="info-box-number">{{$totalapproved}} No.</a></span>
            </div>
        </div>
    </div>
    <div class="col-2 col-sm-3  ">
        <div class="info-box border border-white">
            <span class="info-box-icon bg-secondary"><i class="fas fa-rupee-sign"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Committed Investment</span>
                <a href="#"><span class="info-box-number">{{$committedInvestment}} (₹ in crore)</a></span>

            </div>
        </div>
    </div>
    <div class="col-2 col-sm-3  ">
        <div class="info-box border border-white">
            <span class="info-box-icon bg-info"> <i class="fas fa-tachometer-alt "></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Actual Investment</span>
                <a href="#"><span class="info-box-number">{{$acutual_sum}} (₹ in crore)</a>
                </span>
            </div>
        </div>
    </div>

    <div class="col-2 col-sm-3  ">
        <div class="info-box border border-white">
            <span class="info-box-icon bg-dark"><i class="fas fa-user-plus"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Estimated Emplyoment <br>Generation</span>
                <a href="#"><span class="info-box-number">9618</a>
                {{--{{$employment}}--}}
                </span>
            </div>
        </div>
    </div>
</div>

{{-- target Segment --}}
<div class="row pt-2 ">

    <div class="col-2 col-sm-6  ">
        <div class="info-box border border-white">
            <span class="info-box-icon bg-primary"><i style="font-size: 15px; font-weight: bold;">Target Segment</i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a data-toggle="modal" data-target="#app1" href="" title="Show List"><b>A. Key Fermentation based KSMs/Drug Intermediates</b></a></span>
                <span class="info-box-number">{{$ts1}}</span>
            </div>
        </div>
    </div>
    <div class="col-2 col-sm-6  ">
        <div class="info-box border border-white">
            <span class="info-box-icon bg-success"><i style="font-size: 15px; font-weight: bold;">Target Segment</i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a data-toggle="modal" data-target="#app2" href="" title="Show List"><b>B. Fermentation based niche KSMs/Drug Intermediates/APIs</b></a></span>
                <span class="info-box-number">{{$ts2}}</span>
            </div>
        </div>
    </div>
    <div class="col-2 col-sm-6  ">
        <div class="info-box border border-white">
            <span class="info-box-icon bg-danger"><i style="font-size: 15px; font-weight: bold;">Target Segment</i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a data-toggle="modal" data-target="#app3" href="" title="Show List"><b>C. Key Chemical Synthesis based KSMs/Drug Intermediates</b></a></span>
                <span class="info-box-number">{{$ts3}}</span>
            </div>
        </div>
    </div>


    <div class="col-2 col-sm-6  ">
        <div class="info-box border border-white">
            <span class="info-box-icon bg-dark"><i style="font-size: 15px; font-weight: bold;">Target Segment</i></span>
            <div class="info-box-content">
                <span class="info-box-text"><a data-toggle="modal" data-target="#app4" href="" title="Show List"><b>D. Other Chemical Synthesis based KSMs/ Drug Intermediates/ APIs</b></span></a>
                <span class="info-box-number">{{$ts4}}</span>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script> --}}
{{-- <script>
    var names = {!!json_encode($prodNames) !!};
    var cnts = {!!json_encode($count) !!};

</script> --}}

{{-- <script>
    var ctx = document.getElementById('cntChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: names,
            datasets: [{
                label: '# of Applicants',
                data: cnts,
                backgroundColor: '#38c172',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 90,
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            }
        }
    });

</script> --}}

{{-- <script>
    function printChart() {
        var canvas = document.getElementById("cntChart");
        var win = window.open();
        win.document.write("<br><img src='" + canvas.toDataURL() + "'/>");
        win.print();
        win.location.reload();

    }

</script> --}}

@include('admin.home_modal')

@endpush
