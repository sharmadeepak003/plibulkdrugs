@extends('layouts.user.dashboard-master')

@section('title')
Section 3 - Financial Details
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
        <form action={{ route('financials.store') }} id="form-create" role="form" method="post" class='form-horizontal'
            files=true enctype='multipart/form-data' accept-charset="utf-8">
            @csrf
            <input type="hidden" id="app_id" name="app_id" value="{{ $appMast->id }}">
            <small class="text-danger">(All fields are mandatory)</small>

            <div class="card border-primary">
                <div class="card-header bg-gradient-info">
                    <b>3.1 Financial Details (Self Certified)</b>
                </div>
                <div class="card-body py-0 px-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive p-0 m-0">
                                <table class="table table-sm table-bordered table-hover financialTable">
                                    <thead>
                                        <tr>
                                            <th colspan="4">
                                                <b>Instructions :-</b>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="text-danger" colspan="4">
                                                <span class="help-text">
                                                    <ol type="1">
                                                        <li>For FY 2017-18 and FY 2018-19, provide information based on
                                                            the audited financial statements. For FY 2019-20, financial
                                                            details may be provide based on provisional financials.
                                                        </li>
                                                        <li>In case of any entity incorporated after March 31, 2018;
                                                            financial details for the year in which applicant was not in
                                                            existence is not required.
                                                        </li>
                                                        <li>Provide financial statement for last three years FY 2017-18,
                                                            FY 2018-19 and FY 2019-20. Unaudited financials for FY
                                                            2019-20 may be provided, if audited are not available.
                                                        </li>
                                                    </ol>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <th class="w-40 text-center">Revenue <span class="pl-2 text-danger">(Rs. in INR)</span></th>
                                            <th class="w-20 text-center">2017-18</th>
                                            <th class="w-20 text-center">2018-19</th>
                                            <th class="w-20 text-center">2019-20</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="p-0 m-0">Sales from Pharmaceutical Operations</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Domestic</td>
                                            <td><input type="number" name="phar_dom_17" id="phar_dom_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="phar_dom_18" id="phar_dom_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="phar_dom_19" id="phar_dom_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>Export</td>
                                            <td><input type="number" name="phar_exp_17" id="phar_exp_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="phar_exp_18" id="phar_exp_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="phar_exp_19" id="phar_exp_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <th class="p-0 m-0">Sales from other than Pharmaceutical Operations</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Domestic</td>
                                            <td><input type="number" name="oth_dom_17" id="oth_dom_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="oth_dom_18" id="oth_dom_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="oth_dom_19" id="oth_dom_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>Domestic</td>
                                            <td><input type="number" name="oth_exp_17" id="oth_exp_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="oth_exp_18" id="oth_exp_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="oth_exp_19" id="oth_exp_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <th class="p-0 m-0">Other Income</th>
                                            <td><input type="number" name="oth_inc_17" id="oth_inc_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="oth_inc_18" id="oth_inc_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="oth_inc_19" id="oth_inc_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <th class="p-0 m-0"> Total Revenue</th>
                                            <td><input type="number" name="tot_rev_17" id="tot_rev_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="tot_rev_18" id="tot_rev_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="tot_rev_19" id="tot_rev_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <span class="help-text">
                                    <ol type="1">
                                        <li>Sales from Pharmaceutical Operations should include revenue from trading/
                                            manufacturing of all products in the pharmaceutical sector. Other Sales may
                                            be shown separately
                                        </li>
                                        <li>Total Revenue given above should match with the revenue as per Profit & Loss
                                            A/c.
                                        </li>
                                    </ol>
                                </span>
                            </div>
                            <div class="table-responsive p-0 m-0">
                                <table class="table table-sm table-bordered table-hover financialTable">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="table-primary text-center bg-gradient-info">
                                                Profit Before Tax (PBT) and Profit After Tax (PAT)
                                            </th>
                                        </tr>
                                        <tr class="table-primary">
                                            <th class="w-40 text-center">Particulars <span class="pl-2 text-danger">(Rs. in INR)</span></th>
                                            <th class="w-20 text-center">2017-18</th>
                                            <th class="w-20 text-center">2018-19</th>
                                            <th class="w-20 text-center">2019-20</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Profit Before Tax</th>
                                            <td><input type="number" name="pbt17" id="pbt17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="pbt18" id="pbt18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="pbt19" id="pbt19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <th>Profit After Tax</th>
                                            <td><input type="number" name="pat17" id="pat17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="pat18" id="pat18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="pat19" id="pat19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive p-0 m-0">
                                <table class="table table-sm table-bordered table-hover financialTable">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="table-primary text-center bg-gradient-info">
                                                Capex & Source of Funds
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-danger">
                                                <span class="help-text">
                                                <ol type="i">
                                                    <li>Provide detail of capex undertaken in the last three years and
                                                        source of funds for the capex giving separate detail of Equity,
                                                        Loan and Grant (if any)
                                                    </li>
                                                </ol>
                                            </span>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <th class="w-40 text-center">Capex <span class="pl-2 text-danger">(Rs. in INR)</span></th>
                                            <th class="w-20 text-center">2017-18</th>
                                            <th class="w-20 text-center">2018-19</th>
                                            <th class="w-20 text-center">2019-20</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>(i)  Capex</td>
                                            <td><input type="number" name="cap_17" id="cap_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="cap_18" id="cap_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="cap_19" id="cap_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>

                                        <tr>
                                            <td>(ii) Source of Funds</td>
                                            <td><input type="number" name="sof_17" id="sof_17"
                                                    class="form-control form-control-sm" readonly></td>
                                            <td><input type="number" name="sof_18" id="sof_18"
                                                    class="form-control form-control-sm" readonly></td>
                                            <td><input type="number" name="sof_19" id="sof_19"
                                                    class="form-control form-control-sm" readonly></td>
                                        </tr>
                                        <tr>
                                            <th class="p-0 m-0">Equity Capital</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Share Capital Issued</td>
                                            <td><input type="number" name="sh_cap_17" id="sh_cap_17"
                                                    class="form-control form-control-sm" readonly></td>
                                            <td><input type="number" name="sh_cap_18" id="sh_cap_18"
                                                    class="form-control form-control-sm" readonly></td>
                                            <td><input type="number" name="sh_cap_19" id="sh_cap_19"
                                                    class="form-control form-control-sm" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;- Promoters</td>
                                            <td><input type="number" name="eq_prom_17" id="eq_prom_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_prom_18" id="eq_prom_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_prom_19" id="eq_prom_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;- Indian Govt.</td>
                                            <td><input type="number" name="eq_ind_17" id="eq_ind_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_ind_18" id="eq_ind_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_ind_19" id="eq_ind_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;- Foreign Govt.</td>
                                            <td><input type="number" name="eq_frn_17" id="eq_frn_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_frn_18" id="eq_frn_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_frn_19" id="eq_frn_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;- Multilateral Agencies</td>
                                            <td><input type="number" name="eq_mult_17" id="eq_mult_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_mult_18" id="eq_mult_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_mult_19" id="eq_mult_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;- Banks & Other institutions</td>
                                            <td><input type="number" name="eq_bank_17" id="eq_bank_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_bank_18" id="eq_bank_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="eq_bank_19" id="eq_bank_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>Internal Accruals</td>
                                            <td><input type="number" name="int_acc_17" id="int_acc_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="int_acc_18" id="int_acc_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="int_acc_19" id="int_acc_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <th class="p-0 m-0">Loan Availed</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Promoters</td>
                                            <td><input type="number" name="ln_prom_17" id="ln_prom_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_prom_18" id="ln_prom_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_prom_19" id="ln_prom_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>Indian Govt.</td>
                                            <td><input type="number" name="ln_ind_17" id="ln_ind_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_ind_18" id="ln_ind_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_ind_19" id="ln_ind_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>Foreign Govt.</td>
                                            <td><input type="number" name="ln_frn_17" id="ln_frn_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_frn_18" id="ln_frn_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_frn_19" id="ln_frn_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>Multilateral Agencies</td>
                                            <td><input type="number" name="ln_mult_17" id="ln_mult_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_mult_18" id="ln_mult_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_mult_19" id="ln_mult_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>Banks & Other institutions</td>
                                            <td><input type="number" name="ln_bank_17" id="ln_bank_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_bank_18" id="ln_bank_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="ln_bank_19" id="ln_bank_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <th class="p-0 m-0">Grant / Any other assistance</th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Indian Govt.</td>
                                            <td><input type="number" name="gr_ind_17" id="gr_ind_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="gr_ind_18" id="gr_ind_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="gr_ind_19" id="gr_ind_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <td>Foreign Govt.</td>
                                            <td><input type="number" name="gr_frn_17" id="gr_frn_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="gr_frn_18" id="gr_frn_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="gr_frn_19" id="gr_frn_19"
                                                    class="form-control form-control-sm"></td>
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
                    <b>3.2 Research and Development</b>
                </div>
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive rounded p-0 m-0">
                                <table class="table table-bordered table-hover table-sm">
                                    <tbody>
                                        <tr>
                                            <th class="w-40 p-1" colspan="2">
                                                Whether applicant has any in-house Research and Development Unit
                                            </th>
                                            <td class="w-20" colspan="2">
                                                <select id="rnd_unit" name="rnd_unit"
                                                    class="form-control form-control-sm">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="w-40 p-1" colspan="2">
                                                Whether in-house Research and Development Unit of the applicant is
                                                recognised by Ministry of Science & Technology</th>
                                            <td class="w-20" colspan="2">
                                                <select id="rnd_rcnz" name="rnd_rcnz"
                                                    class="form-control form-control-sm">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="table-primary">
                                            <th class="w-40 text-center"></th>
                                            <th class="w-20 text-center">2017-18</th>
                                            <th class="w-20 text-center">2018-19</th>
                                            <th class="w-20 text-center">2019-20</th>
                                        </tr>
                                        <tr>
                                            <td>Investment made in Research and Development including Group Companies (which is capitalised in the books of account  (INR)</td>
                                            <td><input type="number" name="rnd_inv_17" id="rnd_inv_17"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="rnd_inv_18" id="rnd_inv_18"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="rnd_inv_19" id="rnd_inv_19"
                                                    class="form-control form-control-sm"></td>
                                        </tr>
                                        <tr>
                                            <th class="w-40 p-1" colspan="2">
                                                Recent achievements of in-house R&D. (Please refer Clause C of point 2.8).</th>
                                            <td class="w-20" colspan="2">
                                                <select id="rnd_achv" name="rnd_achv"
                                                    class="form-control form-control-sm">
                                                    <option value="" selected="selected">Please choose..</option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-danger">
                                                <span class="help-text">Provide complete details of such achievement and
                                                    recognitions as Annexure.
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row pb-2">
                <div class="col-md-2 offset-md-5">
                    <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm"><i
                            class="fas fa-save"></i>
                        Save as Draft</button>
                </div>
                <div class="col-md-2 offset-md-3">
                    <a href="{{ route('undertakings.create',$appMast->id) }}"
                        class="btn btn-warning btn-sm form-control form-control-sm"><i
                            class="fas fa-angle-double-right"></i> Undertakings </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
@include('user.partials.js.financials')
{!! JsValidator::formRequest('App\Http\Requests\FinancialStore','#form-create') !!}
@endpush
