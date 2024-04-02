<?php

namespace App\Http\Controllers\User\Claims;

use App\ClaimProjectDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClaimMaster;
use App\ClaimProjectDetQues1;
use App\ClaimProjectDetQues2;
use App\ClaimProjectDetQues3;
use App\ClaimProjectDetQues4;
use App\ClaimProjectDetQues5;
use App\ClaimProjectDetQues6;
use App\ClaimProjectDetQues7;
use App\ClaimProjectDetQues8;
use App\ClaimQuestionUserResponse;
use DB;
use Auth;
use App\DocumentUploads;
use Carbon\Carbon;
use App\ClaimDocProjectDet;
use App\ClaimStage;

class ClaimProjectDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('user.claims.project_detail');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $stage = ClaimStage::where('claim_id', $id)->where('stages', 5)->first();
        if  ($stage) {
            return redirect()->route('claimprojectdetail.edit',$stage->claim_id);
        }

        $claimMast=ClaimMaster::where('id',$id)->first();
        
        return view('user.claims.project_detail',compact('id','claimMast'));
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
            foreach($request->question as $key=>$ques){
               
                $claimQuestionUserResponse = new ClaimQuestionUserResponse;
                $claimQuestionUserResponse->app_id=$request->app_id;
                $claimQuestionUserResponse->claim_id=$request->claim_id;
                $claimQuestionUserResponse->created_by=Auth::user()->id;
                $claimQuestionUserResponse->ques_id=$ques;
                $claimQuestionUserResponse->response=$request->problem[$key];
                $claimQuestionUserResponse->save();  
            }
            // dd($request);
          
            $doctypes=DB::table('document_master')->wherein('doc_id',['1033','1034','1036','1037','1038','1039','1040','1041','1042','1043'])->pluck('doc_type','doc_id')->toArray();
            
          
            foreach ($doctypes as $docid => $doctype) {
                // dd($docid);
                if ($request->hasfile($doctype)) { 
                    $newDoc = $request->file($doctype);
                    $doc = DocumentUploads::where('app_id', $request->app_id)->where('doc_id', $docid)->first();
                    
                    if (empty($doc)) {
                        $doc = new DocumentUploads;
                        $doc->app_id = $request->app_id;
                        $doc->doc_id = $docid;
                    }
                    $doc->mime = $newDoc->getMimeType();
                    $doc->file_size = $newDoc->getSize();
                    $doc->file_name = $newDoc->getClientOriginalName();
                    $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                    $doc->user_id = Auth::user()->id;
                    $doc->updated_at = Carbon::now();
                    $doc->save();

                    $claimDocProjectDet = new ClaimDocProjectDet;
                        $claimDocProjectDet->app_id=$request->app_id;
                        $claimDocProjectDet->claim_id=$request->claim_id;
                        $claimDocProjectDet->created_by=Auth::user()->id;
                        $claimDocProjectDet->question_id=$request->question[$doctype];
                        $claimDocProjectDet->doc_id=$docid;
                        $claimDocProjectDet->upload_id=$doc->id;
                        $claimDocProjectDet->section='Project Details';
                    $claimDocProjectDet->save();
                }
            }
            // for($i=1; $i<=11; $i++)
            // {
           
            //     $response_question = 'question_'.$i;
            //     if($i==1)
            //     {
            //         $response_problem = 'problem';
            //     }
            //     else{
            //         $response_problem = 'problem'.$i;
            //     }

            //     if($i != 3){
            //         $claimQuestionUserResponse = new ClaimQuestionUserResponse;
            //         $claimQuestionUserResponse->app_id=$request->app_id;
            //         $claimQuestionUserResponse->claim_id=$request->claim_id;
            //         $claimQuestionUserResponse->created_by=Auth::user()->id;
            //         $claimQuestionUserResponse->ques_id=$request->$response_question;
            //         $claimQuestionUserResponse->response=$request->$response_problem;
            //         $claimQuestionUserResponse->save();  
            //     }    
                

            //     if($request->$response_problem=='Y')
            //     {
            //         if($i==1)
            //         {
            //             $problem_file = 'problem_file';
            //         }else{
            //             $problem_file = 'problem'.$i.'_file';
            //         }    

            //         $doc_types = DB::table('document_master')->where('doc_type',$problem_file)->first();

                    
            //         $doc = new DocumentUploads;
            //         $doc->app_id=$request->app_id;
            //         $doc->doc_id = $doc_types->doc_id;
            //         $doc->mime = $request[$problem_file]->getMimeType();
            //         $doc->file_size = $request[$problem_file]->getSize();
            //         $doc->updated_at = Carbon::now();
            //         $doc->created_at = Carbon::now();
            //         $doc->file_name = $request[$problem_file]->getClientOriginalName();
            //         $doc->uploaded_file = fopen($request[$problem_file]->getRealPath(), 'r');
            //         $doc->save();

            //         $claimDocProjectDet = new ClaimDocProjectDet;
            //             $claimDocProjectDet->app_id=$request->app_id;
            //             $claimDocProjectDet->claim_id=$request->claim_id;
            //             $claimDocProjectDet->created_by=Auth::user()->id;
            //             $claimDocProjectDet->question_id=$request->question_1;
            //             $claimDocProjectDet->doc_id=$doc_types->doc_id;
            //             $claimDocProjectDet->upload_id=$doc->id;
            //             $claimDocProjectDet->section='Project Details';
            //         $claimDocProjectDet->save();
            //     }

               
            //     if($i == 8){
            //         if($request->$response_problem=='N'){
            //             if($i==1)
            //             {
            //                 $problem_file = 'problem_file';
            //             }else{
            //                 $problem_file = 'problem'.$i.'_file';
            //             }    
    
            //             $doc_types = DB::table('document_master')->where('doc_type',$problem_file)->first();
    
                        
            //             $doc = new DocumentUploads;
            //             $doc->app_id=$request->app_id;
            //             $doc->doc_id = $doc_types->doc_id;
            //             $doc->mime = $request[$problem_file]->getMimeType();
            //             $doc->file_size = $request[$problem_file]->getSize();
            //             $doc->updated_at = Carbon::now();
            //             $doc->created_at = Carbon::now();
            //             $doc->file_name = $request[$problem_file]->getClientOriginalName();
            //             $doc->uploaded_file = fopen($request[$problem_file]->getRealPath(), 'r');
            //             $doc->save();
    
            //             $claimDocProjectDet = new ClaimDocProjectDet;
            //                 $claimDocProjectDet->app_id=$request->app_id;
            //                 $claimDocProjectDet->claim_id=$request->claim_id;
            //                 $claimDocProjectDet->created_by=Auth::user()->id;
            //                 $claimDocProjectDet->question_id=$request->question_1;
            //                 $claimDocProjectDet->doc_id=$doc_types->doc_id;
            //                 $claimDocProjectDet->upload_id=$doc->id;
            //                 $claimDocProjectDet->section='Project Details';
            //             $claimDocProjectDet->save();
            //         }
            //     }
            //     if($i == 11 ){
            //         if($request->$response_problem=='N')
            //         {
            //             if($i==1)
            //             {
            //                 $problem_file = 'problem_file';
            //             }
            //             else{
                         
            //                 $problem_file = 'problem'.$i.'_file';
            //             }    

            //             $doc_types = DB::table('document_master')->where('doc_type',$problem_file)->first();
                        
            //             $doc = new DocumentUploads;
            //             $doc->app_id=$request->app_id;
            //             $doc->doc_id = $doc_types->doc_id;
            //             $doc->mime = $request[$problem_file]->getMimeType();
            //             $doc->file_size = $request[$problem_file]->getSize();
            //             $doc->updated_at = Carbon::now();
            //             $doc->created_at = Carbon::now();
            //             $doc->file_name = $request[$problem_file]->getClientOriginalName();
            //             $doc->uploaded_file = fopen($request[$problem_file]->getRealPath(), 'r');
            //             $doc->save();

            //             $claimDocProjectDet = new ClaimDocProjectDet;
            //                 $claimDocProjectDet->app_id=$request->app_id;
            //                 $claimDocProjectDet->claim_id=$request->claim_id;
            //                 $claimDocProjectDet->created_by=Auth::user()->id;
            //                 $claimDocProjectDet->question_id=$request->question_1;
            //                 $claimDocProjectDet->doc_id=$doc_types->doc_id;
            //                 $claimDocProjectDet->upload_id=$doc->id;
            //                 $claimDocProjectDet->section='Project Details';
            //             $claimDocProjectDet->save();


            //             if($i == 8){
            //                 $doc_types = DB::table('document_master')->where('doc_type',$problem_file)->first();
            //                 $doc = new DocumentUploads;
            //                 $doc->app_id=$request->app_id;
            //                 $doc->doc_id = $doc_types->doc_id;
            //                 $doc->mime = $request[$problem_file]->getMimeType();
            //                 $doc->file_size = $request[$problem_file]->getSize();
            //                 $doc->updated_at = Carbon::now();
            //                 $doc->created_at = Carbon::now();
            //                 $doc->file_name = $request[$problem_file]->getClientOriginalName();
            //                 $doc->uploaded_file = fopen($request[$problem_file]->getRealPath(), 'r');
            //                 $doc->save();

            //                 $claimDocProjectDet = new ClaimDocProjectDet;
            //                     $claimDocProjectDet->app_id=$request->app_id;
            //                     $claimDocProjectDet->claim_id=$request->claim_id;
            //                     $claimDocProjectDet->created_by=Auth::user()->id;
            //                     $claimDocProjectDet->question_id=$request->question_1;
            //                     $claimDocProjectDet->doc_id=$doc_types->doc_id;
            //                     $claimDocProjectDet->upload_id=$doc->id;
            //                     $claimDocProjectDet->section='Project Details';
            //                 $claimDocProjectDet->save();
            //             }
            //         }
            //     }
            // }    

            
            if($request->problem['problem_file']=='Y')
            {
                foreach($request->pendingdispute_ques as $quesval)
                {
                
                    $claimProjectDetQues1 = new ClaimProjectDetQues1;
                        $claimProjectDetQues1->app_id=$request->app_id;
                        $claimProjectDetQues1->claim_id=$request->claim_id;
                        $claimProjectDetQues1->created_by=Auth::user()->id;
                        $claimProjectDetQues1->question_id=$request->question['problem_file'];
                        $claimProjectDetQues1->name_of_lease=$quesval['nature_of_lease'];
                        $claimProjectDetQues1->asset_description=$quesval['asset_description'];
                        $claimProjectDetQues1->amnout=$quesval['amt'];
                    $claimProjectDetQues1->save();
                }    
            } 

            if($request->problem['problem2_file']=='Y')
            {
                foreach($request->pendingdispute_ques2 as $quesval2)
                {
                    $claimProjectDetQues2 = new ClaimProjectDetQues2;
                        $claimProjectDetQues2->app_id=$request->app_id;
                        $claimProjectDetQues2->claim_id=$request->claim_id;
                        $claimProjectDetQues2->created_by=Auth::user()->id;
                        $claimProjectDetQues2->question_id=$request->question['problem2_file'];
                        $claimProjectDetQues2->quest_particular=$quesval2['quest_particular'];
                        $claimProjectDetQues2->amnout=$quesval2['amt'];
                    $claimProjectDetQues2->save();
                }
            } 

           
            

            if($request->problem['problem4_file']=='Y')
            {
                foreach($request->pendingdispute_ques4 as $quesval4)
                {
                    $claimProjectDetQues4 = new ClaimProjectDetQues4;
                        $claimProjectDetQues4->app_id=$request->app_id;
                        $claimProjectDetQues4->claim_id=$request->claim_id;
                        $claimProjectDetQues4->created_by=Auth::user()->id;
                        $claimProjectDetQues4->question_id=$request->question['problem4_file'];
                        $claimProjectDetQues4->type_pm=$quesval4['type_pm'];
                        $claimProjectDetQues4->impot_dom=$quesval4['impot_dom'];
                        $claimProjectDetQues4->residual_life=$quesval4['residual_life'];
                        $claimProjectDetQues4->capitalized_value=$quesval4['capitalized_value'];
                        $claimProjectDetQues4->value_by_ce=$quesval4['value_by_ce'];
                        $claimProjectDetQues4->value_custom_rule=$quesval4['value_custom_rule'];
                        $claimProjectDetQues4->eligibilty_criteria=$quesval4['eligibilty_criteria'];
                    $claimProjectDetQues4->save();
                }
            } 

            if($request->problem['problem5_file']=='Y')
            {
                foreach($request->pendingdispute_ques5 as $quesval5)
                {
                    $claimProjectDetQues5 = new ClaimProjectDetQues5;
                        $claimProjectDetQues5->app_id=$request->app_id;
                        $claimProjectDetQues5->claim_id=$request->claim_id;
                        $claimProjectDetQues5->created_by=Auth::user()->id;
                        $claimProjectDetQues5->question_id=$request->question['problem5_file'];
                        $claimProjectDetQues5->nature_of_utility=$quesval5['nature_of_utility'];
                        $claimProjectDetQues5->intended_use=$quesval5['intended_use'];
                        $claimProjectDetQues5->amt=$quesval5['amt'];
                    $claimProjectDetQues5->save();
                }
            } 

            if($request->problem['problem6_file']=='Y')
            {
                foreach($request->pendingdispute_ques6 as $quesval6)
                {
                    $claimProjectDetQues6 = new ClaimProjectDetQues6;
                        $claimProjectDetQues6->app_id=$request->app_id;
                        $claimProjectDetQues6->claim_id=$request->claim_id;
                        $claimProjectDetQues6->created_by=Auth::user()->id;
                        $claimProjectDetQues6->question_id=$request->question['problem6_file'];
                        $claimProjectDetQues6->name_of_pli_scheme=$quesval6['name_of_pli_scheme'];
                        $claimProjectDetQues6->amt=$quesval6['amt'];
                    $claimProjectDetQues6->save();
                }
            } 

            if($request->problem['problem7_file']=='Y')
            {
                foreach($request->pendingdispute_ques7 as $quesval7)
                {
                    $claimProjectDetQues7 = new ClaimProjectDetQues7;
                        $claimProjectDetQues7->app_id=$request->app_id;
                        $claimProjectDetQues7->claim_id=$request->claim_id;
                        $claimProjectDetQues7->created_by=Auth::user()->id;
                        $claimProjectDetQues7->question_id=$request->question['problem7_file'];
                        $claimProjectDetQues7->nature_of_asset=$quesval7['nature_of_asset'];
                        $claimProjectDetQues7->amt=$quesval7['amt'];
                        $claimProjectDetQues7->year_dt=$quesval7['year_dt'];
                        $claimProjectDetQues7->reason_of_discard=$quesval7['reason_of_discard'];
                    $claimProjectDetQues7->save();
                }
            } 

            if($request->problem['problem8_file']=='N')
            {
                foreach($request->pendingdispute_ques8 as $quesval8)
                {
                    $claimProjectDetQues8 = new ClaimProjectDetQues8;
                        $claimProjectDetQues8->app_id=$request->app_id;
                        $claimProjectDetQues8->claim_id=$request->claim_id;
                        $claimProjectDetQues8->created_by=Auth::user()->id;
                        $claimProjectDetQues8->question_id=$request->question['problem8_file'];
                        $claimProjectDetQues8->nature_of_asset=$quesval8['nature_of_asset'];
                        $claimProjectDetQues8->amt=$quesval8['amt'];
                        $claimProjectDetQues8->nature_of_use=$quesval8['nature_of_use'];
                    $claimProjectDetQues8->save();
                }
               
            } 
            ClaimStage::create([
                'app_id'=>$request->app_id,
                'created_by' =>Auth::user()->id,
                'claim_id' =>$request->claim_id,
                'stages' =>5,
                'status'=>'D'
                ]);
            alert()->success('Claim Project Details Saved', 'Success!')->persistent('Close');
        });
      
        return redirect()->route('claimprojectdetail.edit',$request->claim_id);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClaimProjectDetail  $claimProjectDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ClaimProjectDetail $claimProjectDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClaimProjectDetail  $claimProjectDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        // $claimMaster = ClaimMaster::where('id', $id)->where('status', 'D')->first();
       
        // if (!$claimMaster) {
        //     alert()->error('No Draft Claim Application!', 'Attention!')->persistent('Close');
        //     return redirect()->route('claims.index',$claimMaster->fy);
        // }
        
        // $claimStage = $claimMaster->stages->where('claim_id', $id)->where('stages',5)->first();

       

        $contents = ClaimDocProjectDet::where('claim_id', $id)->orderby('doc_id')->get();

        $docs = [];
        $docids = [];
        foreach($contents as $content)
        {
            $docids[] = $content->doc_id;
        }

        $projectDetRes1=ClaimProjectDetQues1::where('claim_id',$id)->get();
        $projectDetRes2=ClaimProjectDetQues2::where('claim_id',$id)->get()->toArray();
       
        $projectDetRes4=ClaimProjectDetQues4::where('claim_id',$id)->get();
        $projectDetRes5=ClaimProjectDetQues5::where('claim_id',$id)->get();
        $projectDetRes6=ClaimProjectDetQues6::where('claim_id',$id)->get();
        $projectDetRes7=ClaimProjectDetQues7::where('claim_id',$id)->get();
        $projectDetRes8=ClaimProjectDetQues8::where('claim_id',$id)->get();

        $claimMast=ClaimMaster::where('id',$id)->first();
        $response_question=ClaimQuestionUserResponse::where('claim_id',$id)->orderBy('ques_id','asc')->get();
        //dd($response_question);
        return view('user.claims.project_detail_edit',compact('id','claimMast','response_question','docids','contents'
        ,'projectDetRes1','projectDetRes2','projectDetRes4','projectDetRes5','projectDetRes6'
        ,'projectDetRes7','projectDetRes8'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClaimProjectDetail  $claimProjectDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClaimProjectDetail $claimProjectDetail)
    {
        DB::transaction(function () use ($request) {
            $doctypes=DB::table('document_master')->wherein('doc_id',['1033','1034','1036','1037','1038','1039','1040','1041','1042','1043'])->pluck('doc_type','doc_id')->toArray();
            
              
                // dd($request->problem);
                foreach($request->question as $key=>$ques){
                   
                    $response = ClaimQuestionUserResponse::where('ques_id',$ques)->where('claim_id',$request->claim_id)->first();
                        $response->fill([
                            'response'=>$request->problem[$key],
                        ]);
                    $response->save();  
                }
                 
                foreach ($doctypes as $docid => $doctype) {
                  
                    if ($request->hasfile($doctype)) { 
                        
                        $newDoc = $request->file($doctype);
                        $doc = DocumentUploads::where('app_id', $request->app_id)->where('doc_id', $docid)->first();
                        
                        if (empty($doc)) {
                            $doc = new DocumentUploads;
                            $doc->app_id = $request->app_id;
                            $doc->doc_id = $docid;
                        }
                        $doc->mime = $newDoc->getMimeType();
                        $doc->file_size = $newDoc->getSize();
                        $doc->file_name = $newDoc->getClientOriginalName();
                        $doc->uploaded_file = fopen($newDoc->getRealPath(), 'r');
                        $doc->user_id = Auth::user()->id;
                        $doc->updated_at = Carbon::now();
                        $doc->save();
                        
                        if(empty($request->upload_id[$doctype])){
                           
                            $claimDocProjectDet = new ClaimDocProjectDet;
                            $claimDocProjectDet->app_id=$request->app_id;
                            $claimDocProjectDet->claim_id=$request->claim_id;
                            $claimDocProjectDet->created_by=Auth::user()->id;
                            $claimDocProjectDet->question_id=$request->question[$doctype];
                            $claimDocProjectDet->doc_id=$docid;
                            $claimDocProjectDet->upload_id=$doc->id;
                            $claimDocProjectDet->section='Project Details';
                        $claimDocProjectDet->save();
                        }
                        
                    }
                }
                
                
    
            
                if($request->problem['problem_file']=='Y')
                {
                    foreach($request->pendingdispute_ques as $quesval)
                    {
                        if(isset($quesval['id'])!='')
                        {
                            $claimProjectDetQues1=ClaimProjectDetQues1::find($quesval['id']);
                                $claimProjectDetQues1->name_of_lease=$quesval['nature_of_lease'];
                                $claimProjectDetQues1->asset_description=$quesval['asset_description'];
                                $claimProjectDetQues1->amnout=$quesval['amt'];
                            $claimProjectDetQues1->save();
                        }
                        else{
                            $claimProjectDetQues1 = new ClaimProjectDetQues1;
                                $claimProjectDetQues1->app_id=$request->app_id;
                                $claimProjectDetQues1->claim_id=$request->claim_id;
                                $claimProjectDetQues1->created_by=Auth::user()->id;
                                $claimProjectDetQues1->question_id=$request->question['problem_file'];
                                $claimProjectDetQues1->name_of_lease=$quesval['nature_of_lease'];
                                $claimProjectDetQues1->asset_description=$quesval['asset_description'];
                                $claimProjectDetQues1->amnout=$quesval['amt'];
                            $claimProjectDetQues1->save();
                        }
                        
                    }    
                }elseif ($request->problem['problem_file']=='N') {

                    ClaimProjectDetQues1::where('claim_id',$request->claim_id)->where('question_id',$request->question['problem_file'])->delete();
                }
            
                if($request->problem['problem2_file']=='Y')
                {
                    foreach($request->pendingdispute_ques2 as $quesval2)
                    {
                        if(isset($quesval2['id'])!='')
                        {
                            $claimProjectDetQues2=ClaimProjectDetQues2::find($quesval2['id']);
                                $claimProjectDetQues2->quest_particular=$quesval2['quest_particular'];
                                $claimProjectDetQues2->amnout=$quesval2['amt'];
                            $claimProjectDetQues2->save();
                        }
                        else
                        {
                            $claimProjectDetQues2 = new ClaimProjectDetQues2;
                                $claimProjectDetQues2->app_id=$request->app_id;
                                $claimProjectDetQues2->claim_id=$request->claim_id;
                                $claimProjectDetQues2->created_by=Auth::user()->id;
                                $claimProjectDetQues2->question_id=$request->question['problem2_file'];
                                $claimProjectDetQues2->quest_particular=$quesval2['quest_particular'];
                                $claimProjectDetQues2->amnout=$quesval2['amt'];
                            $claimProjectDetQues2->save();
                        }
                    
                    }
                }elseif($request->problem['problem2_file']=='N'){
                    
                    ClaimProjectDetQues2::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->delete() ;
                        
                } 
    
    
                if($request->problem['problem4_file']=='Y')
                {
                    foreach($request->pendingdispute_ques4 as $quesval4)
                    {
                        if(isset($quesval4['id'])!='')
                        {
                            $claimProjectDetQues4=ClaimProjectDetQues4::find($quesval4['id']);
                                $claimProjectDetQues4->type_pm=$quesval4['type_pm'];
                                $claimProjectDetQues4->impot_dom=$quesval4['impot_dom'];
                                $claimProjectDetQues4->residual_life=$quesval4['residual_life'];
                                $claimProjectDetQues4->capitalized_value=$quesval4['capitalized_value'];
                                $claimProjectDetQues4->value_by_ce=$quesval4['value_by_ce'];
                                $claimProjectDetQues4->value_custom_rule=$quesval4['value_custom_rule'];
                                $claimProjectDetQues4->eligibilty_criteria=$quesval4['eligibilty_criteria'];
                            $claimProjectDetQues4->save();
                        }
                        else
                        {
                            $claimProjectDetQues4 = new ClaimProjectDetQues4;
                                $claimProjectDetQues4->app_id=$request->app_id;
                                $claimProjectDetQues4->claim_id=$request->claim_id;
                                $claimProjectDetQues4->created_by=Auth::user()->id;
                                $claimProjectDetQues4->question_id=$request->question['problem4_file'];
                                $claimProjectDetQues4->type_pm=$quesval4['type_pm'];
                                $claimProjectDetQues4->impot_dom=$quesval4['impot_dom'];
                                $claimProjectDetQues4->residual_life=$quesval4['residual_life'];
                                $claimProjectDetQues4->capitalized_value=$quesval4['capitalized_value'];
                                $claimProjectDetQues4->value_by_ce=$quesval4['value_by_ce'];
                                $claimProjectDetQues4->value_custom_rule=$quesval4['value_custom_rule'];
                                $claimProjectDetQues4->eligibilty_criteria=$quesval4['eligibilty_criteria'];
                            $claimProjectDetQues4->save();
                        }
                    
                    }
                }elseif($request->problem['problem4_file']=='N'){
                
                    ClaimProjectDetQues4::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->delete() ;
                } 
    
                if($request->problem['problem5_file']=='Y')
                {
                    foreach($request->pendingdispute_ques5 as $quesval5)
                    {
                        if(isset($quesval5['id'])!='')
                        {
                            $claimProjectDetQues5=ClaimProjectDetQues5::find($quesval5['id']);
                            $claimProjectDetQues5->nature_of_utility=$quesval5['nature_of_utility'];
                                $claimProjectDetQues5->intended_use=$quesval5['intended_use'];
                                $claimProjectDetQues5->amt=$quesval5['amt'];
                            $claimProjectDetQues5->save();
                        }
                        else
                        {
                            $claimProjectDetQues5 = new ClaimProjectDetQues5;
                                $claimProjectDetQues5->app_id=$request->app_id;
                                $claimProjectDetQues5->claim_id=$request->claim_id;
                                $claimProjectDetQues5->created_by=Auth::user()->id;
                                $claimProjectDetQues5->question_id=$request->question['problem5_file'];
                                $claimProjectDetQues5->nature_of_utility=$quesval5['nature_of_utility'];
                                $claimProjectDetQues5->intended_use=$quesval5['intended_use'];
                                $claimProjectDetQues5->amt=$quesval5['amt'];
                            $claimProjectDetQues5->save();
                        }
                    }
                }elseif($request->problem['problem5_file']=='N'){
                   
                    ClaimProjectDetQues5::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->delete();
                } 
    
                if($request->problem['problem6_file']=='Y')
                {
                    foreach($request->pendingdispute_ques6 as $quesval6)
                    {
                        if(isset($quesval6['id'])!='')
                        {
                            $claimProjectDetQues6=ClaimProjectDetQues6::find($quesval6['id']);
                            $claimProjectDetQues6->name_of_pli_scheme=$quesval6['name_of_pli_scheme'];
                                $claimProjectDetQues6->amt=$quesval6['amt'];
                            $claimProjectDetQues6->save();
                        }
                        else
                        {
                            $claimProjectDetQues6 = new ClaimProjectDetQues6;
                                $claimProjectDetQues6->app_id=$request->app_id;
                                $claimProjectDetQues6->claim_id=$request->claim_id;
                                $claimProjectDetQues6->created_by=Auth::user()->id;
                                $claimProjectDetQues6->question_id=$request->question['problem6_file'];
                                $claimProjectDetQues6->name_of_pli_scheme=$quesval6['name_of_pli_scheme'];
                                $claimProjectDetQues6->amt=$quesval6['amt'];
                            $claimProjectDetQues6->save();
                        }
                        
                    }
                }elseif($request->problem['problem6_file']=='N'){
                  
                    ClaimProjectDetQues6::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->delete();
                } 
    
                if($request->problem['problem7_file']=='Y')
                {
                    foreach($request->pendingdispute_ques7 as $quesval7)
                    {
                        if(isset($quesval7['id'])!='')
                        {
                            $claimProjectDetQues7=ClaimProjectDetQues7::find($quesval7['id']);
                            $claimProjectDetQues7->nature_of_asset=$quesval7['nature_of_asset'];
                                $claimProjectDetQues7->amt=$quesval7['amt'];
                                $claimProjectDetQues7->year_dt=$quesval7['year_dt'];
                                $claimProjectDetQues7->reason_of_discard=$quesval7['reason_of_discard'];
                            $claimProjectDetQues7->save();
                        }
                        else
                        {
                            $claimProjectDetQues7 = new ClaimProjectDetQues7;
                                $claimProjectDetQues7->app_id=$request->app_id;
                                $claimProjectDetQues7->claim_id=$request->claim_id;
                                $claimProjectDetQues7->created_by=Auth::user()->id;
                                $claimProjectDetQues7->question_id=$request->question['problem7_file'];
                                $claimProjectDetQues7->nature_of_asset=$quesval7['nature_of_asset'];
                                $claimProjectDetQues7->amt=$quesval7['amt'];
                                $claimProjectDetQues7->year_dt=$quesval7['year_dt'];
                                $claimProjectDetQues7->reason_of_discard=$quesval7['reason_of_discard'];
                            $claimProjectDetQues7->save();
                        }
                        
                    }
                }elseif($request->problem['problem7_file']=='N'){
                    
                    ClaimProjectDetQues7::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->delete();
                } 
    
                if($request->problem['problem8_file']=='N')
                {
                    foreach($request->pendingdispute_ques8 as $quesval8)
                    {
                        if(isset($quesval8['id'])!='')
                        {
                            $claimProjectDetQues8=ClaimProjectDetQues8::find($quesval8['id']);
                            $claimProjectDetQues8->nature_of_asset=$quesval8['nature_of_asset'];
                                $claimProjectDetQues8->amt=$quesval8['amt'];
                                $claimProjectDetQues8->nature_of_use=$quesval8['nature_of_use'];
                            $claimProjectDetQues8->save();
                        }
                        else
                        {
                            $claimProjectDetQues8 = new ClaimProjectDetQues8;
                                $claimProjectDetQues8->app_id=$request->app_id;
                                $claimProjectDetQues8->claim_id=$request->claim_id;
                                $claimProjectDetQues8->created_by=Auth::user()->id;
                                $claimProjectDetQues8->question_id=$request->question['problem8_file'];
                                $claimProjectDetQues8->nature_of_asset=$quesval8['nature_of_asset'];
                                $claimProjectDetQues8->amt=$quesval8['amt'];
                                $claimProjectDetQues8->nature_of_use=$quesval8['nature_of_use'];
                            $claimProjectDetQues8->save();
                        }    
                    }
                }elseif($request->problem['problem8_file'] == 'Y'){
                
                    ClaimProjectDetQues8::where('claim_id',$request->claim_id)->where('created_by',Auth::user()->id)->delete();
                    
                }
               
                alert()->success('Claim Project Details Updated', 'Success!')->persistent('Close');
            });
    
            return redirect()->route('claimprojectdetail.edit',$request->claim_id);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClaimProjectDetail  $claimProjectDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClaimProjectDetail $claimProjectDetail)
    {
        //
    }
}
