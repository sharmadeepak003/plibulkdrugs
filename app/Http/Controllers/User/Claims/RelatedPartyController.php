<?php

namespace App\Http\Controllers\User\Claims;

use DB;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\RelatedParty;
use App\ClaimRptCompanyAct;
use App\ClaimStage;
use App\ClaimRptPendingDispute;
use App\ClaimRptConsideration;
use App\ClaimRptPriceMechanism;
use App\DocumentMaster;
use App\DocumentUploads;
use Carbon\Carbon;
use App\ClaimQuestionUserResponse;

class RelatedPartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $stage = ClaimStage::where('claim_id', $id)->where('stages', 6)->first();
        if ($stage) {
            return redirect()->route('relatedpartytransaction.edit', $stage->claim_id);
        }

        $parti = DB::table('claim_related_party_particular')->get();

        $apps = DB::table('approved_apps_details as a')
            ->leftJoin('claims_masters as cm', 'cm.app_id', '=', 'a.id')
            ->where('cm.created_by', Auth::user()->id)
            ->where('cm.id', $id)
            ->whereNotNull('a.approval_dt')
            ->select('a.id as app_id', 'cm.id as claim_id')->first();

        return view('user.claims.relatedpartytransaction', compact('parti', 'apps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {
            $doctypes = DocumentMaster::pluck('doc_type', 'doc_id')->toArray();


            foreach ($request->ques as $key => $ques) {

                $response = new ClaimQuestionUserResponse;
                $response->app_id = $request->app_id;
                $response->claim_id = $request->claim_id;
                $response->created_by = Auth::user()->id;
                $response->ques_id = $request->ques[$key];
                $response->response = $request->problem[$key];
                $response->save();
            }

            foreach ($request->app_num as $rtp) {
                RelatedParty::create([
                    'app_id' => $request->app_id,
                    'claim_id' => $request->claim_id,
                    'created_by' => Auth::user()->id,
                    'related_prt_id' => $rtp['prt_id'],
                    'nature_name' => $rtp['prt_name'],
                    'fy_statement' => $rtp['fy_statement'],
                    '3CEB' => $rtp['3CEB'],
                    'ceb_amount' => $rtp['3CEB_A'],
                    'cd_type' => $rtp['cd_type'],
                    '3CD' => $rtp['3CD'],
                ]);
            }

            if ($request->problem[20] == 'Y') {
                foreach ($request->pendingdispute as $pending) {
                    $doc = new DocumentUploads;
                    $doc->app_id = $request->app_id;
                    $doc->doc_id = 401;
                    $doc->user_id = Auth::user()->id;
                    $doc->mime = $pending['doc']->getMimeType();
                    $doc->file_size = $pending['doc']->getSize();
                    $doc->updated_at = Carbon::now();
                    $doc->created_at = Carbon::now();
                    $doc->file_name = $pending['doc']->getClientOriginalName();
                    $doc->uploaded_file = fopen($pending['doc']->getRealPath(), 'r');
                    $doc->save();

                    ClaimRptPendingDispute::create([
                        'app_id' => $request->app_id,
                        'claim_id' => $request->claim_id,
                        'created_by' => Auth::user()->id,
                        'year' => $pending['year'],
                        'forum_name' => $pending['forum_name'],
                        'amt' => $pending['amt'],
                        'dispute' => $pending['dispute'],
                        'que_id' => 20,
                        'upload_id' => $doc->id,
                        'response' => $request->problem[20],
                    ]);
                }
            }

            if ($request->problem[21] == 'Y') {

                foreach ($request->company_data as  $v) {
                    ClaimRptCompanyAct::create([
                        'app_id' => $request->app_id,
                        'claim_id' => $request->claim_id,
                        'created_by' => Auth::user()->id,
                        'authority' => $v['authority'],
                        'approval_dt' => $v['approval_dt'],
                        'pricing' => $v['pricing'],
                        'tran_nature' => $v['tran_nature'],
                        'que_id' => 21,
                        'response' => $request->problem[21],
                    ]);
                }
            }

            if ($request->problem[22] == 'Y') {
                foreach ($request->consideration as $consi) {

                    if ($consi['cd']) {
                        $cd_doc = new DocumentUploads;
                        $cd_doc->app_id = $request->app_id;
                        $cd_doc->doc_id = 402;
                        $cd_doc->user_id = Auth::user()->id;
                        $cd_doc->mime = $consi['cd']->getMimeType();
                        $cd_doc->file_size = $consi['cd']->getSize();
                        $cd_doc->updated_at = Carbon::now();
                        $cd_doc->created_at = Carbon::now();
                        $cd_doc->file_name = $consi['cd']->getClientOriginalName();
                        $cd_doc->uploaded_file = fopen($consi['cd']->getRealPath(), 'r');
                        $cd_doc->save();
                    }
                    if ($consi['ceb']) {
                        $ceb_doc = new DocumentUploads;
                        $ceb_doc->app_id = $request->app_id;
                        $ceb_doc->doc_id = 403;
                        $ceb_doc->user_id = Auth::user()->id;
                        $ceb_doc->mime = $consi['ceb']->getMimeType();
                        $ceb_doc->file_size = $consi['ceb']->getSize();
                        $ceb_doc->updated_at = Carbon::now();
                        $ceb_doc->created_at = Carbon::now();
                        $ceb_doc->file_name = $consi['ceb']->getClientOriginalName();
                        $ceb_doc->uploaded_file = fopen($consi['ceb']->getRealPath(), 'r');
                        $ceb_doc->save();
                    }
                    if ($consi['tax']) {
                        $tax_doc = new DocumentUploads;
                        $tax_doc->app_id = $request->app_id;
                        $tax_doc->user_id = Auth::user()->id;
                        $tax_doc->doc_id = 404;
                        $tax_doc->mime = $consi['tax']->getMimeType();
                        $tax_doc->file_size = $consi['tax']->getSize();
                        $tax_doc->updated_at = Carbon::now();
                        $tax_doc->created_at = Carbon::now();
                        $tax_doc->file_name = $consi['tax']->getClientOriginalName();
                        $tax_doc->uploaded_file = fopen($consi['tax']->getRealPath(), 'r');
                        $tax_doc->save();
                    }
                }

                $claimconsideration = new ClaimRptConsideration;

                $claimconsideration->fill([
                    'app_id' => $request->app_id,
                    'claim_id' => $request->claim_id,
                    'created_by' => Auth::user()->id,
                    'cd_doc_id' => 402,
                    'cd_upload_id' => $cd_doc->id,
                    'ceb_doc_id' => 403,
                    'ceb_upload_id' => $ceb_doc->id,
                    'tax_doc_id' => 404,
                    'tax_upload_id' => $tax_doc->id,
                    'sub_response' => $request->problem[22],
                    'que_id' => 22,
                    'response' => $request->problem[22],
                ]);
                $claimconsideration->save();
            }


            // if($request->problem[23]=='Y')
            // {
            //     foreach ($request->pricing_mech as $price) {
            //         $doc = new DocumentUploads;
            //         $doc->app_id=$request->app_id;
            //         $doc->doc_id = 405;
            //         $doc->user_id=Auth::user()->id;
            //         $doc->mime = $price['doc']->getMimeType();
            //         $doc->file_size = $price['doc']->getSize();
            //         $doc->updated_at = Carbon::now();
            //         $doc->created_at = Carbon::now();
            //         $doc->file_name = $price['doc']->getClientOriginalName();
            //         $doc->uploaded_file = fopen($price['doc']->getRealPath(), 'r');
            //         $doc->save();

            //         ClaimRptPriceMechanism::create([
            //             'app_id'=>$request->app_id,
            //             'claim_id'=>$request->claim_id,
            //             'created_by'=>Auth::user()->id,
            //             'doc_id'=>405,
            //             'upload_id'=>$doc->id,
            //             'que_id'=>23,
            //             'response'=>$request->problem[23],
            //         ]);
            //     }
            // }


            ClaimStage::create([
                'app_id' => $request->app_id,
                'created_by' => Auth::user()->id,
                'claim_id' => $request->claim_id,
                'stages' => 6,
                'status' => 'D',
            ]);
            alert()->success('Claim Related Party Details Save', 'Success!')->persistent('Close');
        });

        return redirect()->route('relatedpartytransaction.edit', $request->claim_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RelatedParty  $relatedParty
     * @return \Illuminate\Http\Response
     */
    public function show(RelatedParty $relatedParty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RelatedParty  $relatedParty
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $apps = DB::table('approved_apps_details as a')
            ->leftJoin('claims_masters as cm', 'cm.app_id', '=', 'a.id')
            ->where('cm.created_by', Auth::user()->id)
            ->where('cm.id', $id)
            ->whereNotNull('a.approval_dt')
            ->select('a.id as app_id', 'cm.id as claim_id')->first();
        $id = $apps->claim_id;

        $related_party = RelatedParty::where('claim_id', $id)->where('created_by', Auth::user()->id)->where('app_id', $apps->app_id)->OrderBy('related_prt_id', 'ASC')->get()->toArray();
        $pending = ClaimRptPendingDispute::where('claim_id', $id)->where('created_by', Auth::user()->id)->where('app_id', $apps->app_id)->orderby('id')->get();
        $consi = ClaimRptConsideration::where('claim_id', $id)->where('created_by', Auth::user()->id)->where('app_id', $apps->app_id)->first();
        //    dd($consi);
        $price = ClaimRptPriceMechanism::where('claim_id', $id)->where('created_by', Auth::user()->id)->where('app_id', $apps->app_id)->first();
        $com_act = ClaimRptCompanyAct::where('claim_id', $id)->where('created_by', Auth::user()->id)->where('app_id', $apps->app_id)->orderby('id')->get();
        $user_response = ClaimQuestionUserResponse::where('claim_id', $id)->where('created_by', Auth::user()->id)->where('app_id', $apps->app_id)->select('ques_id', 'response')->get()->toArray();
        //    dd($user_response);
        $pending_res = ClaimRptPendingDispute::where('claim_id', $id)->where('created_by', Auth::user()->id)->where('app_id', $apps->app_id)->first();
        $com_act_res = ClaimRptCompanyAct::where('claim_id', $id)->where('created_by', Auth::user()->id)->where('app_id', $apps->app_id)->first();


        return view('user.claims.relatedpartytransaction_edit', compact('apps', 'related_party', 'pending', 'consi', 'price', 'com_act', 'pending_res', 'com_act_res', 'user_response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RelatedParty  $relatedParty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RelatedParty $relatedParty)
    {
        //
        DB::transaction(function () use ($request) {

            // dd($request);

            foreach ($request->ques as $key => $ques) {
                $response = ClaimQuestionUserResponse::where('ques_id', $request->ques[$key])->where('claim_id', $request->claim_id)->first();

                $response->fill([
                    'response' => $request->problem[$key],
                ]);
                $response->save();
            }
            foreach ($request->app_num as $rtp) {

                if (array_key_exists('id', $rtp)) {
                    $related = RelatedParty::where('claim_id', $request->claim_id)->where('id', $rtp['id'])->where('app_id', $request->app_id)->first();

                    $related->fill([
                        'prt_id' => $rtp['prt_id'],
                        'nature_name' => $rtp['prt_name'],
                        'fy_statement' => $rtp['fy_statement'],
                        'CEB' => $rtp['3CEB'],
                        'ceb_amount' => $rtp['3CEB_A'],
                        '3CD' => $rtp['3CD'],
                        'cd_type' => $rtp['cd_type'],
                        'updated_at' => Carbon::now(),
                    ]);
                    $related->save();
                } else {
                    RelatedParty::create([
                        'app_id' => $request->app_id,
                        'claim_id' => $request->claim_id,
                        'created_by' => Auth::user()->id,
                        'related_prt_id' => $rtp['prt_id'],
                        'nature_name' => $rtp['prt_name'],
                        'fy_statement' => $rtp['fy_statement'],
                        '3CEB' => $rtp['3CEB'],
                        'ceb_amount' => $rtp['3CEB_A'],
                        'cd_type' => $rtp['cd_type'],
                        '3CD' => $rtp['3CD'],
                    ]);
                }
            }

            if ($request->problem[20] == 'Y' && $request->ans20 == 'Y') {
                foreach ($request->pendingdispute as $pending) {
                    if (array_key_exists('id', $pending)) {
                        if (array_key_exists('doc', $pending)) {
                            $pend = ClaimRptPendingDispute::where('claim_id', $request->claim_id)->where('id', $pending['id'])->where('app_id', $request->app_id)->first();

                            $doc = DocumentUploads::where('app_id', $request->app_id)->where('id', $pend->upload_id)->where('doc_id', 401)->first();
                            $doc->mime = $pending['doc']->getMimeType();
                            $doc->file_size = $pending['doc']->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $pending['doc']->getClientOriginalName();
                            $doc->uploaded_file = fopen($pending['doc']->getRealPath(), 'r');
                            $doc->save();

                            $pend->fill([
                                'year' => $pending['year'],
                                'forum_name' => $pending['forum_name'],
                                'amt' => $pending['amt'],
                                'dispute' => $pending['dispute'],
                                'que_id' => 20,
                                'upload_id' => $doc->id,
                                'response' => $request->problem[20],
                                'updated_at' => Carbon::now(),
                            ]);
                            $pend->save();
                        } else {
                            $pend = ClaimRptPendingDispute::where('claim_id', $request->claim_id)->where('id', $pending['id'])->where('app_id', $request->app_id)->first();
                            $pend->fill([
                                'year' => $pending['year'],
                                'forum_name' => $pending['forum_name'],
                                'amt' => $pending['amt'],
                                'dispute' => $pending['dispute'],
                                'que_id' => 20,
                                'response' => $request->problem[20],
                                'updated_at' => Carbon::now(),
                            ]);
                            $pend->save();
                        }
                    } else {
                        if (array_key_exists('doc', $pending)) {
                            $doc = new DocumentUploads;
                            $doc->app_id = $request->app_id;
                            $doc->doc_id = 401;
                            $doc->mime = $pending['doc']->getMimeType();
                            $doc->file_size = $pending['doc']->getSize();
                            $doc->updated_at = Carbon::now();
                            $doc->created_at = Carbon::now();
                            $doc->file_name = $pending['doc']->getClientOriginalName();
                            $doc->uploaded_file = fopen($pending['doc']->getRealPath(), 'r');
                            $doc->save();
                            ClaimRptPendingDispute::create([
                                'app_id' => $request->app_id,
                                'claim_id' => $request->claim_id,
                                'created_by' => Auth::user()->id,
                                'year' => $pending['year'],
                                'forum_name' => $pending['forum_name'],
                                'amt' => $pending['amt'],
                                'dispute' => $pending['dispute'],
                                'que_id' => 20,
                                'upload_id' => $doc->id,
                                'response' => $request->problem[20],
                            ]);
                        } else {
                            alert()->success('File missing', 'Warning!')->persistent('Close');
                            return redirect()->route('relatedpartytransaction.edit', $request->claim_id);
                        }
                    }
                }
            } elseif ($request->problem[20] == 'N' && $request->ans20 == 'Y') {
                ClaimRptPendingDispute::where('claim_id', $request->claim_id)->where('que_id', $request->ques[20])->delete();
            } elseif ($request->problem[20] == 'Y' && $request->ans20 == 'N') {
                foreach ($request->pendingdispute as $pending) {
                    if (array_key_exists('doc', $pending)) {
                        $doc = new DocumentUploads;
                        $doc->app_id = $request->app_id;
                        $doc->doc_id = 401;
                        $doc->user_id = Auth::user()->id;
                        $doc->mime = $pending['doc']->getMimeType();
                        $doc->file_size = $pending['doc']->getSize();
                        $doc->updated_at = Carbon::now();
                        $doc->created_at = Carbon::now();
                        $doc->file_name = $pending['doc']->getClientOriginalName();
                        $doc->uploaded_file = fopen($pending['doc']->getRealPath(), 'r');
                        $doc->save();

                        ClaimRptPendingDispute::create([
                            'app_id' => $request->app_id,
                            'claim_id' => $request->claim_id,
                            'created_by' => Auth::user()->id,
                            'year' => $pending['year'],
                            'forum_name' => $pending['forum_name'],
                            'amt' => $pending['amt'],
                            'dispute' => $pending['dispute'],
                            'que_id' => 20,
                            'upload_id' => $doc->id,
                            'response' => $request->problem[20],
                        ]);
                    }else{
                        $response = ClaimQuestionUserResponse::where('ques_id', $request->ques[20])->where('claim_id', $request->claim_id)->first();

                        $response->fill([
                            'response' =>'N',
                        ]);
                        $response->save();
                        alert()->success('File missing', 'Warning!')->persistent('Close');
                        return redirect()->route('relatedpartytransaction.edit', $request->claim_id);
                    }
                }
            }

            if ($request->problem[21] == 'Y' && $request->ans21 == 'Y') {
                foreach ($request->company_data as  $v) {

                    if (array_key_exists('id', $v)) {
                        $act = ClaimRptCompanyAct::where('claim_id', $request->claim_id)->where('id', $v['id'])->where('app_id', $request->app_id)->first();

                        $act->fill([
                            'authority' => $v['authority'],
                            'approval_dt' => $v['approval_dt'],
                            'pricing' => $v['pricing'],
                            'tran_nature' => $v['tran_nature'],
                            'que_id' => 21,
                            'response' => $request->problem[21],
                            'updated_at' => Carbon::now(),
                        ]);
                        $act->save();
                    } else {
                        ClaimRptCompanyAct::create([
                            'app_id' => $request->app_id,
                            'claim_id' => $request->claim_id,
                            'created_by' => Auth::user()->id,
                            'authority' => $v['authority'],
                            'approval_dt' => $v['approval_dt'],
                            'pricing' => $v['pricing'],
                            'tran_nature' => $v['tran_nature'],
                            'que_id' => 21,
                            'response' => $request->problem[21],
                        ]);
                    }
                }
            } elseif ($request->problem[21] == 'N' && $request->ans21 == 'Y') {
                ClaimRptCompanyAct::where('claim_id', $request->claim_id)->where('que_id', $request->ques[21])->delete();
            }elseif ($request->problem[21] == 'Y' && $request->ans21 == 'N') {
                foreach ($request->company_data as  $v) {
                    ClaimRptCompanyAct::create([
                        'app_id' => $request->app_id,
                        'claim_id' => $request->claim_id,
                        'created_by' => Auth::user()->id,
                        'authority' => $v['authority'],
                        'approval_dt' => $v['approval_dt'],
                        'pricing' => $v['pricing'],
                        'tran_nature' => $v['tran_nature'],
                        'que_id' => 21,
                        'response' => $request->problem[21],
                    ]);
                }
            }


            if ($request->problem[22] == 'Y' && $request->ans22 == 'Y') {
                foreach ($request->consideration as $consi) {
                    if (array_key_exists('cd_upload_id', $consi) && array_key_exists('cd', $consi)) {
                        $cd_doc = DocumentUploads::where('app_id', $request->app_id)->where('id', $consi['cd_upload_id'])->where('doc_id', 402)->first();
                        $cd_doc->app_id = $request->app_id;
                        $cd_doc->doc_id = 402;
                        $cd_doc->mime = $consi['cd']->getMimeType();
                        $cd_doc->file_size = $consi['cd']->getSize();
                        $cd_doc->updated_at = Carbon::now();
                        $cd_doc->created_at = Carbon::now();
                        $cd_doc->file_name = $consi['cd']->getClientOriginalName();
                        $cd_doc->uploaded_file = fopen($consi['cd']->getRealPath(), 'r');
                        $cd_doc->save();
                    } else {
                        if (array_key_exists('cd', $consi)) {
                            $cd_doc = new DocumentUploads;
                            $cd_doc->app_id = $request->app_id;
                            $cd_doc->doc_id = 402;
                            $cd_doc->user_id = Auth::user()->id;
                            $cd_doc->mime = $consi['cd']->getMimeType();
                            $cd_doc->file_size = $consi['cd']->getSize();
                            $cd_doc->updated_at = Carbon::now();
                            $cd_doc->created_at = Carbon::now();
                            $cd_doc->file_name = $consi['cd']->getClientOriginalName();
                            $cd_doc->uploaded_file = fopen($consi['cd']->getRealPath(), 'r');
                            $cd_doc->save();
                        }
                    }
                    if (array_key_exists('ceb_upload_id', $consi) && array_key_exists('ceb', $consi)) {

                        $ceb_doc = DocumentUploads::where('app_id', $request->app_id)->where('id', $consi['ceb_upload_id'])->where('doc_id', 403)->first();
                        $ceb_doc->app_id = $request->app_id;

                        $ceb_doc->doc_id = 403;
                        $ceb_doc->mime = $consi['ceb']->getMimeType();
                        $ceb_doc->file_size = $consi['ceb']->getSize();
                        $ceb_doc->updated_at = Carbon::now();
                        $ceb_doc->created_at = Carbon::now();
                        $ceb_doc->file_name = $consi['ceb']->getClientOriginalName();
                        $ceb_doc->uploaded_file = fopen($consi['ceb']->getRealPath(), 'r');
                        $ceb_doc->save();
                    } else {
                        if (array_key_exists('ceb', $consi)) {
                            $ceb_doc = new DocumentUploads;
                            $ceb_doc->app_id = $request->app_id;
                            $ceb_doc->doc_id = 403;
                            $ceb_doc->user_id = Auth::user()->id;
                            $ceb_doc->mime = $consi['ceb']->getMimeType();
                            $ceb_doc->file_size = $consi['ceb']->getSize();
                            $ceb_doc->updated_at = Carbon::now();
                            $ceb_doc->created_at = Carbon::now();
                            $ceb_doc->file_name = $consi['ceb']->getClientOriginalName();
                            $ceb_doc->uploaded_file = fopen($consi['ceb']->getRealPath(), 'r');
                            $ceb_doc->save();
                        }
                    }

                    if (array_key_exists('tax_upload_id', $consi) && array_key_exists('tax', $consi)) {
                        $tax_doc = DocumentUploads::where('app_id', $request->app_id)->where('id', $consi['tax_upload_id'])->where('doc_id', 404)->first();

                        $tax_doc->app_id = $request->app_id;
                        $tax_doc->doc_id = 404;
                        $tax_doc->mime = $consi['tax']->getMimeType();
                        $tax_doc->file_size = $consi['tax']->getSize();
                        $tax_doc->updated_at = Carbon::now();
                        $tax_doc->created_at = Carbon::now();
                        $tax_doc->file_name = $consi['tax']->getClientOriginalName();
                        $tax_doc->uploaded_file = fopen($consi['tax']->getRealPath(), 'r');
                        $tax_doc->save();
                    } else {
                        if (array_key_exists('tax', $consi)) {
                            $tax_doc = new DocumentUploads;
                            $tax_doc->app_id = $request->app_id;
                            $tax_doc->user_id = Auth::user()->id;
                            $tax_doc->doc_id = 404;
                            $tax_doc->mime = $consi['tax']->getMimeType();
                            $tax_doc->file_size = $consi['tax']->getSize();
                            $tax_doc->updated_at = Carbon::now();
                            $tax_doc->created_at = Carbon::now();
                            $tax_doc->file_name = $consi['tax']->getClientOriginalName();
                            $tax_doc->uploaded_file = fopen($consi['tax']->getRealPath(), 'r');
                            $tax_doc->save();
                        }
                    }

                }

                $consi = ClaimRptConsideration::where('claim_id', $request->claim_id)->where('created_by', Auth::user()->id)->where('app_id', $request->app_id)->first();

                if ($consi != null) {
                    ClaimRptConsideration::where('claim_id', $request->claim_id)->where('app_id', $request->app_id)->where('id', $request->consi_id)->update([
                        'cd_doc_id' => !empty($cd_doc->doc_id) ? $cd_doc->doc_id : 403,
                        'cd_upload_id' => !empty($cd_doc->id) ? $cd_doc->id : $consi['cd_upload_id'],
                        'ceb_doc_id' => !empty($ceb_doc->doc_id) ? $ceb_doc->doc_id : 404,
                        'ceb_upload_id' => !empty($ceb_doc->id) ? $ceb_doc->id : $consi['ceb_upload_id'],
                        'tax_doc_id' => !empty($tax_doc->doc_id) ? $tax_doc->doc_id : 405,
                        'tax_upload_id' => !empty($tax_doc->id) ? $tax_doc->id : $consi['tax_upload_id'],
                        'que_id' => 22,
                        'response' => $request->problem[22],
                        'sub_response' => $request->problem[23],
                        'updated_at' => Carbon::now(),
                    ]);
                } else {
                    $claimconsideration = new ClaimRptConsideration;

                    $claimconsideration->fill([
                        'app_id' => $request->app_id,
                        'claim_id' => $request->claim_id,
                        'created_by' => Auth::user()->id,
                        'cd_doc_id' => 402,
                        'cd_upload_id' => $cd_doc->id,
                        'ceb_doc_id' => 403,
                        'ceb_upload_id' => $ceb_doc->id,
                        'tax_doc_id' => 404,
                        'tax_upload_id' => $tax_doc->id,
                        'sub_response' => $request->problem[23],
                        'que_id' => 22,
                        'response' => $request->problem[22],
                    ]);
                    $claimconsideration->save();
                }
            } elseif ($request->problem[22] == 'N'  && $request->ans22 == 'Y') {
                ClaimRptConsideration::where('claim_id', $request->claim_id)->where('que_id', $request->ques[22])->delete();
            }elseif ($request->problem[22] == 'Y' && $request->ans21 == 'N') {
                foreach ($request->consideration as $consi) {

                    if ($consi['cd']) {
                        $cd_doc = new DocumentUploads;
                        $cd_doc->app_id = $request->app_id;
                        $cd_doc->doc_id = 402;
                        $cd_doc->user_id = Auth::user()->id;
                        $cd_doc->mime = $consi['cd']->getMimeType();
                        $cd_doc->file_size = $consi['cd']->getSize();
                        $cd_doc->updated_at = Carbon::now();
                        $cd_doc->created_at = Carbon::now();
                        $cd_doc->file_name = $consi['cd']->getClientOriginalName();
                        $cd_doc->uploaded_file = fopen($consi['cd']->getRealPath(), 'r');
                        $cd_doc->save();
                    }
                    if ($consi['ceb']) {
                        $ceb_doc = new DocumentUploads;
                        $ceb_doc->app_id = $request->app_id;
                        $ceb_doc->doc_id = 403;
                        $ceb_doc->user_id = Auth::user()->id;
                        $ceb_doc->mime = $consi['ceb']->getMimeType();
                        $ceb_doc->file_size = $consi['ceb']->getSize();
                        $ceb_doc->updated_at = Carbon::now();
                        $ceb_doc->created_at = Carbon::now();
                        $ceb_doc->file_name = $consi['ceb']->getClientOriginalName();
                        $ceb_doc->uploaded_file = fopen($consi['ceb']->getRealPath(), 'r');
                        $ceb_doc->save();
                    }
                    if ($consi['tax']) {
                        $tax_doc = new DocumentUploads;
                        $tax_doc->app_id = $request->app_id;
                        $tax_doc->user_id = Auth::user()->id;
                        $tax_doc->doc_id = 404;
                        $tax_doc->mime = $consi['tax']->getMimeType();
                        $tax_doc->file_size = $consi['tax']->getSize();
                        $tax_doc->updated_at = Carbon::now();
                        $tax_doc->created_at = Carbon::now();
                        $tax_doc->file_name = $consi['tax']->getClientOriginalName();
                        $tax_doc->uploaded_file = fopen($consi['tax']->getRealPath(), 'r');
                        $tax_doc->save();
                    }
                }
                $claimconsideration = new ClaimRptConsideration;

                $claimconsideration->fill([
                    'app_id' => $request->app_id,
                    'claim_id' => $request->claim_id,
                    'created_by' => Auth::user()->id,
                    'cd_doc_id' => 402,
                    'cd_upload_id' => $cd_doc->id,
                    'ceb_doc_id' => 403,
                    'ceb_upload_id' => $ceb_doc->id,
                    'tax_doc_id' => 404,
                    'tax_upload_id' => $tax_doc->id,
                    'sub_response' => $request->problem[22],
                    'que_id' => 22,
                    'response' => $request->problem[22],
                ]);
                $claimconsideration->save();
            }

            // if($request->problem[23]=='Y')
            // {
            //     foreach ($request->pricing_mech as $price)
            //     {
            //         if(array_key_exists('doc_upload_id',$price)){
            //             $doc=DocumentUploads::where('app_id',$request->app_id)->where('id',$price['doc_upload_id'])->where('doc_id',405)->first();
            //             $doc->app_id=$request->app_id;
            //             $doc->doc_id = 405;
            //             $doc->mime = $price['doc']->getMimeType();
            //             $doc->file_size = $price['doc']->getSize();
            //             $doc->updated_at = Carbon::now();
            //             $doc->created_at = Carbon::now();
            //             $doc->file_name = $price['doc']->getClientOriginalName();
            //             $doc->uploaded_file = fopen($price['doc']->getRealPath(), 'r');
            //             $doc->save();

            //             $p=ClaimRptPriceMechanism::where('claim_id',$request->claim_id)->where('app_id',$request->app_id)->where('id',$price['id'])->first();

            //             $p->fill([
            //                     'doc_id'=>$doc->doc_id,
            //                     'upload_id'=>$doc->id,
            //                     'que_id'=>23,
            //                     'response'=>$request->problem[23],
            //                     'updated_at'=>Carbon::now(),
            //                 ]);
            //             $p->save();
            //         }else{
            //             $doc = new DocumentUploads;
            //             $doc->app_id=$request->app_id;
            //             $doc->doc_id = 405;
            //             $doc->user_id=Auth::user()->id;
            //             $doc->mime = $price['doc']->getMimeType();
            //             $doc->file_size = $price['doc']->getSize();
            //             $doc->updated_at = Carbon::now();
            //             $doc->created_at = Carbon::now();
            //             $doc->file_name = $price['doc']->getClientOriginalName();
            //             $doc->uploaded_file = fopen($price['doc']->getRealPath(), 'r');
            //             $doc->save();

            //             ClaimRptPriceMechanism::create([
            //                 'app_id'=>$request->app_id,
            //                 'claim_id'=>$request->claim_id,
            //                 'created_by'=>Auth::user()->id,
            //                 'doc_id'=>405,
            //                 'upload_id'=>$doc->id,
            //                 'que_id'=>23,
            //                 'response'=>$request->problem[23],
            //             ]);
            //         }

            //     }
            // }elseif($request->problem[23]=='N')
            // {
            //     ClaimRptPriceMechanism::where('claim_id',$request->claim_id)->where('que_id',$request->ques[23])->delete();

            // }

            alert()->success('Claim Related Party Details Save', 'Success!')->persistent('Close');
        });

        return redirect()->route('relatedpartytransaction.edit', $request->claim_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RelatedParty  $relatedParty
     * @return \Illuminate\Http\Response
     */
    public function destroy(RelatedParty $relatedParty)
    {
        //
    }

    public function sales()
    {
        // dd("hello");
        return view('user.claims.relatedpartytransaction');
    }
}
