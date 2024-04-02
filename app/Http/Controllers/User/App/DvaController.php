<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DvaStore;
use Auth;
use DB;
use App\ApplicationMast;
use App\AppStage;
use App\DvaDetails;
use App\Krms;

class DvaController extends Controller
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 7)->first();
        if ($stage) {
            return redirect()->route('dva.edit', $appMast->id);
        }
		
		 $elgb = $appMast->eligibility;
		//dd($elgb);
        return view('user.app.dva-create', compact('appMast','elgb'));
    }

    public function store(DvaStore $request)
    {
        //dd($request);

        $dvas = new DvaDetails();
        $krms = $request->krm;


        $dvas->fill([
            'app_id' => $request->app_id,
            'sal_exp' => $request->sal_exp,
            'oth_exp' => $request->oth_exp,
            'non_orig' => $request->non_orig,
            'tot_cost' => $request->tot_cost,
            'non_orig_raw' => $request->non_orig_raw,
            'non_orig_srv' => $request->non_orig_srv,
            'tot_a' => $request->tot_a,
            'sales_rev' => $request->sales_rev,
            'dva' => $request->dva,
            'man_dir' => $request->man_dir,
            'man_desig' => $request->man_desig
        ]);

        DB::transaction(function () use ($request, $dvas, $krms) {
            $dvas->save();

            if ($krms) {
                foreach ($krms as $value) {
                    Krms::create([
                        'app_id' => $request->app_id,
                        'name' => $value['name'],
                        'coo' => $value['coo'],
                        'man' => $value['man'],
                        'amt' => $value['amt']
                    ]);
                }
            }

            AppStage::create(['app_id' => $request->app_id, 'stage' => 7, 'status' => 'D']);
        });

        alert()->success('DVA Details Saved', 'Success')->persistent('Close');
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 7)->first();
        if (!$stage) {
            return redirect()->route('dva.create', $id);
        }

        $dvas = $appMast->dvas;
        $krms = $appMast->krms;
		$elgb = $appMast->eligibility;

        return view('user.app.dva-edit', compact('appMast', 'dvas', 'krms', 'elgb'));
    }

    public function update(DvaStore $request, $id)
    {
        //dd($request);
        $user = Auth::user();
        $appMast = ApplicationMast::where('id', $id)->where('created_by', $user->id)->where('status', 'D')->first();
        $dvas = $appMast->dvas;
        $krms = $request->krm;

        $dvas->fill([
            'sal_exp' => $request->sal_exp,
            'oth_exp' => $request->oth_exp,
            'non_orig' => $request->non_orig,
            'tot_cost' => $request->tot_cost,
            'non_orig_raw' => $request->non_orig_raw,
            'non_orig_srv' => $request->non_orig_srv,
            'tot_a' => $request->tot_a,
            'sales_rev' => $request->sales_rev,
            'dva' => $request->dva,
            'man_dir' => $request->man_dir,
            'man_desig' => $request->man_desig
        ]);


        DB::transaction(function () use ($appMast, $dvas, $krms,$request) {
            $dvas->save();

            if ($krms) {
                foreach ($krms as $value) {
                    if (isset($value['id'])) {
                        $krm = Krms::find($value['id']);
                        $krm->name = $value['name'];
                        $krm->coo = $value['coo'];
                        $krm->man = $value['man'];
                        $krm->amt = $value['amt'];
                        $krm->save();
                    } else {
                        Krms::create([
                            'app_id' => $request->app_id,
                            'name' => $value['name'],
                            'coo' => $value['coo'],
                            'man' => $value['man'],
                            'amt' => $value['amt']
                        ]);
                    }
                }
            }
        });

        alert()->success('DVA Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
