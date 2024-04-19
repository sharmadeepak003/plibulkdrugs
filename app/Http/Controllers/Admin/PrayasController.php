<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Auth;
// use Illuminate\Http\Request;

class PrayasController extends Controller
{

	public function getdata(){
      
		$projectcode = DB::table('mst_projects')->get();

		return view('admin.prayas.index',compact('projectcode'));
    }

    public function getcodes($project_id)
    {

        $getdata = DB::table('mst_projects')->join('mst_frequency','mst_frequency.project_id','=','mst_projects.id')
        ->where('mst_projects.id',$project_id)->get();

        return  $getdata;
    }
   public function index(Request $request)
    {
	
		$codes = DB::table('mst_projects')->join('mst_frequency','mst_frequency.project_id','mst_projects.id')
        ->where('mst_projects.id',$request->Project_Code)->select('mst_projects.*','mst_frequency.freq_code','mst_frequency.freq_name')->first();

		$qtr = DB::table('qtr_master')->distinct('fy')->get();
        $qtrval = DB::table('qtr_master')->where('status',1)->get()->max('qtr_id');
        $date = DB::select('select *,qtr_date as to_data from qtr_master q where qtr_id=?',[$qtrval]);

        $frz_data =DB::table('prayas_flag')->where('qtrval',$qtrval)->first();

        $pushdata = DB::table('prayas_pushdata')->where('quarter',$qtrval)->get();

        $detail = array();

		$selectedFy = '';

        return view('admin.prayas.edit',compact('qtr','detail', 'qtrval','pushdata','codes','date','frz_data','selectedFy'));

    }

    public function show(Request $request){

		//dd($request);
		
		$qtrval =substr($request->fyear,0,4).'0'.$request->quarter;
		//dd($qtrval, $request->quarter);

		$selectedFy = $request->fyear;
		//$selectedFy = '2022-23';

		 $fyear = substr($request->fyear,0,5).substr($request->fyear,7,9);
		//$fyear = '2022-23';

		$date = DB::select('select *,qtr_date as to_data from qtr_master q where qtr_id=?',[$qtrval]);
		//$date = DB::select('select *,qtr_date as to_data from qtr_master q where qtr_id=?',['202303']);
		
		
		$codes = DB::table('mst_projects')->join('mst_frequency','mst_frequency.project_id','mst_projects.id')->where('mst_projects.id',$request->project_code)->select('mst_projects.*','mst_frequency.freq_code','mst_frequency.freq_name')->first();
		
      	$frz_data =DB::table('prayas_flag')->where('qtrval',$qtrval)->first();


      	$pushdata = DB::table('prayas_pushdata')->where('quarter',$qtrval)->get();

      	if(count($pushdata)>0){
			
        	$detail = DB::table('prayas_pushdata')->where('quarter',$qtrval)->where('fy',$request->fyear)
        	->orderby('name_selected_beneficiary')->get();
			//dd($qtrval, $request->fyear, $detail);

		}else{
				DB::select('call kpi_summary_commulative(?,?,?)',array($qtrval,$selectedFy,Auth::user()->id));
				$detail = DB::table('prayas_excel')->where('quarter',$qtrval)->where('fy',$request->fyear)
				->orderby('name_selected_beneficiary')->get();
		}
      $qtr = DB::table('qtr_master')->distinct('fy')->get();
      return view('admin.prayas.edit',compact('detail','qtr','qtrval','codes','frz_data','date','fyear','selectedFy'));


    }

    

	public function edit($user_id,$qtr){

		$detail = DB::table('prayas_excel')->where('company_code',$user_id)->where('quarter',$qtr)->get();
		return view('admin.prayas.edit',compact('detail'));
	}
  
