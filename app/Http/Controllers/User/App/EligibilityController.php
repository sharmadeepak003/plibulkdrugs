<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\ApplicationMast;
use App\AppStage;
use App\Http\Requests\EligibilityStore;
use App\EligibilityCriteria;
use App\FeeDetails;
use App\GroupCompanies;


class EligibilityController extends Controller
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 2)->first();
        if ($stage) {
            return redirect()->route('eligibility.edit', $appMast->id);
        }

        return view('user.app.eligibility-create', compact('appMast'));
    }

    public function store(EligibilityStore $request)
    {
        //dd($request);

        $elgb = new EligibilityCriteria();
        $fees = new FeeDetails();
        $group = $request->group;

        $elgb->fill([
            'app_id' => $request->app_id,
            'greenfield' => $request->greenfield,
            'bankrupt' => $request->bankrupt,
            'networth' => $request->networth,
            'dva' => $request->dva,
            'ut_audit' => $request->ut_audit,
            'ut_sales' => $request->ut_sales,
            'ut_integrity' => $request->ut_integrity
        ]);

        $fees->fill([
            'app_id' => $request->app_id,
            'payment' => $request->payment,
            'date' => $request->date,
            'urn' => $request->urn,
            'bank_name' => $request->bank_name,
            'amount' => $request->amount
        ]);

        DB::transaction(function () use ($request, $elgb, $fees, $group) {
            $elgb->save();
            $fees->save();

            if ($group) {
                foreach ($group as $value) {
                    GroupCompanies::create([
                        'app_id' => $request->app_id,
                        'name' => $value['name'],
                        'location' => $value['location'],
                        'regno' => $value['regno'],
                        'relation' => $value['relation'],
                        'networth' => $value['networth']
                    ]);
                }
            }

            AppStage::create(['app_id' => $request->app_id, 'stage' => 2, 'status' => 'D']);
        });

        alert()->success('Eligibility Criteria Details Saved', 'Success')->persistent('Close');
        return redirect()->route('applications.index');
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 2)->first();
        if (!$stage) {
            return redirect()->route('eligibility.create', $id);
        }

        $elgb = $appMast->eligibility;
        $fees = $appMast->fees;
        $groups = $appMast->groups;

        return view('user.app.eligibility-edit', compact('appMast', 'elgb', 'fees', 'groups'));
    }

    public function update(EligibilityStore $request, $id)
    {
        $user = Auth::user();
        $appMast = ApplicationMast::where('id', $id)->where('created_by', $user->id)->where('status', 'D')->first();
        $elgb = $appMast->eligibility;
        $fees = $appMast->fees;
        $groups = $request->group;

        $elgb->fill([
            'greenfield' => $request->greenfield,
            'bankrupt' => $request->bankrupt,
            'networth' => $request->networth,
            'dva' => $request->dva,
            'ut_audit' => $request->ut_audit,
            'ut_sales' => $request->ut_sales,
            'ut_integrity' => $request->ut_integrity
        ]);

        $fees->fill([
            'payment' => $request->payment,
            'date' => $request->date,
            'urn' => $request->urn,
            'bank_name' => $request->bank_name,
            'amount' => $request->amount
        ]);

        DB::transaction(function () use ($appMast, $elgb, $fees, $groups) {
            $elgb->save();
            $fees->save();

            if ($groups) {
                foreach ($groups as $value) {
                    if (isset($value['id'])) {
                        $gp = GroupCompanies::find($value['id']);
                        $gp->name = $value['name'];
                        $gp->location = $value['location'];
                        $gp->regno = $value['regno'];
                        $gp->relation = $value['relation'];
                        $gp->networth = $value['networth'];
                        $gp->save();
                    } else {
                        GroupCompanies::create([
                            'app_id' => $appMast->id,
                            'name' => $value['name'],
                            'location' => $value['location'],
                            'regno' => $value['regno'],
                            'relation' => $value['relation'],
                            'networth' => $value['networth']
                        ]);
                    }
                }
            }
        });

        alert()->success('Eligibility Criteria Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deleteGroup($id)
    {
        $det = GroupCompanies::where('id', $id)->first();
        $det->delete();

        alert()->success('This entry has been Deleted', 'Success')->persistent('Close');
        return redirect()->back();
    }


    public function destroy($id)
    {
        //
    }
}
