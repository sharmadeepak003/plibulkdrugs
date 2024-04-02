
@extends('layouts.user.dashboard-master') 

@section('title')
Application Preview
@endsection

@push('styles')
<link href="{{ asset('css/app/preview.css') }}" rel="stylesheet">
@endpush

@section('content')


<div class="row" onload="printPage();">
    <div class="col-md-12">
        <div id="complete_form">
        <div class="row">
            <div class="col-md-12">
                
                <div class="card border-primary mt-2" id="company">
                    <div class="card-header bg-gradient-info">
                        1. Applicant / Company Details
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th><b>1.1</b></th>
                                        <th style="width: 16%" class="pl-1">Applicant / Company Details</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0">Name of the Applicant</th>
                                                            <td class="text-center">{{ $user->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-0" rowspan="2">Details of Authorised Signatory
                                                            </th>
                                                            <th class="p-0 text-center">Name</th>
                                                            <th class="p-0 text-center">Designation</th>
                                                            <th class="p-0 text-center">E-Mail</th>
                                                            <th class="p-0 text-center">Mobile</th>
                                                        </tr>
                                                        <tr>

                                                            <td class="text-center">
                                                                {{ $user->contact_person }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $user->designation }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $user->email }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $user->mobile }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-0" rowspan="2">Eligible Product Applied For
                                                            </th>
                                                            <th class="p-0 text-center" colspan="2">Target Segment</th>
                                                            <th class="p-0 text-center" colspan="2">Eligible Product
                                                            </th>
                                                        </tr>
                                                        <tr>

                                                            @foreach($prods as $prod)
                                                            @if($prod->id == $appMast->eligible_product)
                                                            <td colspan="2" class="text-center">
                                                                {{ $prod->target_segment }}</td>
                                                            <td colspan="2" class="text-center">{{ $prod->product }}
                                                            </td>
                                                            @endif
                                                            @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>1.2</b></th>
                                        <th style="width: 16%" class="pl-1">Constitution of Business</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0">Constitution of Business</th>
                                                            <td class="text-center">{{ $user->type }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="p-0" rowspan="1">Ownership Pattern as on the date
                                                                of application</th>
                                                            <th class="p-0 text-center">Name of the Shareholder/ Partner
                                                            </th>
                                                            <th class="p-0 text-center">No. of Shares</th>
                                                            <th class="p-0 text-center">% Shareholding</th>
                                                            <th class="p-0 text-center">Capital</th>
                                                        </tr>
                                                        <tr>
                                                               <th rowspan="{{ Count($promoters) + 1}}">Promoter & Promoter
                                                                Group</th>

                                                        </tr>
                                                        @foreach($promoters as $key => $value)
                                                        <tr>

                                                            <td class="text-center">
                                                                {{ $value->name }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->shares }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->per }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->capital }}
                                                            </td>

                                                        </tr>
                                                        @endforeach
                                                        <tr><th rowspan="{{ Count($others) +1 }}">Other than Promoter &
                                                            Promoter Group</th></tr>
                                                        @foreach($others as $key => $value)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $value->name }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->shares }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->per }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->capital }}
                                                            </td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>1.3</b></th>
                                        <th style="width: 16%" class="pl-1">Company Details</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th>Brief Profile of Business</th>
                                                            <td>{{ $app->bus_profile }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 0;" colspan="2">
                                                                <table style="margin: 0; width:100%;">
                                                                    <thead>
                                                                        <th>Date of Incorporation</th>
                                                                        <th>Website</th>
                                                                        <th>PAN</th>
                                                                        <th>CIN / LLPIN</th>
                                                                        <th>Listed Company</th>
                                                                        <th>Name of Stock Exchange</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <td class="text-center">
                                                                            {{ date('d/m/Y',strtotime($app->doi)) }}
                                                                        </td>
                                                                        <td class="text-center">{{ $app->website }}</td>
                                                                        <td class="text-center">{{ $user->pan }}</td>
                                                                        <td class="text-center">{{ $user->cin_llpin }}
                                                                        </td>
                                                                        <td class="text-center"> @if($app->listed ==
                                                                            'N') No
                                                                            @else
                                                                                Yes
                                                                            @endif
                                                                        </td>
                                                                        <td class="text-center"> @if($app->listed ==
                                                                            'N')
                                                                            @else
                                                                            {{$app->stock_exchange}}
                                                                            @endif</td>
                                                                    </tbody>
                                                                </table>
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <th>GSTIN and Address</th>
                                                            <td>
                                                                <table>
                                                                    <tbody>
                                                                        @foreach($gstins as $key => $value)
                                                                        <tr>
                                                                            <td>{{ $value->gstin }}</td>
                                                                            <td>{{ $value->add }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="padding: 0;">
                                                                <table style="margin: 0; width: 100%;">
                                                                    <tbody><tr>
                                                                        <th>Registered Office Address</th>
                                                                        <td>
                                                                            {{ $app->corp_add }}
                                                                        </td>
                                                                        <th>Corporate Office Address</th>
                                                                        <td> {{ $user->off_add }} </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>1.4</b></th>
                                        <th style="width: 16%" class="pl-1">Statutory Auditor Details</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0">Name of the Firm</th>
                                                            <th class="p-0">Firm Registration No.</th>
                                                            <th class="p-0">Financial Year Employed (20XX-XX)</th>
                                                        </tr>
                                                        @foreach($auditors as $key => $value)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $value->name }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->frn }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->fy }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>1.5</b></th>
                                        <th style="width: 16%" class="pl-1">Credit History</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0">Bankruptcy</th>
                                                            <th class="p-0">RBI Defaulter List</th>
                                                            <th class="p-0">Wilful Defaulter List</th>
                                                            <th class="p-0">SEBI Barred List</th>
                                                            <th class="p-0">CIBIL Score</th>
                                                            <th class="p-0">Any Legal case pending against
                                                                Applicant/Promoters</th>
                                                        </tr>
                                                        <tr>

                                                            <td class="text-center">
                                                                {{ $app->bankruptcy == "Y" ? 'Yes':'' }}
                                                                {{ $app->bankruptcy == "N" ? 'No':'' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $app->rbi_default == "Y" ? 'Yes':''}}
                                                                {{ $app->rbi_default == "N" ? 'No':''}}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $app->wilful_default == "Y" ? 'Yes':'' }}
                                                                {{ $app->wilful_default == "N" ? 'No':'' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $app->sebi_barred == "Y" ? 'Yes':'' }}
                                                                {{ $app->sebi_barred == "N" ? 'No':'' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $app->cibil_score }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $app->case_pend == "Y" ? 'Yes':'' }}
                                                                {{ $app->case_pend == "N" ? 'No':'' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><b>External Credit Rating</b></td>
                                        <td style="padding: 0;">
                                            <table class="table table-bordered table-hover table-sm" style="margin: 0">
                                                <tbody>
                                                    <tr>
                                                        <th class="p-0">Whether Applicant has
                                                            External
                                                            Credit Rating
                                                        </th>
                                                        <td class="text-center">
                                                            {{ $app->externalcreditrating == "Y" ? 'Yes' : '' }}
                                                            {{ $app->externalcreditrating == "N" ? 'No' : '' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-0">Credit Rating</th>
                                                        <th class="p-0">Name of Rating Agency</th>
                                                        <th class="p-0">Date of Rating</th>
                                                        <th class="p-0">Valid Up to</th>
                                                    </tr>
                                                    @foreach($ratings as $key => $value)
                                                    <tr>

                                                        <td class="text-center">{{ $value->rating }}
                                                        </td>
                                                        <td class="text-center">{{ $value->name }}
                                                        </td>
                                                        <td class="text-center">{{ $value->date }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $value->validity }}</td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><b>Profile of Chairman, CEO,
                                                Managing
                                                Director</b></td>
                                        <td style="padding: 0;">
                                            <table class="table table-bordered table-hover table-sm" style="margin: 0">
                                                <tbody>
                                                    <tr>
                                                        <th class="p-0">Name</th>
                                                        <th class="p-0">E-Mail</th>
                                                        <th class="p-0">Mobile</th>
                                                        <th class="p-0">DIN</th>
                                                        <th class="p-0">Address</th>
                                                    </tr>
                                                    @foreach($profiles as $key => $value)
                                                    <tr>

                                                        <td class="text-center">{{ $value->name }}
                                                        </td>
                                                        <td class="text-center">{{ $value->email }}
                                                        </td>
                                                        <td class="text-center">{{ $value->phone }}
                                                        </td>
                                                        <td class="text-center">{{ $value->din }}
                                                        </td>
                                                        <td class="text-center">{{ $value->add }}
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>1.6</b></th>
                                        <th style="width: 16%" class="pl-1">Key Management Personnel Details</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0">Name</th>
                                                            <th class="p-0">E-Mail</th>
                                                            <th class="p-0">Mobile</th>
                                                            <th class="p-0">PAN / DIN</th>
                                                        </tr>
                                                        @foreach($kmps as $key => $value)
                                                        <tr>

                                                            <td class="text-center">{{ $value->name }}</td>
                                                            <td class="text-center">{{ $value->email }}</td>
                                                            <td class="text-center">{{ $value->phone }}</td>
                                                            <td class="text-center">{{ $value->pan_din}}</td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-primary mt-2" id="eligibility">
                    <div class="card-header bg-gradient-info">
                        2. Eligibility Criteria
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th><b>2.1</b></th>
                                        <th style="width: 16%" class="pl-1">Eligibility Criteria</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0 text-center">Whether Project Proposed by Applicant is Greenfield Project as per clause 2.18 of the Guidelines</th>
                                                            <th class="p-0 text-center">Whether Applicant has been declared as bankrupt,wilful defaulter or reported as fraud by any Bank or Financial Institution - clause 4.1.4 of the Guidelines</th>
                                                            <th class="p-0 text-center">Net Worth for Eligibility Criteria (Including Group Companies/ Enterprise, if considered ) in INR (Refer Clause 2.25)</th>
                                                        </tr>
                                                        <tr>

                                                            <td class="text-center">
                                                                {{ $elgb->greenfield == "Y" ? 'Yes':'' }}
                                                                {{ $elgb->greenfield == "N" ? 'No':'' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $elgb->bankrupt == "Y" ? 'Yes':'' }}
                                                                {{ $elgb->bankrupt == "N" ? 'No':'' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $elgb->networth }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th style="width: 16%" class="pl-1">Details of Group Companies/ Enterprise whose Net Worth is being considered (Refer clause 2.19)</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0 text-center">Name of the Company/ Enterprise</th>
                                                            <th class="p-0 text-center">Registered at (Location)</th>
                                                            <th class="p-0 text-center">Registration No.</th>
                                                            <th class="p-0 text-center">Relationship with Applicant</th>
                                                            <th class="p-0 text-center">Net-Worth (in INR)</th>
                                                        </tr>
                                                        @foreach($groups as $key => $value)
                                                        <tr>

                                                            <td class="text-center">
                                                                {{ $value->name }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->location }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->regno }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->relation }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $value->networth }}
                                                            </td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>2.2</b></th>
                                        <th style="width: 16%" class="pl-1">Proposed Domestic Value Addition</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0 text-center">Proposed Domestic Value Addition [DVA] (%)</th>
                                                            <th class="p-0 text-center">Whether mandatory undertakings referred to in clause 7.6 of the scheme guidelines is being submitted.
                                                                (Undertaking for Consenting of Audit )</th>
                                                            <th class="p-0 text-center">Whether mandatory undertakings referred to in clause 17.6 of the scheme guidelines is being submitted.
                                                                (Integrity Pact)</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $elgb->dva }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $elgb->ut_audit == "Y" ? 'Yes' : '' }}
                                                                {{ $elgb->ut_audit == "N" ? 'No' : '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $elgb->ut_integrity == "Y" ? 'Yes' : '' }}
                                                                {{ $elgb->ut_integrity == "N" ? 'No' : '' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>2.3</b></th>
                                        <th style="width: 16%" class="pl-1">Application Fee Details</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="p-0 text-center">Whether fee has been paid ?</th>
                                                            <th class="p-0 text-center">Payment Date</th>
                                                            <th class="p-0 text-center">Unique Reference Number</th>
                                                            <th class="p-0 text-center">Bank Name</th>
                                                            <th class="p-0 text-center">Amount</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $fees->payment == "Y" ? 'Yes' : '' }}
                                                                {{ $fees->payment == "N" ? 'No' : '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $fees->date }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $fees->urn }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $fees->bank_name }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $fees->amount }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="card border-primary mt-2" id="financial">
                    <div class="card-header bg-gradient-info">
                        3. Financial Details
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th><b>3.1</b></th>
                                        <th style="width: 16%" class="pl-1">Financial Details (Self Certified)</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-40 text-center">Revenue <span class="pl-2 text-danger">(Rs. in INR)</span></th>
                                                            <th class="w-20 text-center">2017-18</th>
                                                            <th class="w-20 text-center">2018-19</th>
                                                            <th class="w-20 text-center">2019-20</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4" class="p-0">Sales from Pharmaceutical Operations</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Domestic</th>
                                                            <td class="text-center">{{ $fin->phar_dom_17 }}</td>
                                                            <td class="text-center">{{ $fin->phar_dom_18 }}</td>
                                                            <td class="text-center">{{ $fin->phar_dom_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Export</th>
                                                            <td class="text-center">{{ $fin->phar_exp_17 }}</td>
                                                            <td class="text-center">{{ $fin->phar_exp_18 }}</td>
                                                            <td class="text-center">{{ $fin->phar_exp_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4" class="p-0">Sales from other than Pharmaceutical Operations</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Domestic</th>
                                                            <td class="text-center">{{ $fin->oth_dom_17 }}</td>
                                                            <td class="text-center">{{ $fin->oth_dom_18 }}</td>
                                                            <td class="text-center">{{ $fin->oth_dom_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Export</th>
                                                            <td class="text-center">{{ $fin->oth_exp_17 }}</td>
                                                            <td class="text-center">{{ $fin->oth_exp_18 }}</td>
                                                            <td class="text-center">{{ $fin->oth_exp_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4">Other Income</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Other Income</th>
                                                            <td class="text-center">{{ $fin->oth_inc_17 }}</td>
                                                            <td class="text-center">{{ $fin->oth_inc_18 }}</td>
                                                            <td class="text-center">{{ $fin->oth_inc_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4">Total Revenue</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Total Revenue</th>
                                                            <td class="text-center">{{ $fin->tot_rev_17 }}</td>
                                                            <td class="text-center">{{ $fin->tot_rev_18 }}</td>
                                                            <td class="text-center">{{ $fin->tot_rev_19 }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b></b></th>
                                        <th style="width: 16%" class="pl-1">Profit Before Tax (PBT) and Profit After Tax (PAT)</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-40 text-center">Particulars</th>
                                                            <th class="w-20 text-center">2017-18</th>
                                                            <th class="w-20 text-center">2018-19</th>
                                                            <th class="w-20 text-center">2019-20</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Profit Before Tax</th>
                                                            <td class="text-center">{{ $fin->pbt17 }}</td>
                                                            <td class="text-center">{{ $fin->pbt18 }}</td>
                                                            <td class="text-center">{{ $fin->pbt19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Profit After Tax</th>
                                                            <td class="text-center">{{ $fin->pat17 }}</td>
                                                            <td class="text-center">{{ $fin->pat18 }}</td>
                                                            <td class="text-center">{{ $fin->pat19 }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b></b></th>
                                        <th style="width: 16%" class="pl-1">Capex & Source of Funds</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-40 text-center">Capex <span class="pl-2 text-danger">(Rs. in INR)</span></th>
                                                            <th class="w-20 text-center">2017-18</th>
                                                            <th class="w-20 text-center">2018-19</th>
                                                            <th class="w-20 text-center">2019-20</th>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4">Equity Capital</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Capex</th>
                                                            <td class="text-center">{{ $fin->cap_17 }}</td>
                                                            <td class="text-center">{{ $fin->cap_18 }}</td>
                                                            <td class="text-center">{{ $fin->cap_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Share Capital Issued</th>
                                                            <td class="text-center">{{ $fin->sh_cap_17 }}</td>
                                                            <td class="text-center">{{ $fin->sh_cap_18 }}</td>
                                                            <td class="text-center">{{ $fin->sh_cap_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">- Promoters</th>
                                                            <td class="text-center">{{ $fin->eq_prom_17 }}</td>
                                                            <td class="text-center">{{ $fin->eq_prom_18 }}</td>
                                                            <td class="text-center">{{ $fin->eq_prom_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">- Indian Govt.</th>
                                                            <td class="text-center">{{ $fin->eq_ind_17 }}</td>
                                                            <td class="text-center">{{ $fin->eq_ind_18 }}</td>
                                                            <td class="text-center">{{ $fin->eq_ind_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center"> - Foreign Govt.</th>
                                                            <td class="text-center">{{ $fin->eq_frn_17 }}</td>
                                                            <td class="text-center">{{ $fin->eq_frn_18 }}</td>
                                                            <td class="text-center">{{ $fin->eq_frn_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">- Multilateral Agencies</th>
                                                            <td class="text-center">{{ $fin->eq_mult_17 }}</td>
                                                            <td class="text-center">{{ $fin->eq_mult_18 }}</td>
                                                            <td class="text-center">{{ $fin->eq_mult_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center"> - Banks & Other institutions</th>
                                                            <td class="text-center">{{ $fin->eq_bank_17 }}</td>
                                                            <td class="text-center">{{ $fin->eq_bank_18 }}</td>
                                                            <td class="text-center">{{ $fin->eq_bank_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Internal Accruals</th>
                                                            <td class="text-center">{{ $fin->int_acc_17 }}</td>
                                                            <td class="text-center">{{ $fin->int_acc_18 }}</td>
                                                            <td class="text-center">{{ $fin->int_acc_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4">Loan Availed</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center"> Promoters</th>
                                                            <td class="text-center">{{ $fin->ln_prom_17 }}</td>
                                                            <td class="text-center">{{ $fin->ln_prom_18 }}</td>
                                                            <td class="text-center">{{ $fin->ln_prom_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center"> Indian Govt.</th>
                                                            <td class="text-center">{{ $fin->ln_ind_17 }}</td>
                                                            <td class="text-center">{{ $fin->ln_ind_18 }}</td>
                                                            <td class="text-center">{{ $fin->ln_ind_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">  Foreign Govt.</th>
                                                            <td class="text-center">{{ $fin->ln_frn_17 }}</td>
                                                            <td class="text-center">{{ $fin->ln_frn_18 }}</td>
                                                            <td class="text-center">{{ $fin->ln_frn_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center"> Multilateral Agencies</th>
                                                            <td class="text-center">{{ $fin->ln_mult_17 }}</td>
                                                            <td class="text-center">{{ $fin->ln_mult_18 }}</td>
                                                            <td class="text-center">{{ $fin->ln_mult_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center"> Banks & Other institutions</th>
                                                            <td class="text-center">{{ $fin->ln_bank_17 }}</td>
                                                            <td class="text-center">{{ $fin->ln_bank_18 }}</td>
                                                            <td class="text-center">{{ $fin->ln_bank_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="4">Grant / Any other assistance</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center"> Indian Govt.</th>
                                                            <td class="text-center">{{ $fin->gr_ind_17 }}</td>
                                                            <td class="text-center">{{ $fin->gr_ind_18 }}</td>
                                                            <td class="text-center">{{ $fin->gr_ind_19 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center"> Foreign Govt.</th>
                                                            <td class="text-center">{{ $fin->gr_frn_17 }}</td>
                                                            <td class="text-center">{{ $fin->gr_frn_18 }}</td>
                                                            <td class="text-center">{{ $fin->gr_frn_19 }}</td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>3.2</b></th>
                                        <th style="width: 16%" class="pl-1">Research and Development</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-20 text-center">Whether applicant has any in-house Research and Development Unit</th>
                                                            <th class="w-20 text-center">Whether in-house Research and Development Unit of the applicant is recognised by Ministry of Science & Technology</th>
                                                            <th class="w-20 text-center">Recent achievements of in-house R&D. (Please refer Clause C of point 2.8).</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $fin->rnd_unit == "Y" ? 'Yes' : '' }}
                                                                {{ $fin->rnd_unit == "N" ? 'No' : '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $fin->rnd_rcnz == "Y" ? 'Yes' : '' }}
                                                                {{ $fin->rnd_rcnz == "N" ? 'No' : '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $fin->rnd_achv == "Y" ? 'Yes' : '' }}
                                                                {{ $fin->rnd_achv == "N" ? 'No' : '' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr><tr>
                                        <th><b></b></th>
                                        <th style="width: 16%" class="pl-1">Investment made in Research and Development including Group Companies (which is capitalised in the books of account (INR)</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-20 text-center">2017-18</th>
                                                            <th class="w-20 text-center">2018-19</th>
                                                            <th class="w-20 text-center">2019-20</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $fin->rnd_inv_17 }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $fin->rnd_inv_18 }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $fin->rnd_inv_19 }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-primary mt-2" id="undertaking">
                    <div class="card-header bg-gradient-info">
                        4. Undertakings and Certificates
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th><b>4.1</b></th>
                                        <th style="width: 16%" class="pl-1">Undertakings and Certificates</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody class="doctbody">
                                                        <tr>
                                                            <th class="w-40 text-center">Letter of Authorization (Refer Clause 2.3 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('1', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '1')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('1', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '1')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="p-0">Certificate of Shareholding/ Ownership Pattern (Refer Clause 2.2 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('2', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '2')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('2', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '2')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Undertaking for Defaulter’s List/Bankruptcy (Refer clause 2.4 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('3', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '3')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('3', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '3')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Undertaking for Pending Legal or Financial Cases ( Refer clause…of the Scheme guidelines)</th>
                                                            @if(in_array('4', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '4')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('4', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '4')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Certificate of Net Worth Certificate (Refer Clause 2.6 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('5', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '5')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('5', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '5')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Undertaking for Consenting of Audit (Refer Clause 7.6.1 of the Scheme Guidelines)</th>
                                                            @if(in_array('6', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '6')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('6', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '6')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        {{-- <tr>
                                                            <th class="text-center">Undertaking for Domestic Sales (Refer Clause 7.6.2 of the Scheme Guidelines)</th>
                                                            @if(in_array('7', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '7')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('7', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '7')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr> --}}
                                                        <tr>
                                                            <th class="text-center">Integrity Pact (Refer Clause 17.7 of the Scheme Guidelines)</th>
                                                            @if(in_array('8', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '8')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('8', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '8')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>4.2</b></th>
                                        <th style="width: 16%" class="pl-1">Other Documents</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody class="doctbody">
                                                        <tr>
                                                            <th class="w-40 text-center">Business Profile (Refer clause 2.3 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('9', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '9')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('9', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '9')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="p-0">Memorandum & Articles of Association, Partnership Deed (Refer clause 2.2 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('10', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '10')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('10', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '10')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Certificate of Incorporation (Refer clause 2.2 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('11', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '11')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('11', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '11')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Copy of PAN (Refer clause 2.3 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('12', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '12')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('12', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '12')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Copy of GST Number (Refer clause 2.3 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('13', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '13')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('13', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '13')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">CIBIL Report of the applicant (Refer clause 2.4 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('14', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '14')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('14', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '14')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Profile of Chairman, CEO, Managing Director, KMP (Refer clause 2.3 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('15', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '15')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('15', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '15')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Self Certified copy of Annual Reports including Financial Report for FY 2017-18, FY 2018-19 and FY 2019-20 (Refer clause 2.3 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('16', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '16')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('16', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '16')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Detailed Project Report (Refer clause 3.3 of Annexure 1 of the Scheme Guidelines)</th>
                                                            @if(in_array('17', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '17')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('17', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '17')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">Recent achievements of in-house R&D</th>
                                                            @if(in_array('18', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '18')
                                                                <td><a href="{{$doc}}" download="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('18', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '18')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">FY 2017-18</th>
                                                            @if(in_array('19', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '19')
                                                                <td><a href="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('19', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '19')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">FY 2018-19</th>
                                                            @if(in_array('20', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '20')
                                                                <td><a href="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('20', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '20')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">FY 2019-20</th>
                                                            @if(in_array('21', $docids))
                                                                @foreach($docs as $key=>$doc)
                                                                @if($key == '21')
                                                                <td><a href="{{$doc}}" target="_blank"
                                                                    class="btn btn-success btn-sm float-centre">
                                                                    View</a>
                                                                </td>
                                                                @endif
                                                                @endforeach
                                                            @else
                                                                <td>
                                                                    <i class="fas fa-times-circle text-danger"></i>
                                                                </td>
                                                            @endif
                                                            @if(in_array('21', $docids))
                                                            @foreach($docRem as $key=>$docRe)
                                                            @if($key == '21')
                                                                <td>
                                                                    {{ $docRe }}
                                                                </td>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-primary mt-2" id="proposal">
                    <div class="card-header bg-gradient-info">
                        5. Proposal Details
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th><b>5.1</b></th>
                                        <th style="width: 16%" class="pl-1">Project Details</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-40 text-center">Address of the proposed Manufacturing Facility of Eligible Product applied for</th>
                                                            <th class="w-20 text-center">Whether applicant is already manufacturing any pharmaceutical product at the proposed manufacturing facility (please give details)</th>
                                                            <th class="w-20 text-center">Address of the existing proposed Manufacturing Facility of KSMs/DIs, if any which are proposed to be utilised for the manufacturing of eligible product (Refer clause 7.5 of the scheme guidelines)</th>
                                                            <th class="w-20 text-center">Scheduled Date of Commercial Production</th>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">{{ $propDet->prop_man_add }}</td>
                                                            <td class="text-center">{{ $propDet->prop_man_det }}</td>
                                                            <td class="text-center">{{ $propDet->exst_man_add }}</td>
                                                            <td class="text-center">{{ $propDet->prod_date }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>5.2</b></th>
                                        <th style="width: 16%" class="pl-1">Detailed Project Report</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-40 text-center">Key Information</th>
                                                            <th class="w-20 text-center">Whether Information Provided</th>
                                                            <th class="w-20 text-center">Reference to section or Page Number in DPR</th>
                                                            <th class="w-20 text-center">Remarks</th>
                                                        </tr>

                                                        <tr>
                                                            @foreach($proj_prt as $val)
                                                            @foreach($projDet as $det)
                                                            @if($det->prt_id == $val->id)
                                                            <tr>
                                                                <td class="text-center">{{ $val->name }}</td>
                                                                <td>
                                                                    {{ $det->info_prov == "Y" ? 'Yes' : '' }}
                                                                    {{ $det->info_prov == "N" ? 'No' : '' }}
                                                                </td>
                                                                <td>
                                                                    {{ $det->dpr_ref }}
                                                                </td>
                                                                <td>
                                                                    {{ $det->remarks }}
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            @endforeach
                                                            @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-primary mt-2" id="projection">
                    <div class="card-header bg-gradient-info">
                        6. Projections- Eligible Product
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th><b>6.1</b></th>
                                        <th style="width: 16%" class="pl-1">Revenue (₹ in INR)</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-40 text-center">Particulars (₹ in INR)</th>
                                                            <th class="w-20 text-center">FY 2020-21</th>
                                                            <th class="w-20 text-center">FY 2021-22</th>
                                                            <th class="w-20 text-center">FY 2022-23</th>
                                                            <th class="w-20 text-center">FY 2023-24</th>
                                                            <th class="w-20 text-center">FY 2024-25</th>
                                                            <th class="w-20 text-center">FY 2025-26</th>
                                                            <th class="w-20 text-center">FY 2026-27</th>
                                                            <th class="w-20 text-center">FY 2027-28</th>
                                                            <th class="w-20 text-center">FY 2028-29</th>
                                                        </tr>

                                                        <tr>
                                                            <th>Export Sales</th>
                                                            <td class="text-center">{{ $rev->expfy20 }}</td>
                                                            <td class="text-center">{{ $rev->expfy21 }}</td>
                                                            <td class="text-center">{{ $rev->expfy22 }}</td>
                                                            <td class="text-center">{{ $rev->expfy23 }}</td>
                                                            <td class="text-center">{{ $rev->expfy24 }}</td>
                                                            <td class="text-center">{{ $rev->expfy25 }}</td>
                                                            <td class="text-center">{{ $rev->expfy26 }}</td>
                                                            <td class="text-center">{{ $rev->expfy27 }}</td>
                                                            <td class="text-center">{{ $rev->expfy28 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Domestic Sales</th>
                                                            <td class="text-center">{{ $rev->domfy20 }}</td>
                                                            <td class="text-center">{{ $rev->domfy21 }}</td>
                                                            <td class="text-center">{{ $rev->domfy22}}</td>
                                                            <td class="text-center">{{ $rev->domfy23 }}</td>
                                                            <td class="text-center">{{ $rev->domfy24 }}</td>
                                                            <td class="text-center">{{ $rev->domfy25 }}</td>
                                                            <td class="text-center">{{ $rev->domfy26 }}</td>
                                                            <td class="text-center">{{ $rev->domfy27 }}</td>
                                                            <td class="text-center">{{ $rev->domfy28 }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>6.2</b></th>
                                        <th style="width: 16%" class="pl-1">Employment Generation (Nos.)</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-40 text-center">Particulars (Nos.)</th>
                                                            <th class="w-20 text-center">FY 2020-21</th>
                                                            <th class="w-20 text-center">FY 2021-22</th>
                                                            <th class="w-20 text-center">FY 2022-23</th>
                                                            <th class="w-20 text-center">FY 2023-24</th>
                                                            <th class="w-20 text-center">FY 2024-25</th>
                                                            <th class="w-20 text-center">FY 2025-26</th>
                                                            <th class="w-20 text-center">FY 2026-27</th>
                                                            <th class="w-20 text-center">FY 2027-28</th>
                                                            <th class="w-20 text-center">FY 2028-29</th>
                                                        </tr>

                                                        <tr>
                                                            <th>Cumulative Employee Base</th>
                                                            <td class="text-center">{{ $emp->fy20 }}</td>
                                                            <td class="text-center">{{ $emp->fy21 }}</td>
                                                            <td class="text-center">{{ $emp->fy22 }}</td>
                                                            <td class="text-center">{{ $emp->fy23 }}</td>
                                                            <td class="text-center">{{ $emp->fy24 }}</td>
                                                            <td class="text-center">{{ $emp->fy25 }}</td>
                                                            <td class="text-center">{{ $emp->fy26 }}</td>
                                                            <td class="text-center">{{ $emp->fy27 }}</td>
                                                            <td class="text-center">{{ $emp->fy28 }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-primary mt-2" id="dva">
                    <div class="card-header bg-gradient-info">
                        7. Domestic Value Addition (DVA)
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th><b>7.1</b></th>
                                        <th style="width: 16%" class="pl-1">Key Raw Material</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-40 text-center">Key Parameters</th>
                                                            <th class="w-20 text-center">Country of Origin</th>
                                                            <th class="w-20 text-center">Manufacturers in India</th>
                                                            <th class="w-20 text-center">Amount ₹</th>
                                                        </tr>
                                                            @foreach($krms as $key => $value)
                                                            <tr>
                                                                <td>
                                                                    {{ $value->name }}
                                                                </td>
                                                                <td>
                                                                    {{ $value->coo }}
                                                                </td>
                                                                <td>
                                                                    {{ $value->man }}
                                                                </td>
                                                                <td>
                                                                    {{ $value->amt }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b></b></th>
                                        <td colspan="2" style="padding: 0;">
                                            <table style="margin: 0; width: 100%;">
                                                <tbody>
                                                    <tr>
                                                    <th>
                                                        Salary Expenses
                                                    </th>
                                                    <th>
                                                        Other Expenses
                                                    </th>
                                                    <th>
                                                        Services non-originating in India
                                                    </th>
                                                    <th>
                                                        Total Cost
                                                    </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">
                                                            {{ $dvas->sal_exp }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $dvas->oth_exp }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $dvas->non_orig }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $dvas->tot_cost }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b></b></th>
                                        <th colspan="2">Out of Total cost above</th>
                                    </tr>
                                    <tr>
                                        <th><b></b></th>
                                        <td colspan="2" style="padding: 0;">
                                            <table style="margin: 0; width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            Non-Originating Raw Material
                                                        </th>
                                                        <th>
                                                            Non-Originating Services
                                                        </th>
                                                        <th>
                                                            Total (A)
                                                        </th>
                                                        <th>
                                                            Estimated Sales Revenue (B)
                                                        </th>
                                                        <th>
                                                            Domestic Value Addition % (B-A)/(B)
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">{{ $dvas->non_orig_raw }}</td>
                                                        <td class="text-center">{{ $dvas->non_orig_srv }}</td>
                                                        <td class="text-center">{{ $dvas->tot_a }}</td>
                                                        <td class="text-center">{{ $dvas->sales_rev }}</td>
                                                        <td class="text-center">{{ $dvas->dva }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b></b></th>
                                        <th>Managing Director/ Designated Partner/ Managing Partner/ Proprietor</th>
                                        <td style="padding: 0;">
                                            <table style="margin: 0; width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            Name
                                                        </th>
                                                        <th>
                                                            Designation
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $dvas->man_dir }}</td>
                                                        <td>{{ $dvas->man_desig }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card border-primary mt-2" id="evaluation">
                    <div class="card-header bg-gradient-info">
                        8. Evaluation Criteria
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th><b>8.1</b></th>
                                        <th style="width: 16%" class="pl-1">Criteria</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-60 text-center">Criteria</th>
                                                            <th class="w-20 text-center">Weightage</th>
                                                            <th class="w-20 text-center">Quote by Applicant</th>
                                                        </tr>

                                                            <tr>
                                                                <td>
                                                                    Committed Annual Production capacity (in multiple of whole nos. of
                                                minimum annual production capacity for each eligible product, as given
                                                in Appendix B of the Scheme Guidelines)
                                                                </td>
                                                                <td>
                                                                    35
                                                                </td>
                                                                <td>
                                                                    {{ $evalDet->capacity }}
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Quoted Sale Price of Eligible Product (₹ per kg)
                                                                </td>
                                                                <td>
                                                                    65
                                                                </td>
                                                                <td>
                                                                    {{ $evalDet->price }}
                                                                </td>

                                                            </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>8.2</b></th>
                                        <th style="width: 16%" class="pl-1">Proposed Investment</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-60 text-center">Investment Committed (in multiple of whole nos. of threshold investment, as given in Appendix B of the Scheme Guidelines) Refer Clause 7.4 of the Guidelines <span class="help-text">(₹ in crore )</span></th>
                                                            <td class="w-40 text-center">{{ $evalDet->investment }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>8.3</b></th>
                                        <th style="width: 16%" class="pl-1">Major heads of Proposed Investment</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-60 text-center">Major Heads</th>
                                                            <th class="w-20 text-center">(₹ in crore )</th>
                                                        </tr>
                                                        @foreach($inv_prt as $val)
                                                        @foreach($invDet as $det)
                                                        @if($det->prt_id == $val->id)
                                                        <tr>
                                                            <td>{{ $val->name }}</td>
                                                            <td>
                                                                {{ $det->amt }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>8.4</b></th>
                                        <th style="width: 16%" class="pl-1">Source of Fund</th>
                                        <td style="width: 83%" class="p-0">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th class="w-60 text-center">Particulars</th>
                                                            <th class="w-20 text-center">Promoters</th>
                                                            <th class="w-20 text-center">Banks/FI</th>
                                                            <th class="w-20 text-center">Others</th>
                                                        </tr>
                                                        @foreach($fund_prt as $val)
                                                        @foreach($fundDet as $det)
                                                        @if($det->prt_id == $val->id)
                                                        <tr>
                                                            <td>{{ $val->name }}</td>
                                                            <td>
                                                                {{ $det->prom }}
                                                            </td>
                                                            <td>
                                                               {{ $det->banks }}
                                                            </td>
                                                            <td>
                                                               {{ $det->others }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
        <div class="row pb-2">
            <div class="col-md-2 offset-md-4 ">
                <div onclick="printPage();" class="btn btn-warning btn-sm form-control form-control-sm">Print <i class="fas fa-print"></i> </div>
            </div>

             <div class="col-md-2 offset-md-3">
                    <a href="{{ route('app.submit',$appMast->id) }}" id="finalSubmit"
                        class="btn btn-danger btn-sm form-control form-control-sm" @if($appMast->status != 'D') disabled @endif
                        ><i class="fas fa-save"></i> Submit</a>
                </div>
        </div>
    </div>
</div>


@endsection



@push('styles')
<style>
    th {
        text-align: center;
    }

    .doctbody tr td{
        text-align: center;
        padding:5px !important;
    }

    .doctbody tr th:nth-child(1){
        width: 60% !important;
    }

    .doctbody tr td:nth-child(3){
        width: 35% !important;
    }
</style>
@endpush
@push('scripts')
<script>
    function printPage() {
    var div0ToPrint = document.getElementById('company');
    var div1ToPrint = document.getElementById('eligibility');
    var div2ToPrint = document.getElementById('financial');
    var div7ToPrint = document.getElementById('undertaking');
    var div3ToPrint = document.getElementById('proposal');
    var div4ToPrint = document.getElementById('projection');
    var div5ToPrint = document.getElementById('dva');
    var div6ToPrint = document.getElementById('evaluation');
    
    
    
    var newWin = window.open('PLI Bulk Drugs', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><head>PLI Bulk Drugs<title> PLI Bulk Drugs Application Preview </title>');
    newWin.document.write('<link href="{{ asset("css/app.css") }}" rel="stylesheet">');
    newWin.document.write('<link href="{{ asset("css/app/preview.css") }}" rel="stylesheet">');
    newWin.document.write(
    '<style>@media print { .pagebreak { clear: both; page-break-before: always; } }</style>');
    newWin.document.write('</head><body onload="window.print()">');
    newWin.document.write(div0ToPrint.innerHTML);
    newWin.document.write('<div class="pagebreak"></div>');
    newWin.document.write(div1ToPrint.innerHTML);
    newWin.document.write('<div class="pagebreak"></div>');
    newWin.document.write(div2ToPrint.innerHTML);
    newWin.document.write('<div class="pagebreak"></div>');
    newWin.document.write(div3ToPrint.innerHTML);
    newWin.document.write('<div class="pagebreak"></div>');
    newWin.document.write(div4ToPrint.innerHTML);
    newWin.document.write('<div class="pagebreak"></div>');
    newWin.document.write(div5ToPrint.innerHTML);
    newWin.document.write('<div class="pagebreak"></div>');
    newWin.document.write(div6ToPrint.innerHTML);
    newWin.document.write('<div class="pagebreak"></div>');
    newWin.document.write(div7ToPrint.innerHTML);
    newWin.document.write('<div class="pagebreak"></div>');
    
    newWin.document.close();
    };

    $(document).ready(function () {
        $("#finalSubmit").click(function (event) {
            console.log("Hello");
            event.preventDefault();
            var link = $(this).attr('href');
            swal({
                    title: "No Change is allowed in Committed Capacity, Quoted Price and Committed Investment. Are you sure to submit the form?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    closeOnClickOutside: false,
                })
                .then((value) => {
                    if (value) {
                        window.location.href = link;
                    }
                });
        });
    });
</script>
@endpush