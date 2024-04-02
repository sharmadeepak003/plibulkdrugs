<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\ApplicationMast;
use App\AppStage;
use App\Http\Requests\ProjectionStore;
use App\Revenues;
use App\Employments;

class ProjectionsController extends Controller
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 6)->first();
        if ($stage) {
            return redirect()->route('projections.edit', $appMast->id);
        }

        return view('user.app.projections-create', compact('appMast'));

    }

    public function store(ProjectionStore $request)
    {
        //dd($request);
        $appMast = ApplicationMast::where('id', $request->app_id)->where('created_by', Auth::user()->id)->where('status', 'D')->first();

        $revDet = new Revenues();
        $empDet = new Employments();

        $revDet->fill([
            'app_id' => $appMast->id,
            'expfy20' => $request->expfy20,
            'expfy21' => $request->expfy21,
            'expfy22' => $request->expfy22,
            'expfy23' => $request->expfy23,
            'expfy24' => $request->expfy24,
            'expfy25' => $request->expfy25,
            'expfy26' => $request->expfy26,
            'expfy27' => $request->expfy27,
            'expfy28' => $request->expfy28,
            'domfy20' => $request->domfy20,
            'domfy21' => $request->domfy21,
            'domfy22' => $request->domfy22,
            'domfy23' => $request->domfy23,
            'domfy24' => $request->domfy24,
            'domfy25' => $request->domfy25,
            'domfy26' => $request->domfy26,
            'domfy27' => $request->domfy27,
            'domfy28' => $request->domfy28
        ]);

        $empDet->fill([
            'app_id' => $appMast->id,
            'fy20' => $request->fy20,
            'fy21' => $request->fy21,
            'fy22' => $request->fy22,
            'fy23' => $request->fy23,
            'fy24' => $request->fy24,
            'fy25' => $request->fy25,
            'fy26' => $request->fy26,
            'fy27' => $request->fy27,
            'fy28' => $request->fy28
        ]);

        DB::transaction(function () use ($appMast, $revDet, $empDet) {
            $revDet->save();
            $empDet->save();

            AppStage::create(['app_id' => $appMast->id, 'stage' => 6, 'status' => 'D']);
        });

        alert()->success('Projection Details Saved', 'Success')->persistent('Close');
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 6)->first();
        if (!$stage) {
            return redirect()->route('projections.create', $id);
        }


        $rev = $appMast->revenues;
        $emp = $appMast->employments;

        return view('user.app.projections-edit', compact('appMast', 'rev', 'emp'));

    }

    public function update(ProjectionStore $request, $id)
    {
        $user = Auth::user();
        $appMast = ApplicationMast::where('id', $id)->where('created_by', $user->id)->where('status', 'D')->first();

        $revDet = $appMast->revenues;
        $empDet = $appMast->employments;

        $revDet->fill([
            'expfy20' => $request->expfy20,
            'expfy21' => $request->expfy21,
            'expfy22' => $request->expfy22,
            'expfy23' => $request->expfy23,
            'expfy24' => $request->expfy24,
            'expfy25' => $request->expfy25,
            'expfy26' => $request->expfy26,
            'expfy27' => $request->expfy27,
            'expfy28' => $request->expfy28,
            'domfy20' => $request->domfy20,
            'domfy21' => $request->domfy21,
            'domfy22' => $request->domfy22,
            'domfy23' => $request->domfy23,
            'domfy24' => $request->domfy24,
            'domfy25' => $request->domfy25,
            'domfy26' => $request->domfy26,
            'domfy27' => $request->domfy27,
            'domfy28' => $request->domfy28
        ]);

        $empDet->fill([
            'fy20' => $request->fy20,
            'fy21' => $request->fy21,
            'fy22' => $request->fy22,
            'fy23' => $request->fy23,
            'fy24' => $request->fy24,
            'fy25' => $request->fy25,
            'fy26' => $request->fy26,
            'fy27' => $request->fy27,
            'fy28' => $request->fy28
        ]);

        DB::transaction(function () use ($revDet, $empDet) {
            $revDet->save();
            $empDet->save();
        });

        alert()->success('Projection Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