	public function data(Request $request){

			//dd($request, 'hello');
		  $codes = DB::table('mst_projects')->join('mst_frequency','mst_frequency.project_id','mst_projects.id')->where('mst_projects.project_code',$request->project_code)->select('mst_projects.*','mst_frequency.freq_code','mst_frequency.freq_name')->first();
  
		  $update_data =DB::table('prayas_pushdata')->where('quarter',$request->qtr)->get();

		  $fy = $request->fy;

		  DB::transaction(function () use ($request,$update_data) {
  
			if (count($update_data) == 0) {
				foreach ($request->prayas as $value) {
					DB::table('prayas_pushdata')->insert([
					  'company_code' => $value['com_code'],
					  'name_selected_beneficiary' => $value['company_name'],
					  'target_segment' => $value['target_seg'],
					  'estimated_investement' => $value['esti_inv'],
					  'actual_investemen' => $value['actual_inv'],
					  'estimated_sales' => $value['esti_sales'],
					  'estimated_exports' => $value['esti_export'],
					  'estimated_employment' => $value['esti_employ'],
					  'estimated_dva' => $value['esti_dva'],
					  'actual_sales' => $value['actual_sale'],
					  'actual_exports' => $value['actual_exports'],
					  'actual_employment' => $value['actual_emp'],
					  'actual_dva' => $value['actual_dva'],
					  'quarter' => $request->qtr,
					  'fy' => $request->fy,
					  'status' =>'D',
					  'created_by' => Auth::user()->id,
					  'updated_by' => Auth::user()->id,
					  'created_at' =>  Carbon::now(),
					  'updated_at' =>  Carbon::now(),
					]);
				}
			}else{
				foreach ($request->prayas as $value) {
					DB::table('prayas_pushdata')->where('id', $value['id'])->update([
						  'company_code' => $value['com_code'],
						  'name_selected_beneficiary' => $value['company_name'],
						  'target_segment' => $value['target_seg'],
						  'estimated_investement' => $value['esti_inv'],
						  'estimated_sales' => $value['esti_sales'],
						  'estimated_exports' => $value['esti_export'],
						  'estimated_employment' => $value['esti_employ'],
						  'estimated_dva' => $value['esti_dva'],
						  'actual_investemen' => $value['actual_inv'],
						  'actual_exports' => $value['actual_exports'],
						  'actual_sales' => $value['actual_sale'],
						  'actual_employment' => $value['actual_emp'],
						  'actual_dva' =>$value['actual_dva'],
						  'quarter' => $request->qtr,
						  'fy' => $request->fy,
						  'status' =>'D',
						  'created_by' => Auth::user()->id,
						  'updated_by' => Auth::user()->id,
						  'created_at' =>  Carbon::now(),
						  'updated_at' =>  Carbon::now(),
					]);
				}
			}
			alert()->success('Updated Successfully', 'Success')->persistent('Close');
		  });
		return redirect()->route('admin.prayas.dash',[$request->qtr,$codes->project_code, $fy]);
	}
  
	public function dash($qtr_id,$project_code,$fy){

		$firstYear = substr($fy, 0, 4);
		$secondYear = substr($fy, -2);
		$selectedFy = $firstYear . "-" . ($firstYear + 1);

		$selectedFy = $fy;
		

		//dd($qtr_id,$project_code,$fy, $selectedFy);

		$date = DB::select('select *,qtr_date as to_data from qtr_master q where qtr_id=?',[$qtr_id]);


		$frz_data =DB::table('prayas_flag')->where('qtrval',$qtr_id)->first();


		$codes = DB::table('mst_projects')->join('mst_frequency','mst_frequency.project_id','mst_projects.id')->where('mst_projects.project_code',$project_code)->select('mst_projects.*','mst_frequency.freq_code','mst_frequency.freq_name')->first();

		$qtr = DB::table('qtr_master')->distinct('fy')->get();
		$qtrval =$qtr_id;

		$pushdata = DB::table('prayas_pushdata')->where('quarter',$qtrval)->get();

		if(count($pushdata)>0){

			$detail = DB::table('prayas_pushdata')->where('quarter',$qtrval)
			->orderby('id')->get();
		}else{

			$detail = DB::table('prayas_excel')->where('quarter',$qtrval)
			->orderby('name_selected_beneficiary')->get();
		}

		return view('admin.prayas.edit',compact('qtr','detail', 'qtrval','pushdata','codes','frz_data','date','selectedFy'));
	}

