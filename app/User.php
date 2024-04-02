<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'mobile', 'mobile_verified_at',
        'type', 'pan', 'cin_llpin', 'off_add', 'off_state', 'off_city', 'off_pin', 'existing_manufacturer', 'business_desc', 'applicant_desc',
        'target_segment', 'eligible_product', 'contact_person', 'designation', 'contact_add', 'isotpverified', 'isactive', 'isapproved',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    public function applications()
    {
        return $this->hasMany('App\ApplicationMast', 'created_by');
    }

    public function documents()
    {
        return $this->hasMany('App\DocumentUploads', 'user_id');
    }

    public function setEligibleProductAttribute($value)
    {
        $this->attributes['eligible_product'] = implode(',', $value);
    }

    public function getEligibleProductAttribute($value)
    {
        return explode(',', $value);
    }
}
