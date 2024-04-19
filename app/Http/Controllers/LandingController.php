<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LandingController extends Controller
{

    public function reg()
    {
        $users = DB::table('users')->where('isapproved','Y')->WhereNotIn('id',[2,20,21])->get();
        $products = DB::table('eligible_products')->get();
        foreach($users as $user)
               {
                   if($user->eligible_product!=""){
                  $pro = explode(",",$user->eligible_product);


                 $segs[] = DB::table('eligible_products')->select('target_segment')
                 ->whereIn('id', $pro)->distinct('target_segment')->get()->toArray();

                 }
            }
        return view('landing.reg-received', compact('segs'));
    }

    public function companyProductDoc($tar_seg_id)
    {
       
        $whereClauseTargetSegmentId='';

        if(isset($tar_seg_id) && $tar_seg_id!=0)
        {
            $whereClauseTargetSegmentId=" and aa.target_segment=$tar_seg_id";
        }

        if(isset($tar_seg_id) && $tar_seg_id!=0)
        {
           
            $applicant_com=DB::table('approved_apps')
                        ->join('users','users.id','=','approved_apps.created_by')
                        ->where('approved_apps.target_segment',$tar_seg_id)
                        ->where(DB::RAW("is_normal_user(users.id)"), 1)
                        ->select('approved_apps.*','users.name')
                        ->orderBy('users.name','ASC')
                        ->get();

            
            $approved_prods=DB::table('approved_products')->where('approved_products.target_id',$tar_seg_id)->orderBy('product','ASC')->get();
        }
        else{
           
            $applicant_com=DB::table('approved_apps')
                        ->join('users','users.id','=','approved_apps.created_by')
                        ->where(DB::RAW("is_normal_user(users.id)"), 1)
                        ->distinct('approved_apps.created_by','users.name')
                        ->select('users.id','users.name')
                        ->orderBy('users.name','ASC')
                        ->get();
            
            $approved_prods=DB::table('eligible_products')->orderBy('product','ASC')->get();
           
        }    

    
        $comp_wise_prod= '';
        $brochure_prod_data = DB::table('approved_apps_details as aad')
        ->join('eligible_products as ep', 'ep.id', '=', 'aad.eligible_product')
        ->join('brochure_uploads as bu', 'bu.product_id', '=',  'aad.eligible_product')
        ->where('aad.status','S')
        ->distinct('aad.id')
        ->get();
      
        $contents = DB::table('brochure_uploads as bu')
        ->distinct('bu.id')
        ->select('bu.id','bu.app_id','bu.product_id','bu.remarks','bu.prod_category','bu.other_file_name','bu.id as broch_doc_id','bu.websitelink')->get();
      
        $arr_brochure_product=array();
        foreach($contents as $doc_val)
        {
            $arr_brochure_product[$doc_val->app_id.'@_@'.$doc_val->product_id][]=$doc_val;
        }
       

       
        return view('landing.comp-wise-doc-new', compact('tar_seg_id','comp_wise_prod','applicant_com','approved_prods','arr_brochure_product','brochure_prod_data'));
        
       
    }

    public function companyWiseDoc($tar_seg_id)
    {
        $comp_wise_prod=DB::select("select distinct on (u.name,aa.target_segment,a.product_name) u.name,
        a.product_name,u.id
        from approved_apps aa
        left join users u on u.id=aa.created_by
        left join (select  productname as product_name, apd.app_id 
        from add_product_det apd where
        apd.approve='Y' and apd.p_id!=9999) as a on a.app_id=aa.id WHERE is_normal_user(u.id) = 1 and aa.target_segment=$tar_seg_id");
        //dd($comp_wise_prod);
        return view('landing.comp-wise-doc', compact('tar_seg_id','comp_wise_prod'));
    }

    public function compProdDocument(Request $request)
    {
        $tar_seg_id=$request->target_segment_id;
        //dd($request, $tar_seg_id);
        if(isset($tar_seg_id) && $tar_seg_id!=0)
        {
            $applicant_com=DB::table('approved_apps')
            ->join('users','users.id','=','approved_apps.created_by')
            ->where('approved_apps.target_segment',$tar_seg_id)
            ->where(DB::RAW("is_normal_user(users.id)"), 1)
            ->select('approved_apps.*','users.name')
            ->orderBy('users.name','ASC')
            ->get();

            $approved_prods=DB::select("select distinct on (u.name,aa.target_segment,a.product_name)
                    a.p_id, a.product_name
                    from approved_apps aa
                    left join users u on u.id=aa.created_by
                    left join (select  productname as product_name, apd.app_id, apd.p_id
                    from add_product_det apd where
                    apd.approve='Y' and apd.p_id!=9999) as a on a.app_id=aa.id 
                    WHERE is_normal_user(u.id) = 1 and aa.id=$request->company_id");
       
        }

         $comp_wise_prod = DB::table('approved_apps_details as aad')
        ->join('eligible_products as ep', 'ep.id', '=', 'aad.eligible_product')
        ->join('users as u', 'u.id', '=', 'aad.user_id')
        ->where('aad.status','S')
        ->where('aad.eligible_product',$request->product_id)
        ->get();

        
        $brochure_prod_data = DB::table('approved_apps_details as aad')
        ->join('eligible_products as ep', 'ep.id', '=', 'aad.eligible_product')
        ->join('brochure_uploads as bu', 'bu.product_id', '=',  'aad.eligible_product')
        ->where('aad.status','S')
        ->where('bu.product_id',$request->product_id)
        ->distinct('aad.id')
        ->get();
        //dd($request, $request->product_id, $request->company_id, $brochure_prod_data);
        //dd($request,$request->company_id, $comp_wise_prod);
        

        $applicant_com=DB::table('approved_apps')
        ->join('users','users.id','=','approved_apps.created_by')
        ->where(DB::RAW("is_normal_user(users.id)"), 1)
        ->distinct('approved_apps.created_by','users.name')
        ->select('users.id','users.name')
        ->orderBy('users.name','ASC')
        ->get();
        $approved_prods=DB::table('eligible_products')->orderBy('product','ASC')->get();
        $intCompanyId = $request->company_id;
        $intProductId = $request->product_id;

        //$contents = DB::table('brochure_uploads_admin')->select('id','app_id','product_id','remarks','prod_category','other_file_name')->get();
        //dd($contents);
        // $contents = DB::table('brochure_uploads_admin as bua')
        // ->leftjoin('brochure_uploads as bu','bu.app_id','=','bua.app_id')
        // ->select('bua.id','bua.app_id','bua.product_id','bua.remarks','bua.prod_category','bu.other_file_name','bu.id as broch_doc_id')->get();
        // //dd($contents);

        $contents = DB::table('brochure_uploads as bu')
        ->distinct('bu.id')
        ->select('bu.id','bu.app_id','bu.product_id','bu.remarks','bu.prod_category','bu.other_file_name','bu.id as broch_doc_id','bu.websitelink')->get();
        //dd($contents);

        $arr_brochure_product=array();
        foreach($contents as $doc_val)
        {
            $arr_brochure_product[$doc_val->app_id.'@_@'.$doc_val->product_id][]=$doc_val;
        }
        //dd($arr_brochure_product);

        return view('landing.comp-wise-doc-new', compact('tar_seg_id','comp_wise_prod','applicant_com','approved_prods','intCompanyId','intProductId','arr_brochure_product','brochure_prod_data'));
        
        //return view('landing.comp-wise-doc', compact('tar_seg_id','comp_wise_prod','applicant_com','approved_prods','intCompanyId','intProductId','arr_brochure_product'));
    }

    public function brochureCompany($product_id)
    {
        //dd($product_id);
        $comp_data = DB::table('approved_apps_details as aad')
        ->join('eligible_products as ep', 'ep.id', '=', 'aad.eligible_product')
        ->join('users as u', 'u.id', '=', 'aad.user_id')
        ->where('aad.status','S')
        ->where('aad.eligible_product',$product_id)
        ->select('aad.id as app_id', 'u.name', 'u.id as id')
        ->get();

        $data=array();
        foreach($comp_data as $com_val)
        {
            $strCompnayName=ucwords(strtolower($com_val->name));
            
            $data[]=array('app_id'=>$com_val->app_id,'name'=>$strCompnayName,'id'=>$com_val->id);
        }
        
        return json_encode($data);
    }
    public function brochureProduct($company_id)
    {
        // $data = DB::table('add_product_det')
        //         ->where('state', $state)->orderBy('city')->get()->unique('city')->pluck('city', 'city');

        $data=DB::select("select distinct on (u.name,aa.target_segment,a.product_name)
            a.p_id, a.product_name
            from approved_apps aa
            left join users u on u.id=aa.created_by
            left join (select  productname as product_name, apd.app_id, apd.p_id
            from add_product_det apd where
            apd.approve='Y' and apd.p_id!=9999) as a on a.app_id=aa.id 
            WHERE is_normal_user(u.id) = 1 and aa.id=$company_id");
        return json_encode($data);
    }
    public function brochureDownloadDoc($id) {
        $id=decrypt($id);
        $doc = DB::table('brochure_uploads as a')->where('id',$id)->first();
        ob_start();
        fpassthru($doc->uploaded_file);
        $docc = ob_get_contents();
        ob_end_clean();
        $ext = '';
        if ($doc->mime == "application/pdf") {
            $ext = 'pdf';
        } elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            $ext = 'docx';
        } elseif ($doc->mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $ext = 'xlsx';
        }
        else{
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
        return response($docc)->header('Cache-Control', 'no-cache private')->header('Content-Description', 'File Transfer')->header('Content-Type', $doc->mime)->header('Content-length', strlen($docc))->header('Content-Disposition', 'attachment; filename=' . $doc->file_name . '.' . $ext)->header('Content-Transfer-Encoding', 'binary');
    }
    public function otherBrochureDownloadDoc($id) {
        $id=decrypt($id);
        $doc = DB::table('brochure_uploads as a')->where('id',$id)->first();
        ob_start();
        fpassthru($doc->other_uploaded_file);
        $docc = ob_get_contents();
        ob_end_clean();
        $ext = '';
        if ($doc->other_mime == "application/pdf") {
            $ext = 'pdf';
        } elseif ($doc->other_mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            $ext = 'docx';
        } elseif ($doc->other_mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $ext = 'xlsx';
        }
        else{
            alert()->error('Something went Wrong.', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
        return response($docc)->header('Cache-Control', 'no-cache private')->header('Content-Description', 'File Transfer')->header('Content-Type', $doc->other_mime)->header('Content-length', strlen($docc))->header('Content-Disposition', 'attachment; filename=' . $doc->other_file_name . '.' . $ext)->header('Content-Transfer-Encoding', 'binary');
    }
}