	public function fixdata($qtr_id,$project_code,$date){
		$codes =DB::table('mst_projects')->join('mst_frequency','mst_frequency.project_id','mst_projects.id')->where('mst_projects.project_code',$project_code)->select('mst_projects.*','mst_frequency.freq_code','mst_frequency.freq_name')->first();

		$qtr = DB::table('qtr_master')->distinct('fy')->get();
		$qtrval =$qtr_id;

		$pushdata = DB::table('prayas_pushdata')->where('quarter',$qtrval)->get();

		if(count($pushdata)>0){

			$detail = DB::table('prayas_pushdata')->where('quarter',$qtrval)
			->orderby('id')->get();

		}else{

			$detail = DB::table('prayas_excel')->where('quarter',$qtrval)
			->orderby('name_selected_beneficiary')->get();
		}
		return view('admin.prayas.fixprayasdata',compact('qtr','detail', 'qtrval','pushdata','codes','date'));
	}
  
  
	public function excel_data(Request $request){
		//dd('1');
		//dd($request);

		$flag = DB::table('prayas_flag')->where('qtrval',$request->qtr)->first();


        DB::transaction(function () use ($request,$flag) {

            if(!$flag){
                DB::table('prayas_flag')->insert([
                    'fy' => $request->fy,
                    'flag' => 'F',
                    'qtrval' =>  $request->qtr,
                    'created_at' =>  Carbon::now(),
                    ]);
            }


            $date = DB::select('select *,qtr_date as to_data from qtr_master q where qtr_id=?',[$request->qtr]);
            // dd($date[0]);


			$value_data = DB::table('prayas_value_data')->where('asondate',$date[0]->to_data)->first();

			foreach ($request->prayas as $value) {
				
				if($value['com_code'] != 61){
					$cat = DB::table('approved_apps_details')->where('user_id',$value['com_code'])->select('target_segment_id')->first();
				}else{
					$it_cat = '4';
				}

				/**
				 * Condition added to check if the data source is form
				 * If source is form, then convert the Target segment to the values provided by Prayas
				 */
				if(!is_int($value['target_seg'])) {
					if($value['target_seg'] == 'A. Key Fermentation based KSMs/Drug Intermediates')
					{
						$value['target_seg'] = 7;
					} elseif ($value['target_seg'] == 'B. Fermentation based niche KSMs/Drug Intermediates/APIs') {
						$value['target_seg'] = 6;
					} elseif ($value['target_seg'] == 'C. Key Chemical Synthesis based KSMs/Drug Intermediates') {
						$value['target_seg'] = 5;
					} elseif ($value['target_seg'] == 'D. Other Chemical Synthesis based KSMs/ Drug Intermediates/ APIs') {
						$value['target_seg'] = 4;
					} 
				}

				// if($cat->target_segment_id == 1){
                //     $it_cat = '7';
                // }elseif($cat->target_segment_id == 2){
                //     $it_cat = '6';
                // }elseif($cat->target_segment_id == 3){
                //     $it_cat = '5';
				// }elseif($cat->target_segment_id == 4){
                //     $it_cat = '4';
				// }
				//dd($value);
				

                if(!$value_data){

                    DB::table('prayas_value_data')->insert([
                        'project_code' => $value['com_code'],
                        'group_id' => 1,
                        'asondate' => $date[0]->to_data,
                        'kvalue' => implode(',', array($value['esti_inv'],$value['actual_inv'],$value['esti_sales'],$value['actual_sale'],$value['esti_export'],$value['actual_exports']
                        ,$value['esti_employ'], $value['actual_emp'],$value['esti_dva'],
                       $value['actual_dva']
                        )),
                        'lvalue' =>implode(',',array('91','3','5',$value['target_seg'],$value['com_code'])),
                        'created_at' =>  Carbon::now(),
                        'updated_at' =>  Carbon::now(),
                        ]);
                }
            }

            //  return view('admin.prayas.edit',compact('qtr','detail', 'qtrval','pushdata'));
        });

        return Response()->json($request);

    }

