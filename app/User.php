<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'social_id', 'avatar', 'remember_token', 'social_token', 'confirmed', 'confirm_code','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function attrs()
    {
        return $this->hasOne('App\UserAttrs');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment')->orderByDesc('payment_date');
    }

    public function drives()
    {
        return $this->hasMany('App\Drive');
    }

    public function services()
    {
        return $this->belongsToMany('App\Service');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
