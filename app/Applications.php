<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    protected $table = 'applications';
    public $incrementing = false;

    protected $fillable = [
        'id','app_no','status', 'eligible_product','created_by', 'updated_by','submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function stages()
    {
        return $this->hasMany('App\AppStage', 'app_id');
    }

    public function details()
    {
        return $this->hasOne('App\CompanyDetails', 'app_id');
    }

    public function auditors()
    {
        return $this->hasMany('App\Auditors', 'app_id');
    }

    public function profiles()
    {
        return $this->hasMany('App\ManagementProfiles', 'app_id');
    }

    public function kmps()
    {
        return $this->hasMany('App\Kmps', 'app_id');
    }

    public function gstins()
    {
        return $this->hasMany('App\Gstins', 'app_id');
    }

    public function promoters()
    {
        return $this->hasMany('App\PromoterDetails', 'app_id');
    }

    public function otherShareholders()
    {
        return $this->hasMany('App\OtherShareholders', 'app_id');
    }

    public function ratings()
    {
        return $this->hasMany('App\Ratings', 'app_id');
    }

    public function eligibility()
    {
        return $this->hasOne('App\EligibilityCriteria', 'app_id');
    }

    public function fees()
    {
        return $this->hasOne('App\FeeDetails', 'app_id');
    }

    public function groups()
    {
        return $this->hasMany('App\GroupCompanies', 'app_id');
    }

    public function financials()
    {
        return $this->hasOne('App\Financials', 'app_id');
    }

    public function documents()
    {
        return $this->hasMany('App\DocumentUploads', 'app_id');
    }

    public function undertakings()
    {
        return $this->hasOne('App\UndertakingDetails', 'app_id');
    }

    public function proposalDetails()
    {
        return $this->hasOne('App\ProposalDetails', 'app_id');
    }

    public function projectDetails()
    {
        return $this->hasMany('App\ProjectDetails', 'app_id');
    }

    public function evaluations()
    {
        return $this->hasOne('App\EvaluationDetails', 'app_id');
    }

    public function investments()
    {
        return $this->hasMany('App\InvestmentDetails', 'app_id');
    }

    public function fundings()
    {
        return $this->hasMany('App\FundingDetails', 'app_id');
    }

    public function revenues()
    {
        return $this->hasOne('App\Revenues', 'app_id');
    }

    public function employments()
    {
        return $this->hasOne('App\Employments', 'app_id');
    }

    public function dvas()
    {
        return $this->hasOne('App\DvaDetails', 'app_id');
    }

    public function krms()
    {
        return $this->hasMany('App\Krms', 'app_id');
    }

}