	public function finalpushdata($project_code,$date){

		//dd('final push data');

		
        $codes = DB::table('mst_projects')->join('mst_frequency','mst_frequency.project_id','mst_projects.id')
        ->where('mst_projects.id',$project_code)->select('mst_projects.*','mst_frequency.freq_code','mst_frequency.freq_name')
        ->first();

		//dd($project_code,$date, $codes);

        $project_code = $codes->project_code;
        $frequency    = $codes->freq_code;
        $instance_code = $codes->instance_code;
        $sec_code = $codes->sec_code;
        $ministry_code = $codes->ministry_code;
        $dept_code = $codes->dept_code;


        $url = 'data/'.$project_code.'.key';

        $file_key = file_get_contents($url);

        $project_data = array(
            "Instance_Code" => $instance_code,
            "Sec_Code"      => $sec_code,
            "Ministry_Code" => $ministry_code,
            "Dept_Code"     => $dept_code,
            "Project_Code"  => $project_code
        );
		

		$date_range = $this->get_date_range($project_data);

		dd($date_range );


        $kpi_data   = DB::table('prayas_value_data')->where('asondate',$date)->get();

		$data = [];

        foreach ($kpi_data as $key => $val) {
            $data[$key]["Group_Id"] = $val->group_id;
            $data[$key]["datadate"] = date('d-m-Y' ,strtotime($val->asondate));
            $data[$key]["KValue"] 	= 	$val->kvalue;
            $data[$key]["LValue"] 	= $val->lvalue;
        }

		 dd($data);

        $str =
        [[
            "Instance_Code" => $instance_code,
            "Sec_Code"      => $sec_code,
            "Ministry_Code" => $ministry_code,
            "Dept_Code"     => $dept_code,
            "Project_Code"  => $project_code,
            "Frequency_Id"  => $frequency,
            "atmpt"         => 0,
            "ListKpidata"   =>
            $data,
        ]];
		
		$str = json_encode($str);


		$buffer = unpack("C*", $str);

		$compressedData = gzencode($str);

		$compressedData_array = unpack('C*', $compressedData);

		$buffer = unpack("C*", pack("L", sizeof($buffer)));

		$gZipBuffer = array_merge($buffer, $compressedData_array);

		$str = call_user_func_array("pack", array_merge(array("C*"), $gZipBuffer));

		$str = base64_encode($str);

		$ecrypted_data = $this->kpi_dash_api_encrypt($str, $file_key);

		$paylod = [array(
			"IP" => array(
			"Instance_Code" => $instance_code,
			"Sec_Code"      => $sec_code,
			"Ministry_Code" => $ministry_code,
			"Dept_Code"     => $dept_code,
			"Project_Code"  => $project_code
			),
			"EncyptedData" => $ecrypted_data
		)];
			//dd($paylod);
			//dd('end');
		$response = $this->push_to_kpi_dashboard($paylod);

		print 'RESPONSE: ' . print_r($response, true);

      }


