<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description','defaults'
    ];

    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    public function hours()
    {
        return $this->hasMany('App\Hour');
    }
}
