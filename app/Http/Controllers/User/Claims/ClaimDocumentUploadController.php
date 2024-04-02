<?php

namespace App\Http\Controllers\User\Claims;

use App\ClaimDocumentUpload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use App\ClaimStage;
use App\DocumentUploads;
use App\ClaimDocInfo;
use App\ClaimGerneralDoc;
use App\ClaimDocRemmittanceIncentive;
use App\IncentiveDocMap;
use App\ClaimCertificateDocDetail;
use Mail;

class ClaimDocumentUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($claimId)
    {
        
        $claimMast = DB::table('claims_masters')->where('id',$claimId)->first();
        // dd($claimMast);
        // $currentFinancialYear = (date('Y')-1) . '-' . (date('y'));
        $forRetuenBack = DB::table('fy_master')->where('id',$claimMast->fy)->first();
        $forRetuenBackId = $forRetuenBack->id;
        // dd($forRetuenBackId);
        

        $doc_particular = DB::table('claim_20_percent_incentive_particular')->orderBy('serial_number')->get();
        return view('user.claims.incentive_document_upload', compact('doc_particular', 'claimId','forRetuenBackId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($section, $id)
    {
        
        $apps = DB::table('approved_apps_details as a')
            ->leftJoin('claims_masters as cm', 'cm.app_id', '=', 'a.id')
            ->where('cm.created_by', Auth::user()->id)
            ->where('cm.id', $id)
            ->whereNotNull('a.approval_dt')
            ->select('a.id as app_id', 'cm.id as claim_id')->first();
        
        if ($section == 'A') {
            $stage = ClaimStage::where('claim_id', $id)->where('stages', 7)->first();
            if ($stage) {
                return redirect()->route('claimdocumentupload.edit', [$stage->claim_id, 'A']);
            }
            $doc_part = DB::table('claim_doc_upload_particular')->get();
            return view('user.claims.document_upload', compact('doc_part', 'apps'));

        } elseif ($section == 'B') {
            $stage = ClaimStage::where('claim_id', $id)->where('stages', 8)->first();
            if ($stage) {
                return redirect()->route('claimdocumentupload.edit', [$stage->claim_id, 'B']);
            }
            $doc_part = DB::table('claim_doc_upload_particular')->get();

            return view('user.claims.uploadsectionB', compact('doc_part', 'apps'));
        } elseif ($section == 'C') {
            $stage = ClaimStage::where('claim_id', $id)->where('stages', 9)->first();
            if ($stage) {
                return redirect()->route('claimdocumentupload.edit', [$stage->claim_id, 'C']);
            }
            $doc_part = DB::table('claim_doc_upload_particular')->get();

            return view('user.claims.uploadsectionC', compact('doc_part', 'apps'));
            // dd('section c');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $section)
    {
        //dd('R', $request);
        if ($section == 'A') {
            //dd('A', $request);
            $doc_types = DB::table('document_master')->where('doc_name', 'DocUp')->pluck('doc_type', 'doc_id')->toArray();

            DB::transaction(function () use ($doc_types, $request) {

                if ($request->problem == 'Y') {
                    foreach ($request->GenCompDoc as $data) {
                        $doc = new DocumentUploads;
                        $doc->app_id = $request->app_id;
                        $doc->doc_id = 1003;
                        $doc->user_id = Auth::user()->id;
                        $doc->mime = $data['doc']->getMimeType();
                        $doc->file_size = $data['doc']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $data['doc']->getClientOriginalName();
                        $doc->uploaded_file = fopen($data['doc']->getRealPath(), 'r');
                        $doc->save();

                        ClaimDocInfo::create([
                            'app_id' => $request->app_id,
                            'claim_id' => $request->claim_id,
                            'created_by' => Auth::user()->id,
                            'upload_id' => $doc->id,
                            'doc_id' => $doc->doc_id,
                            'prt_id' => 12,
                            'section' => 'A',
                            'file_name' => 'section A'
                        ]);

                        ClaimGerneralDoc::create([
                            'app_id' => $request->app_id,
                            'claim_id' => $request->claim_id,
                            'created_by' => Auth::user()->id,
                            'period' => $data['period'],
                            'from_dt' => $data['from_date'],
                            'to_dt' => $data['to_date'],
                            'prt_id' => 12,
                            'doc_id' => $doc->doc_id,
                            'response' => $request->problem,
                            'section' => 'A',
                            'upload_id' => $doc->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }

                foreach ($request->GenChqDoc as $data) {
                    $doc = new DocumentUploads;
                    $doc->app_id = $request->app_id;
                    $doc->doc_id = 1004;
                    $doc->user_id = Auth::user()->id;
                    $doc->mime = $data['doc']->getMimeType();
                    $doc->file_size = $data['doc']->getSize();
                    $doc->updated_at = Carbon::now();
                    $doc->created_at = Carbon::now();
                    $doc->file_name = $data['doc']->getClientOriginalName();
                    $doc->uploaded_file = fopen($data['doc']->getRealPath(), 'r');
                    $doc->save();

                    ClaimDocInfo::create([
                        'app_id' => $request->app_id,
                        'claim_id' => $request->claim_id,
                        'created_by' => Auth::user()->id,
                        'upload_id' => $doc->id,
                        'doc_id' => $doc->doc_id,
                        'prt_id' => 12,
                        'section' => 'A',
                        'file_name' => 'section A'
                    ]);
                    ClaimDocRemmittanceIncentive::create([
                        'app_id' => $request->app_id,
                        'claim_id' => $request->claim_id,
                        'created_by' => Auth::user()->id,
                        'bank_name' => $data['bank_name'],
                        'account_holder_name' => $data['acc_name'],
                        'acc_type' => $data['acc_type'],
                        'branch_name' => $data['branch_name'],
                        'acc_no' => $data['acc_no'],
                        'ifsc_code' => $data['ifsc_code'],
                        'doc_id' => $doc->doc_id,
                        'section' => 'A',
                        'prt_id' => 12,
                        'upload_id' => $doc->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }


                foreach ($doc_types as $docid => $doctype) {
                    if ($request->hasfile($doctype)) {
                        foreach ($request->file($doctype) as $newDoc) {
                            $doc = new DocumentUploads;
                            $doc->app_id = $request->app_id;
                            $doc->doc_id = $docid;
                            $doc->user_id = Auth::user()->id;
                            $doc->mime = $newDoc->getMimeType();
                            $doc->file_size = $newDoc->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $newDoc->getClientOriginalName();
                            $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                            $doc->save();

                            ClaimDocInfo::create([
                                'app_id' => $request->app_id,
                                'claim_id' => $request->claim_id,
                                'created_by' => Auth::user()->id,
                                'upload_id' => $doc->id,
                                'doc_id' => $doc->doc_id,
                                'prt_id' => 12,
                                'section' => 'A',
                                'file_name' => 'section A'
                            ]);
                        }
                    }
                }

                ClaimStage::create([
                    'app_id' => $request->app_id,
                    'created_by' => Auth::user()->id,
                    'claim_id' => $request->claim_id,
                    'stages' => 7,
                    'status' => 'D',
                ]);
                alert()->success('Claim Uploads Details Secton A Saved', 'Success!')->persistent('Close');
            });

            return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'A']);
        } elseif ($section == 'B') {
           // dd('B', $request);
            $doc_types = DB::table('document_master')->where('doc_name', 'DocUp')->pluck('doc_type', 'doc_id')->toArray();
            DB::transaction(function () use ($doc_types, $request) {
                foreach ($doc_types as $docid => $doctype) {
                    if ($request->hasfile($doctype)) {
                        foreach ($request->file($doctype) as $newDoc) {
                            $doc = new DocumentUploads;
                            $doc->app_id = $request->app_id;
                            $doc->doc_id = $docid;
                            $doc->user_id = Auth::user()->id;
                            $doc->mime = $newDoc->getMimeType();
                            $doc->file_size = $newDoc->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $newDoc->getClientOriginalName();
                            $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                            $doc->save();

                            ClaimDocInfo::create([
                                'app_id' => $request->app_id,
                                'claim_id' => $request->claim_id,
                                'created_by' => Auth::user()->id,
                                'upload_id' => $doc->id,
                                'doc_id' => $doc->doc_id,
                                'prt_id' => 12,
                                'section' => 'B',
                                'file_name' => 'section B'
                            ]);
                        }
                    }
                }

                ClaimStage::create([
                    'app_id' => $request->app_id,
                    'created_by' => Auth::user()->id,
                    'claim_id' => $request->claim_id,
                    'stages' => 8,
                    'status' => 'D',
                ]);
                alert()->success('Claim Uploads Details Saved', 'Success!')->persistent('Close');
            });
            return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'B']);
        } elseif ($section == 'C') {

           // dd('C', $request);

            // for($i=1; $i<=10; $i++){
            //     $data = 'Misc_'.$i;

            //     if(array_key_exists('doc',$request->$data) xor $request->$data['name'] !=null){
            //         if(array_key_exists('doc',$request->$data)){
            //             if(!array_key_exists('name',$request->$data) && $request->$data['name'] !=null){
            //                 alert()->warning('If you have miscellaneous document then upload document with valid document name', 'Warning!')->persistent('Close');
            //                 return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'C']);
            //             }
            //         }
            //         if(array_key_exists('name',$request->$data) && $request->$data['name'] !=null){
            //             if(!array_key_exists('doc',$request->$data)){
            //                 alert()->warning('If you have miscellaneous document then upload document with valid document name', 'Warning!')->persistent('Close');
            //                 return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'C']);
            //             }
            //         }
            //     }
            // }

            // $doc_types = DB::table('document_master')->where('doc_name','Misc')->pluck('doc_type','doc_id')->toArray();

            // DB::transaction(function () use ($doc_types, $request) {


            //     foreach ($doc_types as $docid => $doctype) {
            //         if ($request->hasfile($doctype)) {
            //             foreach ($request->file($doctype) as $key =>$newDoc) {
            //                 // dd($request->$doctype['name'],$newDoc );
            //                 $doc = new DocumentUploads;
            //                 $doc->app_id = $request->app_id;
            //                 $doc->doc_id = $docid;
            //                 $doc->user_id = Auth::user()->id;
            //                 $doc->mime = $newDoc->getMimeType();
            //                 $doc->file_size = $newDoc->getSize();
            //                 $doc->updated_at = Carbon::now();
            //                 $doc->created_at = Carbon::now();
            //                 $doc->file_name = $newDoc->getClientOriginalName();
            //                 $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
            //                 $doc->save();

            //                 ClaimDocInfo::create([
            //                     'app_id' => $request->app_id,
            //                     'claim_id' =>$request->claim_id,
            //                     'created_by' => Auth::user()->id,
            //                     'upload_id' => $doc->id,
            //                     'doc_id' => $doc->doc_id,
            //                     'prt_id' => 12,
            //                     'section' => 'C',
            //                     'file_name'=>$request->$doctype['name']
            //                 ]);
            //             }
            //         }
            //     }
            for ($i = 1; $i <= 10; $i++) {
                $data = 'Misc_' . $i;

                if (array_key_exists('doc', $request->$data) xor $request->$data['name'] != null) {
                    if (array_key_exists('doc', $request->$data) && $request->$data['name'] == null) {
                        alert()->warning('Please add name to the document', 'Warning!')->persistent('Close');
                    } elseif (!array_key_exists('doc', $request->$data) || !array_key_exists('pdf', $request->$data['doc']) || !array_key_exists('excel', $request->$data['doc'])) {
                        alert()->warning('Please add valid document with the name given', 'Warning!')->persistent('Close');
                    }
                    return redirect()->route('claimdocumentupload.create', ['C', $request->claim_id]);
                }
            }


            $doc_types = DB::table('document_master')->where('doc_name', 'Misc')->pluck('doc_type', 'doc_id')->toArray();
            DB::transaction(function () use ($doc_types, $request) {

                foreach ($doc_types as $docid => $doctype) {
                    if ($request->file($doctype)) {
                        foreach ($request->file($doctype) as $key => $newDoc) {
                            $doc_ids =
                                $upload_pdf = '';
                            $upload_excel = '';
                            if (array_key_exists('pdf', $newDoc)) {
                                $doc = new DocumentUploads;
                                $doc->app_id = $request->app_id;
                                $doc->doc_id = $docid;
                                $doc->mime = $newDoc['pdf']->getMimeType();
                                $doc->file_size = $newDoc['pdf']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->created_at = Carbon::now();
                                $doc->file_name = $newDoc['pdf']->getClientOriginalName();
                                $doc->uploaded_file = fopen($newDoc['pdf']->getRealPath(), 'r');
                                $doc->save();
                                $upload_pdf = $doc->id;
                            }

                            if (array_key_exists('excel', $newDoc)) {
                                $doc1 = new DocumentUploads;
                                $doc1->app_id = $request->app_id;
                                $doc1->doc_id = $docid;
                                $doc1->mime = $newDoc['excel']->getMimeType();
                                $doc1->file_size = $newDoc['excel']->getSize();
                                $doc1->updated_at = Carbon::now();
                                $doc1->created_at = Carbon::now();
                                $doc1->file_name = $newDoc['excel']->getClientOriginalName();
                                $doc1->uploaded_file = fopen($newDoc['excel']->getRealPath(), 'r');
                                $doc1->save();
                                $upload_excel = $doc1->id;
                            }

                            ClaimDocInfo::create([
                                'app_id' => $request->app_id,
                                'claim_id' => $request->claim_id,
                                'created_by' => Auth::user()->id,
                                'upload_id' => ($upload_pdf) ? $upload_pdf : null,
                                'upload_id_excel' => ($upload_excel) ? $upload_excel : null,
                                'doc_id' => isset($doc->doc_id) ? $doc->doc_id : null,
                                'prt_id' => 12,
                                'section' => 'C',
                                'file_name' => $request->$doctype['name'],
                            ]);
                        }
                    }
                }


                ClaimStage::create([
                    'app_id' => $request->app_id,
                    'created_by' => Auth::user()->id,
                    'claim_id' => $request->claim_id,
                    'stages' => 9,
                    'status' => 'D',
                ]);
                alert()->success('Claim Uploads Details Saved', 'Success!')->persistent('Close');
            });
            // dd('stored');
            return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'C']);
        } elseif ($section == 'R') {

    
            // code by Deepak Sharma
            foreach ($request->data as $val) {
                if(array_key_exists('mis',$val)){
                    if (array_key_exists('pdf', $val) || array_key_exists('excel', $val)) {
                        if ($val['mis'] == null ) {
                            alert()->warning('If you have miscellaneous document then upload document with valid document name', 'Warning!')->persistent('Close');
                            return redirect()->back();
                        }
                    } elseif ($val['mis'] != null) {
                        // if (array_key_exists('name', $val)) {
                        if (!array_key_exists('pdf', $val) || array_key_exists('excel', $val)) {
                            alert()->warning('If you have miscellaneous document then upload document with valid document name', 'Warning!')->persistent('Close');
                            return redirect()->back();
                        }
                    }
                }
            }

            //dd('R', $request->data, $request);
            // end code by Deepak Sharma

            DB::transaction(function () use ($request) {
                foreach ($request->data as $index => $val) {

                    // if (array_key_exists('pdf', $val)) {
                    //     if ($val['pdf'] == 10) {
                           
                    //         $docid = '5009';
                    //     } else {
                    //         $docid = '5008';
                            
                    //     }
                    // }
                    $docid = '5008';
                    $upload_pdf = '';
                    $upload_excel = '';
                    if (array_key_exists('pdf', $val)) {
                        $doc = new DocumentUploads;
                        $doc->app_id = $request->claim_id;
                        $doc->doc_id = $docid;
                        $doc->mime = $val['pdf']->getMimeType();
                        $doc->file_size = $val['pdf']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $val['pdf']->getClientOriginalName();
                        $doc->uploaded_file = fopen($val['pdf']->getRealPath(), 'r');
                        $doc->save();
                        $upload_pdf = $doc->id;
                    }

                    if (array_key_exists('excel', $val)) {
                        $doc1 = new DocumentUploads;
                        $doc1->app_id = $request->claim_id;
                        $doc1->doc_id = $docid;
                        $doc1->mime = $val['excel']->getMimeType();
                        $doc1->file_size = $val['excel']->getSize();
                        $doc1->updated_at = Carbon::now();
                        $doc1->created_at = Carbon::now();
                        $doc1->file_name = $val['excel']->getClientOriginalName();
                        $doc1->uploaded_file = fopen($val['excel']->getRealPath(), 'r');
                        $doc1->save();
                        $upload_excel = $doc1->id;
                    }

                    
                    IncentiveDocMap::create([
                        'claim_id' => $request->claim_id,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                        'status' => 'D',
                        'pdf_upload_id' => $upload_pdf ? $upload_pdf : NULL,
                        'excel_upload_id' => $upload_excel ? $upload_excel : NULL,
                        'prt_id' => $val['prt_id'],
                        'file_name' => isset($val['mis']) ? $val['mis'] : null,
                        //'file_name' => array_key_exists('mis',$val) ? $val['mis']:null,
                    ]);
                }
                alert()->success('Claim Incentive Document has been save successfully', 'Success!')->persistent('Close');
            });
            return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'R']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClaimDocumentUpload  $claimDocumentUpload
     * @return \Illuminate\Http\Response
     */
    public function show($claim_id)
    {
        
        $doc_particular = DB::table('claim_20_percent_incentive_particular')->orderBy('serial_number')->get();

        
        $doc_map = IncentiveDocMap::where('claim_id', $claim_id)->get();
        return view('user.claims.incentive_document_upload_show', compact('doc_particular', 'claim_id', 'doc_map'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClaimDocumentUpload  $claimDocumentUpload
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $section)
    {
        $apps = DB::table('approved_apps_details as a')
            ->leftJoin('claims_masters as cm', 'cm.app_id', '=', 'a.id')
            ->where('cm.created_by', Auth::user()->id)
            ->whereNotNull('a.approval_dt')
            ->where('cm.id', $id)
            ->select('a.id as app_id', 'cm.id as claim_id')->first();

        if ($section == 'A') {
            $doc_data = DB::table('claim_doc_info_map')->where('claim_id', $apps->claim_id)->where('section', 'A')->orderby('doc_id', 'ASC')->get();
            // dd($doc_data);
            $genral_doc = DB::table('claim_gerneral_doc_detail')->where('app_id', $apps->app_id)->where('claim_id', $apps->claim_id)->get();
            $response = DB::table('claim_gerneral_doc_detail')->where('app_id', $apps->app_id)->where('claim_id', $apps->claim_id)->pluck('response')->first();
            $bank_info = DB::table('claim_doc_remmittance_incentive')->where('app_id', $apps->app_id)->where('claim_id', $apps->claim_id)->first();
            // dd($genral_doc);
            return view('user.claims.documentupload_edit', compact('apps', 'doc_data', 'genral_doc', 'bank_info', 'response'));

        } elseif ($section == 'B') {
           
            $doc_data = DB::table('claim_doc_info_map')->where('claim_id', $apps->claim_id)->where('app_id', $apps->app_id)->where('section', 'B')->get();
            return view('user.claims.uploadsectionB_edit', compact('apps', 'doc_data'));
        } elseif ($section == 'C') {
            
            // $doc_data=DB::table('claim_doc_info_map')->where('claim_id',$apps->claim_id)->where('section','C')->where('app_id',$apps->app_id)->get();

            // $doc_id =DB::table('document_master')->where('doc_name','Misc')->pluck('doc_type','doc_id')->toArray();
            // $tot_misc = 10 - sizeof($doc_data);
            // return view('user.claims.uploadsectioneditC',compact('apps','doc_data','tot_misc'));
            // $claimStage = $claimMast->stages->where('claim_id', $id)->where('stages',9)->first();
            //dd($claimStage);
            // if (!$claimStage) {
            //     return redirect()->route('claimdocumentupload.create', ['C',$id]);
            // }

            $doc_data = DB::table('claim_doc_info_map')->where('claim_id', $apps->claim_id)->where('section', 'C')->where('app_id', $apps->app_id)->orderby('id')->get();
            $doc_id = DB::table('document_master')->where('doc_name', 'Misc')->pluck('doc_type', 'doc_id')->toArray();
            $tot_misc = 12 - sizeof($doc_data);
            return view('user.claims.uploadsectioneditC', compact('apps', 'doc_data', 'tot_misc'));

        } elseif ($section == 'R') {
            //dd('hello');
            $claim_id = $id;  
            //dd($claim_id);  
            $cp = DB::table('claims_masters')->where('id',$claim_id)->first();
            $period = DB::table('claim_applicant_details')->where('claim_id',$claim_id)->first()->claim_fill_period;
            // dd($cp);
            $doc_particular = DB::table('claim_20_percent_incentive_particular')->orderBy('serial_number')->get();
            $doc_map = IncentiveDocMap::where('claim_id', $claim_id)->get();
            return view('user.claims.incentive_document_upload_edit', compact('period','cp','doc_particular', 'claim_id', 'doc_map'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClaimDocumentUpload  $claimDocumentUpload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $section)
    {
        if ($section == 'A') {
            $doc_types = DB::table('document_master')->where('doc_name', 'DocUp')->pluck('doc_type', 'doc_id')->toArray();

            DB::transaction(function () use ($doc_types, $request) {
                //   dd($request->problem);
                if ($request->problem == 'Y') {

                    foreach ($request->GenCompDoc as $general) {
                        if (array_key_exists('id', $general)) {
                            if (array_key_exists('doc', $general)) {
                                $doc = DocumentUploads::where('id', $general['upload_id'])->first();
                                $doc->mime = $general['doc']->getMimeType();
                                $doc->file_size = $general['doc']->getSize();
                                $doc->updated_at = Carbon::now();
                                $doc->file_name = $general['doc']->getClientOriginalName();
                                $doc->uploaded_file = fopen($general['doc']->getRealPath(), 'r');
                                $doc->save();
                            }
                            $gen_data = ClaimGerneralDoc::find($general['id']);
                            $gen_data->period = $general['period'];
                            $gen_data->from_dt = $general['from_date'];
                            $gen_data->to_dt = $general['to_date'];
                            $gen_data->response = $request->response;
                            $gen_data->save();
                        } else {
                            $doc = new DocumentUploads;
                            $doc->app_id = $request->app_id;
                            $doc->doc_id = 1003;
                            $doc->mime = $general['doc']->getMimeType();
                            $doc->file_size = $general['doc']->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $general['doc']->getClientOriginalName();
                            $doc->uploaded_file = fopen($general['doc']->getRealPath(), 'r');
                            $doc->save();

                            ClaimDocInfo::create([
                                'app_id' => $request->app_id,
                                'claim_id' => $request->claim_id,
                                'created_by' => Auth::user()->id,
                                'upload_id' => $doc->id,
                                'doc_id' => $doc->doc_id,
                                'prt_id' => 12,
                                'section' => 'A',
                            ]);

                            ClaimGerneralDoc::create([
                                'app_id' => $request->app_id,
                                'claim_id' => $request->claim_id,
                                'created_by' => Auth::user()->id,
                                'period' => $general['period'],
                                'from_dt' => $general['from_date'],
                                'to_dt' => $general['to_date'],
                                'prt_id' => 12,
                                'doc_id' => $doc->doc_id,
                                'response' => $request->problem,
                                'section' => 'B',
                                'upload_id' => $doc->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        }

                    }
                } elseif ($request->problem == 'N') { // && $request->response == 'Y'
                    // dd('hello');
                    $ger = ClaimGerneralDoc::where('claim_id', $request->claim_id)->where('app_id', $request->app_id)->delete();

                    $data = ClaimDocInfo::where('claim_id', $request->claim_id)
                        ->where('app_id', $request->app_id)
                        ->where('doc_id', 1003)
                        ->delete();

                }
                // dd('dkjfkjds');
                foreach ($request->GenChqDocN as $data) {
                    if (array_key_exists('doc', $data)) {
                        $doc = DocumentUploads::where('id', $data['upload_id'])->first();
                        $doc->app_id = $request->app_id;
                        $doc->doc_id = 1004;
                        $doc->mime = $data['doc']->getMimeType();
                        $doc->file_size = $data['doc']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $data['doc']->getClientOriginalName();
                        $doc->uploaded_file = fopen($data['doc']->getRealPath(), 'r');
                        $doc->save();

                    }

                    $incentive_data = ClaimDocRemmittanceIncentive::find($data['id']);
                    $incentive_data->bank_name = $data['bank_name'];
                    $incentive_data->account_holder_name = $data['acc_name'];
                    $incentive_data->acc_type = $data['acc_type'];
                    $incentive_data->branch_name = $data['branch_name'];
                    $incentive_data->acc_no = $data['acc_no'];
                    $incentive_data->ifsc_code = $data['ifsc_code'];
                    $incentive_data->save();
                }

                foreach ($request->upload_doc as $key => $value) {
                    if (array_key_exists('doc', $value)) {
                        $doc = DocumentUploads::where('app_id', $request->app_id)->where('id', $value['id'])->first();
                        $doc->app_id = $request->app_id;
                        $doc->mime = $value['doc']->getMimeType();
                        $doc->file_size = $value['doc']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->file_name = $value['doc']->getClientOriginalName();
                        $doc->uploaded_file = fopen($value['doc']->getRealPath(), 'r');
                        $doc->save();
                    }
                }

                alert()->success('Claim Uploads Details Saved', 'Success!')->persistent('Close');
            });

            return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'A']);

        } elseif ($section == 'B') {

            $doc_types = DB::table('document_master')->where('doc_name', 'DocUp')->pluck('doc_type', 'doc_id')->toArray();

            DB::transaction(function () use ($doc_types, $request) {
                foreach ($request->upload_doc as $key => $value) {
                    if (array_key_exists('doc', $value)) {
                        $doc = DocumentUploads::where('app_id', $request->app_id)->where('id', $value['id'])->first();
                        $doc->app_id = $request->app_id;
                        $doc->mime = $value['doc']->getMimeType();
                        $doc->file_size = $value['doc']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->file_name = $value['doc']->getClientOriginalName();
                        $doc->uploaded_file = fopen($value['doc']->getRealPath(), 'r');
                        $doc->save();
                    }

                }

                alert()->success('Claim Uploads Details Saved', 'Success!')->persistent('Close');
            });

            return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'B']);
        } elseif ($section == 'C') {
            for ($i = 1; $i <= 10; $i++) {
                $data = 'Misc_' . $i;


                if (!array_key_exists('id', $request->$data) && (array_key_exists('doc', $request->$data) xor $request->$data['name'] != null)) {
                    if (array_key_exists('doc', $request->$data) && $request->$data['name'] == null) {
                        alert()->warning('Please add name to the document', 'Warning!')->persistent('Close');
                    } elseif (!array_key_exists('doc', $request->$data) || !array_key_exists('pdf', $request->$data['doc']) || !array_key_exists('excel', $request->$data['doc'])) {
                        alert()->warning('Please add valid document with the name given', 'Warning!')->persistent('Close');
                    }
                    return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'C']);
                }

            }

            $doc_types = DB::table('document_master')->where('doc_name', 'Misc')->pluck('doc_type', 'doc_id')->toArray();

            DB::transaction(function () use ($doc_types, $request) {
                foreach ($doc_types as $k => $miscell) {
                    if (array_key_exists('id', $request->$miscell)) {
                        if (array_key_exists('doc', $request->$miscell)) {
                            $claim_doc_info = ClaimDocInfo::where('claim_id', $request->claim_id)->where('app_id', $request->app_id)->where('upload_id', $request->$miscell['id'])->first();
                            if (array_key_exists('pdf', $request->$miscell['doc'])) {
                                if ($claim_doc_info->upload_id != null) {
                                    $doc = DocumentUploads::where('app_id', $request->app_id)->where('id', $request->$miscell['id'])->where('doc_id', $claim_doc_info->doc_id)->first();
                                    $doc->mime = $request->$miscell['doc']['pdf']->getMimeType();
                                    $doc->file_size = $request->$miscell['doc']['pdf']->getSize();
                                    $doc->updated_at = Carbon::now();
                                    $doc->file_name = $request->$miscell['doc']['pdf']->getClientOriginalName();
                                    $doc->uploaded_file = fopen($request->$miscell['doc']['pdf']->getRealPath(), 'r');
                                    $doc->save();
                                } else {
                                    $doc = new DocumentUploads;
                                    $doc->app_id = $request->app_id;
                                    $doc->doc_id = $k;
                                    $doc->mime = $request->$miscell['doc']['pdf']->getMimeType();
                                    $doc->file_size = $request->$miscell['doc']['pdf']->getSize();
                                    $doc->updated_at = Carbon::now();
                                    $doc->created_at = Carbon::now();
                                    $doc->file_name = $request->$miscell['doc']['pdf']->getClientOriginalName();
                                    $doc->uploaded_file = fopen($request->$miscell['doc']['pdf']->getRealPath(), 'r');
                                    $doc->save();
                                    $upload_pdf = $doc->id;

                                    $claim_doc_info->doc_id = $k;
                                    $claim_doc_info->upload_id = $doc->id;
                                    $claim_doc_info->save();
                                }
                            }
                            if (array_key_exists('excel', $request->$miscell['doc'])) {
                                if ($claim_doc_info->upload_id_excel != null) {
                                    $doc = DocumentUploads::where('app_id', $request->app_id)->where('id', $claim_doc_info->upload_id_excel)->first();
                                    $doc->mime = $request->$miscell['doc']['excel']->getMimeType();
                                    $doc->file_size = $request->$miscell['doc']['excel']->getSize();
                                    $doc->updated_at = Carbon::now();
                                    $doc->file_name = $request->$miscell['doc']['excel']->getClientOriginalName();
                                    $doc->uploaded_file = fopen($request->$miscell['doc']['excel']->getRealPath(), 'r');
                                    $doc->save();
                                } else {
                                    $doc = new DocumentUploads;
                                    $doc->app_id = $request->app_id;
                                    $doc->doc_id = $k;
                                    $doc->mime = $request->$miscell['doc']['excel']->getMimeType();
                                    $doc->file_size = $request->$miscell['doc']['excel']->getSize();
                                    $doc->updated_at = Carbon::now();
                                    $doc->created_at = Carbon::now();
                                    $doc->file_name = $request->$miscell['doc']['excel']->getClientOriginalName();
                                    $doc->uploaded_file = fopen($request->$miscell['doc']['excel']->getRealPath(), 'r');
                                    $doc->save();
                                    $upload_pdf = $doc->id;

                                    $claim_doc_info->upload_id_excel = $doc->id;
                                    $claim_doc_info->save();
                                }
                            }
                        }
                        if ($request->$miscell['name'] != null) {
                            $claim_doc_info = ClaimDocInfo::where('app_id', $request->app_id)->where('id', $request->$miscell['info_id'])->first();
                            $claim_doc_info->file_name = $request->$miscell['name'];
                            $claim_doc_info->save();
                        }

                    } elseif (!array_key_exists('id', $request->$miscell) && $request->$miscell['name'] != null) {

                        if ($request->file($miscell)) {
                            foreach ($request->file($miscell) as $key => $newDoc) {
                                $doc_ids =
                                    $upload_pdf = '';
                                $upload_excel = '';
                                if (array_key_exists('pdf', $newDoc)) {
                                    $doc = new DocumentUploads;
                                    $doc->app_id = $request->app_id;
                                    $doc->doc_id = $k;
                                    $doc->mime = $newDoc['pdf']->getMimeType();
                                    $doc->file_size = $newDoc['pdf']->getSize();
                                    $doc->updated_at = Carbon::now();
                                    $doc->created_at = Carbon::now();
                                    $doc->file_name = $newDoc['pdf']->getClientOriginalName();
                                    $doc->uploaded_file = fopen($newDoc['pdf']->getRealPath(), 'r');
                                    $doc->save();
                                    $upload_pdf = $doc->id;
                                }

                                if (array_key_exists('excel', $newDoc)) {
                                    $doc1 = new DocumentUploads;
                                    $doc1->app_id = $request->app_id;
                                    $doc1->doc_id = $k;
                                    $doc1->mime = $newDoc['excel']->getMimeType();
                                    $doc1->file_size = $newDoc['excel']->getSize();
                                    $doc1->updated_at = Carbon::now();
                                    $doc1->created_at = Carbon::now();
                                    $doc1->file_name = $newDoc['excel']->getClientOriginalName();
                                    $doc1->uploaded_file = fopen($newDoc['excel']->getRealPath(), 'r');
                                    $doc1->save();
                                    $upload_excel = $doc1->id;
                                }

                                ClaimDocInfo::create([
                                    'app_id' => $request->app_id,
                                    'claim_id' => $request->claim_id,
                                    'created_by' => Auth::user()->id,
                                    'upload_id' => ($upload_pdf) ? $upload_pdf : null,
                                    'upload_id_excel' => ($upload_excel) ? $upload_excel : null,
                                    'doc_id' => isset($doc->doc_id) ? $doc->doc_id : null,
                                    'prt_id' => 12,
                                    'section' => 'C',
                                    'file_name' => $request->$miscell['name'],
                                ]);
                            }
                        }
                    }
                }
                alert()->success('Claim Uploads Details Saved', 'Success!')->persistent('Close');
            });

            return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'C']);
        } elseif ($section == 'R') {

            //dd('R' ,$request->claim_id);
            // code by Deepak Sharma
            foreach ($request->data as $val) {
                if(array_key_exists('mis',$val)){
                    if (array_key_exists('pdf', $val) || array_key_exists('excel', $val)) {
                        if ($val['mis'] == null) {
                            alert()->warning('If you have miscellaneous document then upload document with valid document name', 'Warning!')->persistent('Close');
                            return redirect()->back();
                        }
                    } elseif ($val['mis'] != null) {
                         if (array_key_exists('name', $val) || array_key_exists('excel', $val)) {
                        //if (!array_key_exists('pdf', $val)) {
                            alert()->warning('If you have miscellaneous document then upload document with valid document name', 'Warning!')->persistent('Close');
                            return redirect()->back();
                        }
                    }
                }
            }

            // dd('R', $request);
            // end code by Deepak Sharma
            DB::transaction(function () use ($request) {
                //dd($request->data);
                foreach ($request->data as $val) {

                    $map_data = IncentiveDocMap::where('id', $val['id'])->where('claim_id', $request->claim_id)->first();
                    $docid = '5008';
                    if (array_key_exists('pdf', $val)) {
                        if($val['pdf_upload_id'])
                        {
                            $doc = DocumentUploads::find($val['pdf_upload_id']);
                            $doc->mime = $val['pdf']->getMimeType();
                            $doc->file_size = $val['pdf']->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->file_name = $val['pdf']->getClientOriginalName();
                            $doc->uploaded_file = fopen($val['pdf']->getRealPath(), 'r');
                            $doc->save();
                        }else{
                            $doc =New  DocumentUploads;
                            $doc->app_id = $request->claim_id;
                            $doc->doc_id = $docid;
                            $doc->mime = $val['pdf']->getMimeType();
                            $doc->file_size = $val['pdf']->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $val['pdf']->getClientOriginalName();
                            $doc->uploaded_file = fopen($val['pdf']->getRealPath(), 'r');
                            $doc->save();
                            $map_data->pdf_upload_id = $doc->id;
                        }
                    }

                    if (array_key_exists('excel', $val)) {
                        if($val['excel_upload_id'])
                        {
                            $doc1 = DocumentUploads::find($val['excel_upload_id']);
                            $doc1->mime = $val['excel']->getMimeType();
                            $doc1->file_size = $val['excel']->getSize();
                            $doc1->updated_at = Carbon::now();
                            $doc1->file_name = $val['excel']->getClientOriginalName();
                            $doc1->uploaded_file = fopen($val['excel']->getRealPath(), 'r');
                            $doc1->save();
                        }else{
                            $doc1 =New DocumentUploads;
                            $doc1->app_id = $request->claim_id;
                            $doc1->doc_id = $docid;
                            $doc1->mime = $val['excel']->getMimeType();
                            $doc1->file_size = $val['excel']->getSize();
                            $doc1->updated_at = Carbon::now();
                            $doc1->created_at = Carbon::now();
                            $doc1->file_name = $val['excel']->getClientOriginalName();
                            $doc1->uploaded_file = fopen($val['excel']->getRealPath(), 'r');
                            $doc1->save();
                            $map_data->excel_upload_id = $doc1->id;
                        }
                    }
                    // $map_data = IncentiveDocMap::where('id', $val['id'])->where('claim_id', $request->claim_id)->first();
                    //dd($request);
                    $map_data->claim_id = $request->claim_id;
                    if (array_key_exists('mis', $val)) {
                        $map_data->file_name = $val['mis'];
                    }else{
                        $map_data->file_name = null;
                    }
                   
                    $map_data->updated_by = Auth::user()->id;
                    //dd($map_data);
                    $map_data->save();
                }
                alert()->success('Claim Incentive Document has been update successfully', 'Success!')->persistent('Close');
            });
            return redirect()->route('claimdocumentupload.edit', [$request->claim_id, 'R']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClaimDocumentUpload  $claimDocumentUpload
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClaimDocumentUpload $claimDocumentUpload)
    {
        //
    }
    public function incentiveDoc($claim_id)
    {
        DB::transaction(function () use ($claim_id) {
                IncentiveDocMap::where('claim_id', $claim_id)
                ->where('status', 'D')
                ->update(['status' => 'S']);
                //mail section
                    $d_data = DB::table('claim_applicant_details')->where('claim_id',$claim_id)->select('incentive_from_date','incentive_to_date')->first();

                    $from_dt = DB::table('qtr_master')->where('qtr_id', $d_data->incentive_from_date)->select('start_month','year')->first();
                    $to_dt = DB::table('qtr_master')->where('qtr_id', $d_data->incentive_to_date)->select('month','year')->first();

                    $user = array('name' => Auth::user()->name, 'email' => Auth::user()->email,
                    'from_dt' => $from_dt->start_month, 'to_dt' =>$to_dt->month, 'status' => 'Incentive 20% Claim Form Submitted Successfully',
                    'fr_year'=>$from_dt->year,'to_year'=>$to_dt->year);

                    Mail::send('emails.claimTwentyPercentageFinalSubmit', $user, function ($message) use ($user) {
                        $message->to($user['email'])->subject($user['status']);
                        $message->cc('bdpli@ifciltd.com');
                    });

                alert()->success('Claim Incentive Document has been submitted successfully', 'Success!')->persistent('Close');
            });
            return redirect()->route('claimdocumentupload.show',$claim_id);
    }


    
}
