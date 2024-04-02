<?php

namespace App\Http\Controllers\User\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyDetStore;
use Auth;
use DB;
use App\ApplicationMast;
use App\AppStage;
use App\Auditors;
use App\CompanyDetails;
use App\Gstins;
use App\Kmps;
use App\ManagementProfiles;
use App\OtherShareholders;
use App\PromoterDetails;
use App\Ratings;

class CompanyDetailsController extends Controller
{
    public function index()
    {
        //
    }

    public function create($id)
    {
        //dd($id);
        $prod_id = $id;
        $user = Auth::user();
        if (!in_array($prod_id, $user->eligible_product)) {
            alert()->error('Eligible Product not selected', 'Attention!')->persistent('Close');
            return redirect()->route('home');
        } elseif (in_array($prod_id, $user->eligible_product)) {
            $app = ApplicationMast::where('created_by', Auth::user()->id)
                ->where('eligible_product', $id)
                ->first();

            if ($app) {
                alert()->error('Application already exists for this product', 'Attention!')->persistent('Close');
                return redirect()->route('home');
            } else {
                $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');
                $prods = DB::table('eligible_products')->orderBy('id')->get();
                return view('user.app.details-create', compact('prod_id', 'user', 'states', 'prods'));
            }
        }
    }

    public function store(CompanyDetStore $request)
    {
        //dd($request);

        $user = Auth::user();
        $appMast = new ApplicationMast;
        $compDet = new CompanyDetails;
        $promData = $request->prom;
        $otherData = $request->other;
        $gstinData = $request->gstin;
        $audData = $request->aud;
        $ratData = $request->rat;
        $topManData = $request->topMan;
        $kmpData = $request->kmp;

        $maxid = getMaxID($appMast->getTable());


        $maxid = $maxid + 1;


        $appMast->fill([
            'id' => $maxid,
            'status' => 'D',
            'eligible_product' => $request->prod_id,
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'app_round'=>'4'
        ]);

        $compDet->fill([
            'comp_const' => $request->comp_const,
            'bus_profile' => $request->bus_profile,
            'doi' => $request->doi,
            'website' => $request->website,
            'listed' => $request->listed,
            'stock_exchange' => $request->stock_exchange,
            'corp_add' => $request->corp_add,
            'corp_state' => $request->corp_state,
			'externalcreditrating'=>$request->externalcreditrating,
            'corp_city' => $request->corp_city,
            'corp_pin' => $request->corp_pin,
            'bankruptcy' => $request->bankruptcy,
            'rbi_default' => $request->rbi_default,
            'wilful_default' => $request->wilful_default,
            'sebi_barred' => $request->sebi_barred,
            'cibil_score' => $request->cibil_score,
            'case_pend' => $request->case_pend,
            'created_by' => $user->id
        ]);

        DB::transaction(function () use ($appMast, $compDet, $promData, $otherData, $gstinData, $audData, $ratData, $topManData, $kmpData) {
            $appMast->save();
            $max_appid = getMaxID($appMast->getTable());
            AppStage::create(['app_id' => $max_appid, 'stage' => 1, 'status' => 'D']);
            $compDet->app_id = $max_appid;
            $compDet->save();

            if ($promData) {
                foreach ($promData as $value) {
                    PromoterDetails::create([
                        'app_id' => $max_appid,
                        'name' => $value['name'],
                        'shares' => $value['shares'],
                        'per' => $value['per'],
                        'capital' => $value['capital']
                    ]);
                }
            }

            if ($otherData) {
                foreach ($otherData as $value) {
                    OtherShareholders::create([
                        'app_id' => $max_appid,
                        'name' => $value['name'],
                        'shares' => $value['shares'],
                        'per' => $value['per'],
                        'capital' => $value['capital']
                    ]);
                }
            }

            if ($gstinData) {
                foreach ($gstinData as $value) {
                    Gstins::create([
                        'app_id' => $max_appid,
                        'gstin' => $value['gstin'],
                        'add' => $value['add']
                    ]);
                }
            }

            if ($audData) {
                foreach ($audData as $value) {
                    Auditors::create([
                        'app_id' => $max_appid,
                        'name' => $value['name'],
                        'frn' => $value['frn'],
                        'fy' => $value['fy']
                    ]);
                }
            }

            if ($ratData) {
                foreach ($ratData as $value) {
                    Ratings::create([
                        'app_id' => $max_appid,
                        'rating' => $value['rating'] ?? '',
                        'name' => $value['name'] ?? '',
                        'date' => $value['date'] ?? '',
                        'validity' => $value['validity'] ?? ''
                    ]);
                }
            }

            if ($topManData) {
                foreach ($topManData as $value) {
                    ManagementProfiles::create([
                        'app_id' => $max_appid,
                        'name' => $value['name'],
                        'email' => $value['email'],
                        'phone' => $value['phone'],
                        'din' => $value['din'],
                        'add' => $value['add']
                    ]);
                }
            }

            if ($kmpData) {
                foreach ($kmpData as $value) {
                    Kmps::create([
                        'app_id' => $max_appid,
                        'name' => $value['name'],
                        'email' => $value['email'],
                        'phone' => $value['phone'],
                        'pan_din' => $value['pan_din']
                    ]);
                }
            }
        });

        alert()->success('Company Details Saved', 'Success')->persistent('Close');
        return redirect()->route('applications.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $appMast = ApplicationMast::where('id', $id)->where('created_by', Auth::user()->id)->where('status', 'D')->first();
        if (!$appMast) {
            alert()->error('No Draft Application!', 'Attention!')->persistent('Close');
            return redirect()->route('applications.index');
        }
        $stage = $appMast->stages->where('app_id', $id)->where('stage', 1)->first();

        if (!$stage) {
            return redirect()->route('companydetails.create', $appMast->eligible_product);
        }

        $user = Auth::user();
        $comp = $appMast->details;
        $promoters = $appMast->promoters;
        $others = $appMast->otherShareholders;
        $gstins = $appMast->gstins;
        $auditors = $appMast->auditors;
        $profiles = $appMast->profiles;
        $ratings = $appMast->ratings;
        $kmps = $appMast->kmps;
        //dd($promoters);


        $prods = DB::table('eligible_products')->orderBy('id')->get();
        $states = DB::table('pincodes')->whereNotNull('state')->orderBy('state')->get()->unique('state')->pluck('state', 'state');
        $cities = DB::table('pincodes')->where('state', $comp->corp_state)->orderBy('city')->get()->unique('city')->pluck('city', 'city');

        return view('user.app.details-edit', compact('appMast', 'comp', 'user', 'prods', 'states', 'cities', 'promoters', 'others', 'gstins', 'auditors', 'profiles', 'ratings', 'kmps'));
    }

    public function update(CompanyDetStore $request, $id)
    {
        //dd($request);
        $user = Auth::user();
        $appMast = ApplicationMast::where('id', $id)->where('created_by', $user->id)->where('status', 'D')->first();
        $compDet = $appMast->details;
        $promData = $request->prom;
        $otherData = $request->other;
        $gstinData = $request->gstin;
        $audData = $request->aud;
        $ratData = $request->rat;
        $topManData = $request->topMan;
        $kmpData = $request->kmp;

        $compDet->fill([
            'comp_const' => $request->comp_const,
            'bus_profile' => $request->bus_profile,
            'doi' => $request->doi,
            'website' => $request->website,
            'listed' => $request->listed,
            'stock_exchange' => $request->stock_exchange,
            'corp_add' => $request->corp_add,
            'corp_state' => $request->corp_state,
            'corp_city' => $request->corp_city,
			'externalcreditrating'=>$request->externalcreditrating,
            'corp_pin' => $request->corp_pin,
            'bankruptcy' => $request->bankruptcy,
            'rbi_default' => $request->rbi_default,
            'wilful_default' => $request->wilful_default,
            'sebi_barred' => $request->sebi_barred,
            'cibil_score' => $request->cibil_score,
            'case_pend' => $request->case_pend,
        ]);

        DB::transaction(function () use ($appMast, $compDet, $promData, $otherData, $gstinData, $audData, $ratData, $topManData, $kmpData) {
            $compDet->save();

            if ($promData) {
                foreach ($promData as $value) {
                    if (isset($value['id'])) {
                        $pro = PromoterDetails::find($value['id']);
                        $pro->name = $value['name'];
                        $pro->shares = $value['shares'];
                        $pro->per = $value['per'];
                        $pro->capital = $value['capital'];
                        $pro->save();
                    } else {
                        PromoterDetails::create([
                            'app_id' => $appMast->id,
                            'name' => $value['name'],
                            'shares' => $value['shares'],
                            'per' => $value['per'],
                            'capital' => $value['capital']
                        ]);
                    }
                }
            }

            if ($otherData) {
                foreach ($otherData as $value) {
                    if (isset($value['id'])) {
                        $oth = OtherShareholders::find($value['id']);
                        $oth->name = $value['name'];
                        $oth->shares = $value['shares'];
                        $oth->per = $value['per'];
                        $oth->capital = $value['capital'];
                        $oth->save();
                    } else {
                        OtherShareholders::create([
                            'app_id' => $appMast->id,
                            'name' => $value['name'],
                            'shares' => $value['shares'],
                            'per' => $value['per'],
                            'capital' => $value['capital']
                        ]);
                    }
                }
            }

            if ($gstinData) {
                foreach ($gstinData as $value) {
                    if (isset($value['id'])) {
                        $gstin = Gstins::find($value['id']);
                        $gstin->gstin = $value['gstin'];
                        $gstin->add = $value['add'];
                        $gstin->save();
                    } else {
                        Gstins::create([
                            'app_id' => $appMast->id,
                            'gstin' => $value['gstin'],
                            'add' => $value['add']
                        ]);
                    }
                }
            }

            if ($audData) {
                foreach ($audData as $value) {
                    if (isset($value['id'])) {
                        $aud = Auditors::find($value['id']);
                        $aud->name = $value['name'];
                        $aud->frn = $value['frn'];
                        $aud->fy = $value['fy'];
                        $aud->save();
                    } else {
                        Auditors::create([
                            'app_id' => $appMast->id,
                            'name' => $value['name'],
                            'frn' => $value['frn'],
                            'fy' => $value['fy']
                        ]);
                    }
                }
            }

            if ($ratData) {
                foreach ($ratData as $value) {
                    if (isset($value['id'])) {
                        $rat = Ratings::find($value['id']);
                        $rat->rating = $value['rating'];
                        $rat->name = $value['name'];
                        $rat->date = $value['date'];
                        $rat->validity = $value['validity'];
                        $rat->save();
                    } else {
                        Ratings::create([
                            'app_id' => $appMast->id,
                            'rating' => $value['rating'],
                            'name' => $value['name'],
                            'date' => $value['date'],
                            'validity' => $value['validity']
                        ]);
                    }
                }
            }

            if ($topManData) {
                foreach ($topManData as $value) {
                    if (isset($value['id'])) {
                        $mps = ManagementProfiles::find($value['id']);
                        $mps->name = $value['name'];
                        $mps->email = $value['email'];
                        $mps->phone = $value['phone'];
                        $mps->din = $value['din'];
                        $mps->add = $value['add'];
                        $mps->save();
                    } else {
                        ManagementProfiles::create([
                            'app_id' => $appMast->id,
                            'name' => $value['name'],
                            'email' => $value['email'],
                            'phone' => $value['phone'],
                            'din' => $value['din'],
                            'add' => $value['add']
                        ]);
                    }
                }
            }

            if ($kmpData) {
                foreach ($kmpData as $value) {
                    if (isset($value['id'])) {
                        $kmp = Kmps::find($value['id']);
                        $kmp->name = $value['name'];
                        $kmp->email = $value['email'];
                        $kmp->phone = $value['phone'];
                        $kmp->pan_din = $value['pan_din'];
                        $kmp->save();
                    } else {
                        Kmps::create([
                            'app_id' => $appMast->id,
                            'name' => $value['name'],
                            'email' => $value['email'],
                            'phone' => $value['phone'],
                            'pan_din' => $value['pan_din']
                        ]);
                    }
                }
            }
        });



        alert()->success('Applicant Details Saved', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deletePromoter($id)
    {
        $det = PromoterDetails::where('id', $id)->first();
        $det->delete();

        alert()->success('This entry has been Deleted', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deleteOther($id)
    {
        $det = OtherShareholders::where('id', $id)->first();
        $det->delete();

        alert()->success('This entry has been Deleted', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deleteGstin($id)
    {
        $det = Gstins::where('id', $id)->first();
        $det->delete();

        alert()->success('This entry has been Deleted', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deleteAuditor($id)
    {
        $det = Auditors::where('id', $id)->first();
        $det->delete();

        alert()->success('This entry has been Deleted', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deleteRating($id)
    {
        $det = Ratings::where('id', $id)->first();
        $det->delete();

        alert()->success('This entry has been Deleted', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deleteProfile($id)
    {
        $det = ManagementProfiles::where('id', $id)->first();
        $det->delete();

        alert()->success('This entry has been Deleted', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function deleteKmp($id)
    {
        $det = Kmps::where('id', $id)->first();
        $det->delete();

        alert()->success('This entry has been Deleted', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
