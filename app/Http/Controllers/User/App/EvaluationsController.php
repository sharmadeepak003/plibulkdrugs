<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\ApplicationMast;
use App\AppStage;
use App\EvaluationDetails;
use App\FundingDetails;
use App\InvestmentParticulars;
use App\Http\Requests\EvalStore;
use App\InvestmentDetails;

class EvaluationsController extends Controller
{
    public function index()
    {
        //
    }

    public function create($id)
    {
        $appMast = ApplicationMast::where('id', $id)->where('created_by', Auth::user()->id)->where('status', 'D')->first();
        if (!$appMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('applications.index');
        }
		
		$stage_check = $appMast->stages->where('app_id', $id)->where('stage', 2)->first();
		 
		 if (!$stage_check) {
            alert()->error('Please fill Section 2 - Eligibility Criteria.')->persistent('Close');
            return redirect()->route('applications.index');
        }
		
		
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 8)->first();
        if ($stage) {
            return redirect()->route('evaluations.edit', $appMast->id);
        }

        $user = Auth::user();
        $prods = DB::table('eligible_products')->orderBy('id')->get();
        $inv_prt = InvestmentParticulars::where('type', 'Investment')->orderBy('id')->get();
        $fund_prt = InvestmentParticulars::where('type', 'Funding')->orderBy('id')->get();
        $min_cap = DB::table('eligible_products')->where('id',$appMast->eligible_product)->pluck('min_cap')->first();
        
        //dd($min_cap);
        //dd($appMast->eligibility);
        return view('user.app.eval-create', compact('appMast', 'user', 'prods', 'inv_prt', 'fund_prt','min_cap'));
    }

    public function store(EvalStore $request)
    {
        //dd($request);
        $appMast = ApplicationMast::where('id', $request->app_id)->where('created_by', Auth::user()->id)->where('status', 'D')->first();
        $inv_prt = InvestmentParticulars::where('type', 'Investment')->orderBy('id')->pluck('id')->toArray();
        $fund_prt = InvestmentParticulars::where('type', 'Funding')->orderBy('id')->pluck('id')->toArray();

        $evalDet = new EvaluationDetails();

        $evalDet->fill([
            'app_id' => $appMast->id,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'investment' => $request->investment
        ]);

        DB::transaction(function () use ($appMast, $request, $inv_prt, $fund_prt, $evalDet) {
            $evalDet->save();

            foreach ($inv_prt as $iid) {
                $inv = InvestmentDetails::create([
                    'app_id' => $appMast->id,
                    'prt_id' => $iid,
                    'amt' => $request->amt[$iid]
                ]);
            }

            foreach ($fund_prt as $fid) {
                $fund = FundingDetails::create([
                    'app_id' => $appMast->id,
                    'prt_id' => $fid,
                    'prom' => $request->prom[$fid],
                    'banks' => $request->banks[$fid],
                    'others' => $request->others[$fid],
                ]);
            }

            AppStage::create(['app_id' => $appMast->id, 'stage' => 8, 'status' => 'D']);
        });

        alert()->success('Evaluation Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $appMast = ApplicationMast::where('created_by', Auth::user()->id)->where('id', $id)->where('status', 'D')->first();
        if (!$appMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('applications.index');
        }
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 8)->first();
        if (!$stage) {
            return redirect()->route('evaluations.create', $id);
        }


        $user = Auth::user();
        $prods = DB::table('eligible_products')->orderBy('id')->get();
        $inv_prt = InvestmentParticulars::where('type', 'Investment')->orderBy('id')->get();
        $fund_prt = InvestmentParticulars::where('type', 'Funding')->orderBy('id')->get();

        $evalDet = $appMast->evaluations;
        $invDet = $appMast->investments;
        $fundDet = $appMast->fundings;
        
        $min_cap = DB::table('eligible_products')->where('id',$appMast->eligible_product)->pluck('min_cap')->first();

        return view('user.app.eval-edit', compact('appMast', 'min_cap', 'user', 'prods', 'inv_prt', 'fund_prt', 'evalDet', 'invDet', 'fundDet'));
    }

    public function update(EvalStore $request, $id)
    {
        $user = Auth::user();
        $appMast = ApplicationMast::where('id', $id)->where('created_by', $user->id)->where('status', 'D')->first();

        $inv_prt = InvestmentParticulars::where('type', 'Investment')->orderBy('id')->pluck('id')->toArray();
        $fund_prt = InvestmentParticulars::where('type', 'Funding')->orderBy('id')->pluck('id')->toArray();

        $evalDet = $appMast->evaluations;
        $invDet = $appMast->investments;
        $fundDet = $appMast->fundings;

        $evalDet->fill([
            'capacity' => $request->capacity,
            'price' => $request->price,
            'investment' => $request->investment
        ]);

        DB::transaction(function () use ($appMast, $request, $inv_prt, $fund_prt, $invDet, $fundDet, $evalDet) {
            $evalDet->save();

            foreach ($inv_prt as $iid) {
                foreach ($invDet as $det) {
                    if ($det->prt_id == $iid) {
                        $det->fill([
                            'amt' => $request->amt[$iid]
                        ]);
                        $det->save();
                    }
                }
            }

            foreach ($fund_prt as $fid) {
                foreach ($fundDet as $det) {
                    if ($det->prt_id == $fid) {
                        $det->fill([
                            'prom' => $request->prom[$fid],
                            'banks' => $request->banks[$fid],
                            'others' => $request->others[$fid],
                        ]);
                        $det->save();
                    }
                }
            }
        });

        alert()->success('Evaluation Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
