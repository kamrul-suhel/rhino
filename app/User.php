<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * Available rule for user
     */
    const USERADMIN = 'admin';
    const USERDEALERSHIP = 'dealership';
    const USERGROUP = 'group';
    const USERREGION = 'region';
    const USERRCOUNTRY = 'country';
    const USERBRAND = 'brand';
    const USERSALEEXECUTIVE = 'sales_executive';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
    ];


    /**
     * Get user brand
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function brands(){
        return $this->belongsToMany(Brand::class,'brand_user', 'user_id', 'brand_id')
            ->withPivot(['new', 'used']);
    }

    /**
     * Get brand user pivot table info
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specializeBrands(){
        return $this->hasMany(BrandUser::class);
    }

    /**
     * Belong to one dealership
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dealership(){
        return $this->belongsTo(Dealership::class);
    }

    public function dealerships()
    {
        return $this->belongsToMany(Dealership::class, 'dealership_user', 'user_id', 'dealership_id')->withTimestamps();
    }

    /**
     * Belong to one group
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group(){
        return $this->belongsTo(Group::class);
    }

    /**
     * Belong to one region
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region(){
        return $this->belongsTo(Region::class);
    }


    /**
     * Belong to one country
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(){
       return $this->belongsTo(Country::class);
    }

    /**
     * Belong to one company
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(){
        return $this->belongsTo(Company::class);
    }
}
