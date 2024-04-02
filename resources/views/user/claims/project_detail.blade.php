@extends('layouts.user.dashboard-master')

@section('title')
    Claim :Project Details
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
    <style>
        input[type="file"]{
            padding:1px;
        }
        input[type="select"] {
            width:10px;
        }
    </style>
@endpush

@section('content')
    <div class="container  py-4 px-2 col-lg-12">
        <div class="row justify-content-center">
            <div class="col-md-12">
              
                <form action="{{ route('claimprojectdetail.store') }}" id="project-details" role="form" method="post"
                    class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                    <input type="hidden" name="claim_id" id="claim_id" value="{{ $id }}">
                    <input type="hidden" name="app_id" id="app_id" value="{{ $claimMast->app_id}}">
                    @csrf
                    <div class="card border-primary">
                        <div class="card-header bg-gradient-info">
                            <b>Project Details</b>
                        </div>
                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-left">5.1 Whether Investment claimed as eligible under PLI Scheme includes any asset taken on lease.</th>
                                        <td>
                                            <input type="hidden" name="question[problem_file]" id="question_1" value="9">
                                            <select id="problem" name="problem[problem_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display m-2 py-10" style="display:none;">
                           <div>
                                <span style="float:right; padding:5px;">  <input type="file" name="problem_file" class="form-control form-control-sm text-center"></span>
                           </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name of lease</th>
                                            <th class="text-center">Asset Description</th>
                                            <th class="text-center">Amount (₹)</th>
                                            <th class="text-center"><button type="button" name="add" id="add"
                                                    class="btn btn-success btn-sm">Add More</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp
                                        <td class="text-center">{{ $sn++ }}</td>
                                        <td class="text-center"><input type="text" name="pendingdispute_ques[0][nature_of_lease]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="text" name="pendingdispute_ques[0][asset_description]" id="name"
                                            class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques[0][amt]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left" >5.2 Whether Investment claimed as eligible under PLI Scheme includes any expenses on R&D and technical know how.</th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem2_file]" id="question_2" value="10">
                                            <select id="problem2" name="problem[problem2_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display2 m-2 py-10" style="display:none;">
                            <div>
                            <span style="float:right; padding:5px;"><input type="file" name="problem2_file" class="form-control form-control-sm text-center"></span>
                           </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related2">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Particular</th>
                                            <th class="text-center">Amount (₹ in crore)</th>
                                            <th class="text-center"><button type="button" name="add2" id="add2"
                                                    class="btn btn-success btn-sm">Add More</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @php
                                            $sn = 1;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $sn++ }}</td>
                                            <th><input type="text" name="pendingdispute_ques2[0][quest_particular]" value="R & D Expense" class="form-control form-control-sm name_list1" readonly></th>
                                
                                            <td class="text-center"><input type="number" name="pendingdispute_ques2[0][amt]" id="name"
                                                    class="form-control form-control-sm name_list1 add_rd add_pt_data"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">{{ $sn++ }}</td>
                                            <th><input type="text" name="pendingdispute_ques2[1][quest_particular]" value="Transfer of Technology" class="form-control form-control-sm name_list1" readonly></th>
                                            <td class="text-center"><input type="number" name="pendingdispute_ques2[1][amt]" id="name"
                                                    class="form-control form-control-sm name_list1 add_rd add_pt_data"></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <th colspan="2" class="text-center">Total</th>
                                        <td class="text-center"><input type="number" name="tot" id="name"
                                                class="form-control form-control-sm name_list1 tot_add_rd" readonly></td>
                                        <td></td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-left" >5.3 Whether P&M include any used or refurbished plant & machinery. </th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem4_file]" id="question_4" value="12">
                                            <select id="problem4" name="problem[problem4_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                       
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display4 m-2 py-10" style="display:none;">
                            <div>
                                <span style="float:right; padding:5px;"><input type="file" name="problem4_file" class="form-control form-control-sm text-center"></span>
                               </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related4">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Type of P & M</th>
                                            <th class="text-center">Imported/Demostic</th>
                                            <th class="text-center">Residual Life</th>
                                            <th class="text-center">Capitalized Value(₹)</th>
                                            <th class="text-center">Value by CE(₹)</th>
                                            <th class="text-center">Value as per custom rules(₹)</th>
                                            <th class="text-center">Considered in eligibility criteria(₹)</th>
                                            <th class="text-center"><button type="button" name="add4" id="add4"
                                                    class="btn btn-success btn-sm">Add More</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp
                                        <td class="text-center">{{ $sn++ }}</td>
                    
                                        <td class="text-center"><input type="text" name="pendingdispute_ques4[0][type_pm]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="text" name="pendingdispute_ques4[0][impot_dom]" id="name"
                                            class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques4[0][residual_life]" id="name"
                                            class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques4[0][capitalized_value]" id="name"
                                            class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques4[0][value_by_ce]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques4[0][value_custom_rule]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques4[0][eligibilty_criteria]" id="name"
                                        class="form-control form-control-sm name_list1"></td>
                                        <td></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left" >5.4 Is there is any Associated Utility as defined under clause 2.21.1 of Scheme Guidelines. </th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem5_file]" id="question_5" value="13">
                                            <select id="problem5" name="problem[problem5_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display5 m-2 py-10" style="display:none;">
                            <div>
                                <span style="float:right; padding:5px;"><input type="file" name="problem5_file" class="form-control form-control-sm text-center"></span>
                               </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related5">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Nature of Utility</th>
                                            <th class="text-center">Intended Use</th>
                                            <th class="text-center">Amount Considered for Scheme(₹ in crore)</th>
                                            <th class="text-center"><button type="button" name="add5" id="add5"
                                                    class="btn btn-success btn-sm">Add More</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp
                                        <td class="text-center">{{ $sn++ }}</td>
                    
                                        <td class="text-center"><input type="text" name="pendingdispute_ques5[0][nature_of_utility]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques5[0][intended_use]" id="name"
                                            class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques5[0][amt]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left" >5.5 Whether investment considered under this PLI scheme has been considered for eligibility under any other PLI Scheme.</th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem6_file]" id="question_6" value="14">
                                            <select id="problem6" name="problem[problem6_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                       
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display6 m-2 py-10" style="display:none;">
                            <div>
                                <span style="float:right; padding:5px;"><input type="file" name="problem6_file" class="form-control form-control-sm text-center"></span>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related6">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name of PLI Scheme</th>
                                            <th class="text-center">Amount Considered(₹ in crore)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">1.</td>
                                        <td class="text-center"><input type="text" name="pendingdispute_ques6[0][name_of_pli_scheme]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques6[0][amt]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-left" >5.6 Whether any Assets discarded during the year include any Assets considered for eligibility in current financial year or any previous year.</th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem7_file]" id="question_7" value="15">
                                            <select id="problem7" name="problem[problem7_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                        
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display7 m-2 py-10" style="display:none;">
                            <div>
                                <span style="float:right; padding:5px;"><input type="file" name="problem7_file" class="form-control form-control-sm text-center"></span>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related7">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Nature of Assets</th>
                                            <th class="text-center">Amount Gross Value(₹ in crore)</th>
                                            <th class="text-center">Year When considered for eligibilty</th>
                                            <th class="text-center">Reason of discard</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">1.</td>
                                        <td class="text-center"><input type="text" name="pendingdispute_ques7[0][nature_of_asset]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques7[0][amt]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="text" name="pendingdispute_ques7[0][year_dt]" id="name"
                                        class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="text" name="pendingdispute_ques7[0][reason_of_discard]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th  class="text-left" >5.7 Please confirm that all Assets capitalized and claimed as eligible are being used/shall be used in the process of design, manufcaturing,<br> assembly, testing, packaging or processing of any of the eligible products covered under Target Segment.</th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem8_file]" id="question_8" value="16">
                                            <select id="problem8" name="problem[problem8_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card border-primary display8 m-2 py-10" style="display:none;">
                            <div>
                                <span style="float:right; padding:5px;"> <input type="file" name="problem8_file" class="form-control form-control-sm text-center"></span>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related8">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Nature of Assets</th>
                                            <th class="text-center">Amount Gross Value(₹ in crore)</th>
                                            
                                            <th class="text-center">Nature of Use</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td class="text-center">1.</td>
                                        <td class="text-center"><input type="text" name="pendingdispute_ques8[0][nature_of_asset]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        <td class="text-center"><input type="number" name="pendingdispute_ques8[0][amt]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                        
                                        <td class="text-center"><input type="text" name="pendingdispute_ques8[0][nature_of_use]" id="name"
                                                class="form-control form-control-sm name_list1"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left" >5.8 Please confirm whether assets capitalized and claimed during the year include any amount for which invoice date is prior to <br> 01/04/2020. If yes, provide details.</th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem9_file]" id="question_9" value="17">
                                            <select id="problem9" name="problem[problem9_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="card border-primary display9 m-2 py-10" style="display:none;">
                            
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related9">
                                  <thead>
                                    <tr class="table-primary">
                                        <th>S.No</th>
                                        <th>Upload File</th>
                                    </tr>
                                  </thead>
                                    <tbody>
                                        <td>1</td>
                                        <td><input type="file" name="problem9_file" class="form-control form-control-sm text-center"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left" >5.9 Whether amount capitalized and claimed eligible under PLI Scheme include expenses other than purchase price, <br>non-creditable duties & taxes, expense on freight/transport, packaging, insurance and expenditure on erection and commissioning of plant, machinery.</th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem10_file]" id="question_10" value="18">
                                            <select id="problem10" name="problem[problem10_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                       
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="card border-primary display10 m-2 py-10" style="display:none;">
                            
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related10">
                                  <thead>
                                    <tr class="table-primary">
                                        <th>S.No</th>
                                        <th>Upload File</th>
                                    </tr>
                                  </thead>
                                    <tbody>
                                        <td>1</td>
                                        <td><input type="file" name="problem10_file" class="form-control form-control-sm text-center"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-left" >5.10 Whether all approvals required to set-up Greenfield Project for manufacutring of eligible products has been received. If no please provide details</th>
                                        <td class="text-center">
                                            <input type="hidden" name="question[problem11_file]" id="question_11" value="19">
                                            <select id="problem11" name="problem[problem11_file]"
                                                class="form-control form-control-sm text-center">
                                                <option selected value="" disabled>Select</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </td>
                                        <td>
                                           
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="card border-primary display11 m-2 py-10" style="display:none;">
                            
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="related10">
                                  <thead>
                                    <tr class="table-primary">
                                        <th>S.No</th>
                                        <th>Upload File</th>
                                    </tr>
                                  </thead>
                                    <tbody>
                                        <td>1</td>
                                        <td> <input type="file" name="problem11_file" class="form-control form-control-sm text-center"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                       

                    </div>

                    <div class="row py-2">
                        <div class="col-md-2 offset-md-0">
                            <a href="{{ route('claiminvestmentdetail.create',$id) }}"
                                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i class="fa  fa-backward"></i> Investment Summery</a>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-sm form-control form-control-sm" id="project_det"><i class="fas fa-save"></i> Save as Draft</button>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <a href="{{ route('relatedpartytransaction.create',$id) }}"
                                class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold">Related Party <i class="fa  fa-forward"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var i = 1;
            var sn = 2;
            $('#add').click(function() {
                i++;
                $('#related').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td>'+
                    '<td class="text-center"><input type="text" name="pendingdispute_ques['+ (sn-1) +'][nature_of_lease]" id="name"class="form-control form-control-sm name_list1">'+
                    '</td><td class="text-center"><input type="text" name="pendingdispute_ques['+ (sn-1) +'][asset_description]" id="name"class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="number" name="pendingdispute_ques['+ (sn-1) +'][amt]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center">'+
                    '<button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove btn-sm">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $(document).ready(function() {
            $('#problem').on('change', function() {
                $('.display').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });


        // $(document).ready(function() {
        //     var i = 1;
        //     var sn = 3;
        //     $('#add1').click(function() {
        //         i++;
              
        //         $('#related1').append('<tr id="row' + i +'"><td class="text-center">' + (sn-1) +'</td>'+
        //             '<td class="text-center"><input type="text" name="company_data[2][authority]" id="name"class="form-control form-control-sm name_list1">'+
        //             '</td> <td class="text-center"><input type="date" name="company_data[2][approval_dt]" id="name"class="form-control form-control-sm name_list1">'+
        //             '</td><td class="text-center"><input type="number" name="company_data[2][pricing]" id="name"class="form-control form-control-sm name_list1">'+
        //             '</td><td class="text-center"><input type="text" name="company_data[2][tran_nature]" id="name"class="form-control form-control-sm name_list1"></td><td class="text-center">'+
        //             '<button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove1 btn-sm">Remove</button></td></tr>');
        //     });
        //     $(document).on('click', '.btn_remove1', function() {
        //         var button_id = $(this).attr("id");
        //         $('#row' + button_id + '').remove();
        //     });
        // });

        $(document).ready(function() {
            $('#problem1').on('change', function() {
                $('.display1').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display1').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });


        $(document).ready(function() {
            var i = 1;
            var sn = 3;
            $('#add2').click(function() {
                i++;
                
                $('#related2').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td>'+
                    '<th><input type="text" name="pendingdispute_ques2['+ (sn-1) +'][quest_particular]"  class="form-control name_list" ></td>'+
                        '<td><input type="number"  name="pendingdispute_ques2['+ (sn-1) +'][amt]"    class="form-control name_list add_rd" /></td>'+
                        '<td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove2 btn-sm">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove2', function() {
                
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                var sum = 0;
                $(".add_pt_data").each(function(){
                    sum +=  +$(this).val();
                });
                $(".tot_add_rd").val(sum);
            });
        });

        $(document).ready(function() {
            var i = 1;
            var sn = 1;
            $('#add3').click(function() {
                i++;
               
                $('#related3').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td>'+
                    '<td class="text-center"><input type="text" name="pendingdispute_ques3['+ (sn-1) +'][name_of_party]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="text" name="pendingdispute_ques3['+ (sn-1) +'][address]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="text" name="pendingdispute_ques3['+ (sn-1) +'][type_of_asset]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="number" name="pendingdispute_ques3['+ (sn-1) +'][gross_value]" id="name" class="form-control form-control-sm name_list1">'+
                    '<td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove3">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove3', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $(document).ready(function() {
            var i = 1;
            var sn = 2;
            $('#add4').click(function() {
                i++;
               
                $('#related4').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td>'+
                    '<td class="text-center"><input type="text" name="pendingdispute_ques4['+ (sn-1) +'][type_pm]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="text" name="pendingdispute_ques4['+ (sn-1) +'][impot_dom]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="number" name="pendingdispute_ques4['+ (sn-1) +'][residual_life]" id="name" class="form-control form-control-sm name_list1">'+
                    '</td><td class="text-center"><input type="number" name="pendingdispute_ques4['+ (sn-1) +'][capitalized_value]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="number" name="pendingdispute_ques4['+ (sn-1) +'][value_by_ce]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="number" name="pendingdispute_ques4['+ (sn-1) +'][value_custom_rule]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="number" name="pendingdispute_ques4['+ (sn-1) +'][eligibilty_criteria]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove4">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove4', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $(document).ready(function() {
            var i = 1;
            var sn = 2;
            $('#add5').click(function() {
                i++;
                
                $('#related5').append('<tr id="row' + i +'"><td class="text-center">' + sn++ +'</td>'+
                    '<td class="text-center"><input type="text" name="pendingdispute_ques5['+ (sn-1) +'][nature_of_utility]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="number" name="pendingdispute_ques5['+ (sn-1) +'][intended_use]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><input type="number" name="pendingdispute_ques5['+ (sn-1) +'][amt]" id="name" class="form-control form-control-sm name_list1"></td>'+
                    '<td class="text-center"><button type="button" name="remove" id="' +i + '" class="btn btn-danger btn_remove5">Remove</button></td></tr>');
            });
            $(document).on('click', '.btn_remove5', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        $(document).on("keyup", ".addition", function(){
            var sum = 0;
            $(".addition").each(function(){
                sum +=  +$(this).val();
            });
            $(".tot_addition").val(sum);
        });

        $(document).on("keyup", ".addition1", function(){
            var sum = 0;
            $(".addition1").each(function(){
                sum +=  +$(this).val();
            });
            $(".tot_addition1").val(sum);
        });
        
        $(document).on("keyup", ".add_rd", function(){
            var sum = 0;
            $(".add_rd").each(function(){
                sum +=  +$(this).val();
            });
            $(".tot_add_rd").val(sum);
        });

        $(document).on("keyup", ".addition2", function(){
            var sum = 0;
            $(".addition2").each(function(){
                sum +=  +$(this).val();
            });
            $(".tot_addition2").val(sum);
        });


        
        $(document).ready(function() {
            $('#problem2').on('change', function() {
                $('.display2').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display2').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem3').on('change', function() {
                $('.display3').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display3').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem4').on('change', function() {
                $('.display4').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display4').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem5').on('change', function() {
                $('.display5').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display5').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem6').on('change', function() {
                $('.display6').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display6').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem7').on('change', function() {
                $('.display7').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display7').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem8').on('change', function() {
                $('.display8').show();
                if (this.value.trim()) {
                    if (this.value !== 'N') {
                        $('.display8').hide();
                    } else if (this.value !== 'Y') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem9').on('change', function() {
                $('.display9').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display9').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem10').on('change', function() {
                $('.display10').show();
                if (this.value.trim()) {
                    if (this.value !== 'Y') {
                        $('.display10').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });

        $(document).ready(function() {
            $('#problem11').on('change', function() {
                $('.display11').show();
                if (this.value.trim()) {
                    if (this.value !== 'N') {
                        $('.display11').hide();
                    } else if (this.value !== 'N') {
                        $('.display_1').hide();
                    }
                }
            });
        });
        $(document).ready(function () {
            $('.prevent-multiple-submit').on('submit', function() {
                const btn = document.getElementById("project_det");
                btn.disabled = true;
                setTimeout(function(){btn.disabled = false;}, (1000*20));
            });
        });

    </script>
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\User\Claims\ClaimProjectDetailRequest', '#project-details') !!}
@endpush
@endpush
