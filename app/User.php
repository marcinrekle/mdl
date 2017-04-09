<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'social_id', 'avatar', 'remember_token', 'social_token', 'confirmed', 'confirm_code',
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

    public function role()
    {
        return $this->hasOne('App\Role');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function drives()
    {
        return $this->hasMany('App\Drive');
    }

}