      public function kpi_dash_api_encrypt($plaintext, $key)
      {
		dd("dd3");
          $key_len    = strlen($key);
          //Set the method
          $method     = 'aes-128-cbc';
          //get Requried Key length fo the Method
          $ivlen  = openssl_cipher_iv_length($method);
          $iv = substr($key, 0, $ivlen);
          //Encrypt
          return base64_encode(openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv));
      }

      public function get_date_range($project_data)
      {
		
          $url = "http://prayasapi.darpan.nic.in/getdate";

          //Content type of data
          $header     = array(
              "Content-Type: application/json"
          );

          //conver array to json text
          $post_body  = json_encode($project_data);
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $returned = curl_exec($ch);
          curl_close($ch);
          return json_decode($returned);
      }


    public function push_to_kpi_dashboard($project_data)
    {
		dd("dd2");
		$url = "http://prayasapi.darpan.nic.in/pushdata";
		//Content type of data
		$header     = array(
			"Content-Type: application/json"
		);

		//conver array to json text
		$post_body  = json_encode($project_data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$returned = curl_exec($ch);
		curl_close($ch);

		return json_decode($returned);
    }


	public function downloadexcelformat()
    {
	
        $file_path = public_path('prayas_excel_format/PLIBD_Prayas_Format_File.csv');
       
        if (file_exists($file_path)) {
           
            return response()->download($file_path, 'PLIBD_Prayas_Excel_Format.csv');
        } 
        else 
        {
         
            alert()->error('Something went wrong', 'Attention!')->persistent('Close');
            return redirect()->back();
        }
      
    }

	public function insertPrayasExcel(Request $request)
    {
       
		//dd('hello', $request);
		 //dd($request);
        // Validate the uploaded file
        $request->validate([
            'formFile' => 'required|mimes:csv,txt|max:2048', // Adjust max file size as needed
        ]);
    
        if ($request->file('formFile')->isValid()) {
			
			$filePath = $request->file('formFile')->path();
			
			// Parse CSV file and insert data into the database
			$data = array_map('str_getcsv', file($filePath));
			//dd($data);
			
			$fy = substr($request->fy, 0, 7) . substr($request->fy, 7, 9);
			$qtrval = $request->qtrval;
		
			$prayasData = DB::table('prayas_excel')->where('quarter',$qtrval)->where('fy',$fy)->delete();
			$prayasData = DB::table('prayas_pushdata')->where('quarter',$qtrval)->where('fy',$fy)->delete();
			
			// Iterate over each row of the CSV data
			foreach ($data as $row) {
				// Skip the header row
				if ($row === $data[0]) {
					continue;
				}
				
				//dd($row);
				// if($row[2] == 1){
                //     $it_cat = '20';
                // }elseif($row[2] == 2){
                //     $it_cat = '22';
                // }elseif($row[2] == 3){
                //     $it_cat = '21';
				// }elseif($row[2] == 4){
                //     $it_cat = '23';
				// }

				// if($row['com_code'] != 61){
				// 	$it_cat = DB::table('approved_apps_details')->where('user_id',$row['com_code'])->select('target_segment_id')->first();
				// }else{
				// 	$it_cat = '4';
				// }
				
					//dd($row[2]);
				if($row[2] == 'TS-1'){
                    $it_cat = '7';
                }elseif($row[2] == 'TS-2'){
                    $it_cat = '6';
                }elseif($row[2] == 'TS-3'){
                    $it_cat = '5';
				}elseif($row[2] == 'TS-4'){
                    $it_cat = '4';
				}

				
				if (!empty($row[0]) && !empty($row[1])) {
				DB::table('prayas_excel')->insert([
					'company_code' => $row[0],
					'name_selected_beneficiary' => $row[1],
					// 'target_segment' => $row[2],
					'target_segment' => $it_cat,
					'estimated_investement' => (float) $row[3],
					'actual_investemen' => (float) $row[4],
					'estimated_sales' => (float) $row[5],
					'actual_sales' => (float) $row[6],
					'estimated_exports' => (float) $row[7],
					'actual_exports' => (float) $row[8],
					'estimated_employment' => (int) $row[9],
					'actual_employment' => (int) $row[10],
					'estimated_dva' => (float) $row[11],
					'actual_dva' => (float) $row[12],
					'quarter' => $qtrval,
					'fy' => $fy,
					'created_by' => auth()->user()->id,
					'updated_by' => auth()->user()->id,
					'created_at' => now(),
					'updated_at' => now()
				]);


				DB::table('prayas_pushdata')->insert([
					'company_code' => $row[0],
					'name_selected_beneficiary' => $row[1],
					// 'target_segment' => $row[2],
					'target_segment' => $it_cat,
					'estimated_investement' => (float) $row[3],
					'actual_investemen' => (float) $row[4],
					'estimated_sales' => (float) $row[5],
					'actual_sales' => (float) $row[6],
					'estimated_exports' => (float) $row[7],
					'actual_exports' => (float) $row[8],
					'estimated_employment' => (int) $row[9],
					'actual_employment' => (int) $row[10],
					'estimated_dva' => (float) $row[11],
					'actual_dva' => (float) $row[12],
					'quarter' => $qtrval,
					'fy' => $fy,
					'status' => 'D',
					'created_by' => auth()->user()->id,
					'updated_by' => auth()->user()->id,
					'created_at' => now(),
					'updated_at' => now(),
					'ince_amount' => null,
					'pli_dish' => null,
				]);

			}
			}
			
			return response()->json(['message' => 'Data uploaded successfully']);
		}
		
         else {
            return response()->json(['message' => 'Invalid file'], 400);
        }
    }

}