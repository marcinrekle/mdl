<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'date','hours_count'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function hours()
    {
        return $this->hasMany('App\Hour');
    }
}
