<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\ApplicationMast;
use App\AppStage;
use App\Financials;
use App\Http\Requests\FinancialStore;

class FinancialsController extends Controller
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 3)->first();
        if ($stage) {
            return redirect()->route('financials.edit', $appMast->id);
        }

        return view('user.app.financials-create', compact('appMast'));
    }

    public function store(FinancialStore $request)
    {
        $fin = new Financials();

        $fin->fill([
            'app_id' => $request->app_id,
            'phar_dom_17' => $request->phar_dom_17,
            'phar_dom_18' => $request->phar_dom_18,
            'phar_dom_19' => $request->phar_dom_19,
            'phar_exp_17' => $request->phar_exp_17,
            'phar_exp_18' => $request->phar_exp_18,
            'phar_exp_19' => $request->phar_exp_19,
            'oth_dom_17' => $request->oth_dom_17,
            'oth_dom_18' => $request->oth_dom_18,
            'oth_dom_19' => $request->oth_dom_19,
            'oth_exp_17' => $request->oth_exp_17,
            'oth_exp_18' => $request->oth_exp_18,
            'oth_exp_19' => $request->oth_exp_19,
            'oth_inc_17' => $request->oth_inc_17,
            'oth_inc_18' => $request->oth_inc_18,
            'oth_inc_19' => $request->oth_inc_19,
            'tot_rev_17' => $request->tot_rev_17,
            'tot_rev_18' => $request->tot_rev_18,
            'tot_rev_19' => $request->tot_rev_19,
            'pbt17' => $request->pbt17,
            'pbt18' => $request->pbt18,
            'pbt19' => $request->pbt19,
            'pat17' => $request->pat17,
            'pat18' => $request->pat18,
            'pat19' => $request->pat19,
            'sh_cap_17' => $request->sh_cap_17,
            'sh_cap_18' => $request->sh_cap_18,
            'sh_cap_19' => $request->sh_cap_19,
            'eq_prom_17' => $request->eq_prom_17,
            'eq_prom_18' => $request->eq_prom_18,
            'eq_prom_19' => $request->eq_prom_19,
            'eq_ind_17' => $request->eq_ind_17,
            'eq_ind_18' => $request->eq_ind_18,
            'eq_ind_19' => $request->eq_ind_19,
            'eq_frn_17' => $request->eq_frn_17,
            'eq_frn_18' => $request->eq_frn_18,
            'eq_frn_19' => $request->eq_frn_19,
            'eq_mult_17' => $request->eq_mult_17,
            'eq_mult_18' => $request->eq_mult_18,
            'eq_mult_19' => $request->eq_mult_19,
            'eq_bank_17' => $request->eq_bank_17,
            'eq_bank_18' => $request->eq_bank_18,
            'eq_bank_19' => $request->eq_bank_19,
            'int_acc_17' => $request->int_acc_17,
            'int_acc_18' => $request->int_acc_18,
            'int_acc_19' => $request->int_acc_19,
            'ln_prom_17' => $request->ln_prom_17,
            'ln_prom_18' => $request->ln_prom_18,
            'ln_prom_19' => $request->ln_prom_19,
            'ln_ind_17' => $request->ln_ind_17,
            'ln_ind_18' => $request->ln_ind_18,
            'ln_ind_19' => $request->ln_ind_19,
            'ln_frn_17' => $request->ln_frn_17,
            'ln_frn_18' => $request->ln_frn_18,
            'ln_frn_19' => $request->ln_frn_19,
            'ln_mult_17' => $request->ln_mult_17,
            'ln_mult_18' => $request->ln_mult_18,
            'ln_mult_19' => $request->ln_mult_19,
            'ln_bank_17' => $request->ln_bank_17,
            'ln_bank_18' => $request->ln_bank_18,
            'ln_bank_19' => $request->ln_bank_19,
            'gr_ind_17' => $request->gr_ind_17,
            'gr_ind_18' => $request->gr_ind_18,
            'gr_ind_19' => $request->gr_ind_19,
            'gr_frn_17' => $request->gr_frn_17,
            'gr_frn_18' => $request->gr_frn_18,
            'gr_frn_19' => $request->gr_frn_19,
            'rnd_unit' => $request->rnd_unit,
            'rnd_rcnz' => $request->rnd_rcnz,
            'rnd_inv_17' => $request->rnd_inv_17,
            'rnd_inv_18' => $request->rnd_inv_18,
            'rnd_inv_19' => $request->rnd_inv_19,
            'rnd_achv' => $request->rnd_achv,
            'cap_17' => $request->cap_17,
            'cap_18' => $request->cap_18,
            'cap_19' => $request->cap_19,
            'sof_17' => $request->sof_17,
            'sof_18' => $request->sof_18,
            'sof_19' => $request->sof_19
        ]);

        DB::transaction(function () use ($fin, $request) {
            $fin->save();

            AppStage::create(['app_id' => $request->app_id, 'stage' => 3, 'status' => 'D']);
        });

        alert()->success('Financial Details Saved', 'Success')->persistent('Close');
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
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 3)->first();
        if (!$stage) {
            return redirect()->route('financials.create', $id);
        }

        $fin = $appMast->financials;

        return view('user.app.financials-edit', compact('appMast', 'fin'));
    }

    public function update(FinancialStore $request, $id)
    {
        $user = Auth::user();
        $appMast = ApplicationMast::where('id', $id)->where('created_by', $user->id)->where('status', 'D')->first();
        $fin = $appMast->financials;

        $fin->fill([
            'phar_dom_17' => $request->phar_dom_17,
            'phar_dom_18' => $request->phar_dom_18,
            'phar_dom_19' => $request->phar_dom_19,
            'phar_exp_17' => $request->phar_exp_17,
            'phar_exp_18' => $request->phar_exp_18,
            'phar_exp_19' => $request->phar_exp_19,
            'oth_dom_17' => $request->oth_dom_17,
            'oth_dom_18' => $request->oth_dom_18,
            'oth_dom_19' => $request->oth_dom_19,
            'oth_exp_17' => $request->oth_exp_17,
            'oth_exp_18' => $request->oth_exp_18,
            'oth_exp_19' => $request->oth_exp_19,
            'oth_inc_17' => $request->oth_inc_17,
            'oth_inc_18' => $request->oth_inc_18,
            'oth_inc_19' => $request->oth_inc_19,
            'tot_rev_17' => $request->tot_rev_17,
            'tot_rev_18' => $request->tot_rev_18,
            'tot_rev_19' => $request->tot_rev_19,
            'pbt17' => $request->pbt17,
            'pbt18' => $request->pbt18,
            'pbt19' => $request->pbt19,
            'pat17' => $request->pat17,
            'pat18' => $request->pat18,
            'pat19' => $request->pat19,
            'sh_cap_17' => $request->sh_cap_17,
            'sh_cap_18' => $request->sh_cap_18,
            'sh_cap_19' => $request->sh_cap_19,
            'eq_prom_17' => $request->eq_prom_17,
            'eq_prom_18' => $request->eq_prom_18,
            'eq_prom_19' => $request->eq_prom_19,
            'eq_ind_17' => $request->eq_ind_17,
            'eq_ind_18' => $request->eq_ind_18,
            'eq_ind_19' => $request->eq_ind_19,
            'eq_frn_17' => $request->eq_frn_17,
            'eq_frn_18' => $request->eq_frn_18,
            'eq_frn_19' => $request->eq_frn_19,
            'eq_mult_17' => $request->eq_mult_17,
            'eq_mult_18' => $request->eq_mult_18,
            'eq_mult_19' => $request->eq_mult_19,
            'eq_bank_17' => $request->eq_bank_17,
            'eq_bank_18' => $request->eq_bank_18,
            'eq_bank_19' => $request->eq_bank_19,
            'int_acc_17' => $request->int_acc_17,
            'int_acc_18' => $request->int_acc_18,
            'int_acc_19' => $request->int_acc_19,
            'ln_prom_17' => $request->ln_prom_17,
            'ln_prom_18' => $request->ln_prom_18,
            'ln_prom_19' => $request->ln_prom_19,
            'ln_ind_17' => $request->ln_ind_17,
            'ln_ind_18' => $request->ln_ind_18,
            'ln_ind_19' => $request->ln_ind_19,
            'ln_frn_17' => $request->ln_frn_17,
            'ln_frn_18' => $request->ln_frn_18,
            'ln_frn_19' => $request->ln_frn_19,
            'ln_mult_17' => $request->ln_mult_17,
            'ln_mult_18' => $request->ln_mult_18,
            'ln_mult_19' => $request->ln_mult_19,
            'ln_bank_17' => $request->ln_bank_17,
            'ln_bank_18' => $request->ln_bank_18,
            'ln_bank_19' => $request->ln_bank_19,
            'gr_ind_17' => $request->gr_ind_17,
            'gr_ind_18' => $request->gr_ind_18,
            'gr_ind_19' => $request->gr_ind_19,
            'gr_frn_17' => $request->gr_frn_17,
            'gr_frn_18' => $request->gr_frn_18,
            'gr_frn_19' => $request->gr_frn_19,
            'rnd_unit' => $request->rnd_unit,
            'rnd_rcnz' => $request->rnd_rcnz,
            'rnd_inv_17' => $request->rnd_inv_17,
            'rnd_inv_18' => $request->rnd_inv_18,
            'rnd_inv_19' => $request->rnd_inv_19,
            'rnd_achv' => $request->rnd_achv,
            'cap_17' => $request->cap_17,
            'cap_18' => $request->cap_18,
            'cap_19' => $request->cap_19,
            'sof_17' => $request->sof_17,
            'sof_18' => $request->sof_18,
            'sof_19' => $request->sof_19
        ]);

        DB::transaction(function () use ($appMast, $fin) {
            $fin->save();
        });

        alert()->success('Eligibility Criteria Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
