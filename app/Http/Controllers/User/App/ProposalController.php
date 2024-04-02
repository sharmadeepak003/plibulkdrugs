<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\ApplicationMast;
use App\AppStage;
use App\Http\Requests\ProposalStore;
use App\ProjectDetails;
use App\ProjectParticulars;
use App\ProposalDetails;

class ProposalController extends Controller
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 5)->first();
        if ($stage) {
            return redirect()->route('proposal.edit', $appMast->id);
        }

        $user = Auth::user();
        $prods = DB::table('eligible_products')->orderBy('id')->get();
        $proj_prt = ProjectParticulars::orderBy('id')->get();

        return view('user.app.proposal-create', compact('appMast', 'user', 'prods', 'proj_prt'));
    }

    public function store(ProposalStore $request)
    {
        //dd($request);
        $appMast = ApplicationMast::where('id', $request->app_id)->where('created_by', Auth::user()->id)->where('status', 'D')->first();
        $proj_prt = ProjectParticulars::orderBy('id')->pluck('id')->toArray();

        $propDet = new ProposalDetails();

        $propDet->fill([
            'app_id' => $appMast->id,
            'prop_man_add' => $request->prop_man_add,
            'prop_man_det' => $request->prop_man_det,
            'exst_man_add' => $request->exst_man_add,
            'prod_date' => $request->prod_date
        ]);

        DB::transaction(function () use ($appMast, $request, $proj_prt, $propDet) {

            $propDet->save();

            foreach ($proj_prt as $pid) {
                $proj = ProjectDetails::create([
                    'app_id' => $appMast->id,
                    'prt_id' => $pid,
                    'info_prov' => $request->info_prov[$pid],
                    'dpr_ref' => $request->dpr_ref[$pid],
                    'remarks' => $request->remarks[$pid]
                ]);
            }

            AppStage::create(['app_id' => $appMast->id, 'stage' => 5, 'status' => 'D']);
        });

        alert()->success('Proposal Details Saved', 'Success')->persistent('Close');
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 5)->first();
        if (!$stage) {
            return redirect()->route('proposal.create', $id);
        }


        $user = Auth::user();
        $prods = DB::table('eligible_products')->orderBy('id')->get();
        $proj_prt = ProjectParticulars::orderBy('id')->get();

        $propDet = $appMast->proposalDetails;
        $projDet = $appMast->projectDetails;

        return view('user.app.proposal-edit', compact('appMast', 'user', 'prods', 'proj_prt', 'propDet', 'projDet'));
    }

    public function update(ProposalStore $request, $id)
    {
        //dd($request);
        $user = Auth::user();
        $appMast = ApplicationMast::where('id', $id)->where('created_by', $user->id)->where('status', 'D')->first();

        $proj_prt = ProjectParticulars::orderBy('id')->pluck('id')->toArray();

        $propDet = $appMast->proposaldetails;
        $projDet = $appMast->projectDetails;

        $propDet->fill([
            'prop_man_add' => $request->prop_man_add,
            'prop_man_det' => $request->prop_man_det,
            'exst_man_add' => $request->exst_man_add,
            'prod_date' => $request->prod_date
        ]);

        DB::transaction(function () use ($appMast, $request, $proj_prt, $propDet, $projDet) {

            $propDet->save();

            foreach ($proj_prt as $pid) {
                foreach ($projDet as $det) {
                    if ($det->prt_id == $pid) {
                        $det->fill([
                            'info_prov' => $request->info_prov[$pid],
                            'dpr_ref' => $request->dpr_ref[$pid],
                            'remarks' => $request->remarks[$pid]
                        ]);
                        $det->save();
                    }
                }
            }
        });

        alert()->success('Proposal Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
