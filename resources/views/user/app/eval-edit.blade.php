@extends('layouts.user.dashboard-master')

@section('title')
Section 6 - Evaluation Criteria
@endsection

@push('styles')
<link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
@endpush

@section('content')
{{-- Error Messages --}}
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.
    <br>
    <br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- ContentStarts --}}
<div class="row">
    <div class="col-lg-12">
        <form action={{ route('evaluations.update',$appMast->id) }} id="form-create" role="form" method="post" class='form-horizontal'
            files=true enctype='multipart/form-data' accept-charset="utf-8">
            {!! method_field('patch') !!}
            @csrf
            <small class="text-danger">(All fields are mandatory)</small>



            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>6.1 Criteria</b>
                </div>
                <div class="card-body p-0">
                    <div class="row m-0">
                        <div class="col-md-6 p-1">
                            <span><b>Key Chemical Synthesis based KSMs/Drug Intermediates</b></span>
                        </div>
                        <div class="col-md-6 text-center">
                                @foreach($prods as $prod)
                                @if(in_array($prod->id,$user->eligible_product))
                                @if($prod->id == $appMast->eligible_product)
                                <span class="help-text">{{ $prod->product }}</span>
                                @endif
                                @endif
                                @endforeach
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-md-12">
                            <div class="table-responsive rounded">
                                <table class="table table-bordered table-hover table-sm">
                                    <tbody>
                                        <tr class="table-primary">
                                            <th class="w-50 text-center">Criteria</th>
                                            <th class="w-25 text-center">Weightage</th>
                                            <th class="w-25 text-center">Quote by Applicant</th>
                                        </tr>
                                        <tr>
                                            <th class="w-50 p-1">
                                                Committed Annual Production capacity (in multiple of whole nos. of
                                                minimum annual production capacity for each eligible product, as given
                                                in Appendix B of the Scheme Guidelines) <span class="text-danger">(in MT)</span></th>
                                            <td class="w-25 text-center"><b>35</b></td>
                                            <td class="w-25">
                                                <input type="text" class="form-control form-control-sm" id="capacity"
                                                    name="capacity" value="{{ $evalDet->capacity }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="w-50 p-1">Quoted Sale Price of Eligible Product <span class="text-danger">(₹ per kg)</span></th>
                                            <td class="w-25 text-center"><b>65</b></td>
                                            <td class="w-25">
                                                <input type="number" class="form-control form-control-sm" id="price"
                                                    name="price" value="{{ $evalDet->price }}">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>6.2 Proposed Investment</b>
                </div>
                <div class="card-body p-0">
                    <div class="row pt-2">
                        <div class="col-md-12">
                            <div class="table-responsive rounded">
                                <table class="table table-bordered table-hover table-sm">
                                    <tbody>
                                        <tr>
                                            <th class="w-75 p-1">Investment Committed (in multiple of whole nos. of threshold investment, as given in Appendix B of the Scheme Guidelines) Refer Clause 7.4 of the Guidelines</th>
                                            <td class="w-25">
                                                <input type="number" class="form-control form-control-sm" id="investment"
                                                    name="investment" value="{{ $evalDet->investment }}">
                                                    <span class="help-text">(₹ in crore )</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>6.3 Major heads of Proposed Investment</b>
                </div>
                <div class="card-body p-0 m-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive rounded">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <b>Instructions :-</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-danger p-0">
                                                <span class="help-text">
                                                    <ol type="1">
                                                    <li>Please provide break-up of proposed investment and source of funding into major heads as provided in table given below (Refer clause 3.1.6 of the scheme guidelines)</li>
                                                </ol>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <th class="w-75 text-center">Major Heads</th>
                                            <th class="w-25 text-center">(₹ in crore )</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inv_prt as $val)
                                        @foreach($invDet as $det)
                                        @if($det->prt_id == $val->id)
                                        <tr>
                                            <td>{{ $val->name }}</td>
                                            <td>
                                                <input type="text" name="amt[{{ $val->id }}]"
                                                    class="form-control form-control-sm @if($val->id!="17") majorheads @endif" @if($val->id=="17") readonly   id="totalmajorheads"   @endif value="{{ $det->amt }}">
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>6.4 Source of Fund</b>
                    <span class="float-right"><b>( ₹ )</b></span>
                </div>
                <div class="card-body p-0 m-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive rounded">
                                <table class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                <b>Instructions :-</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-danger p-0">
                                                <span class="help-text">
                                                    <ol type="1">
                                                    <li>Provide break-up of source of funding for propsoed invetment.</li>
                                                </ol>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <th class="w-35 text-center">Particulars</th>
                                            <th class="w-20 text-center">Promoters</th>
                                            <th class="w-20 text-center">Banks/FI</th>
                                            <th class="w-25 text-center">Others</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($fund_prt as $val)
                                        @foreach($fundDet as $det)
                                        @if($det->prt_id == $val->id)
                                        <tr>
                                            <td>{{ $val->name }}</td>
                                            <td>
                                                <input type="text" name="prom[{{ $val->id }}]"
                                                    class="form-control form-control-sm" value="{{ $det->prom }}">
                                            </td>
                                            <td>
                                                <input type="text" name="banks[{{ $val->id }}]"
                                                    class="form-control form-control-sm" value="{{ $det->banks }}">
                                            </td>
                                            <td>
                                                <input type="text" name="others[{{ $val->id }}]"
                                                    class="form-control form-control-sm" value="{{ $det->others }}">
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row pb-2">
                <div class="col-md-2 ">
                    <a href="{{ route('applications.index',$appMast->id) }}"
                        class="btn btn-success btn-sm form-control form-control-sm"><i
                            class="fas fa-home"></i> Home </a>
                </div>
                <div class="col-md-2 offset-md-3">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                 {{-- <div class="col-md-2 offset-md-3">
                    <a href="{{ route('app.submit',$appMast->id) }}" id="finalSubmit"
                        class="btn btn-danger btn-sm form-control form-control-sm @if($appMast->status != 'D') disabled @endif"
                        ><i class="fas fa-save"></i> Submit & Preview</a>
                </div> --}}
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('app.preview',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Preview </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
@include('user.partials.js.evaluation')
{!! JsValidator::formRequest('App\Http\Requests\EvalStore','#form-create') !!}
@endpush
