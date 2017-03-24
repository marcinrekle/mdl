<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Student extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hours_count', 'hours_start','cost','status'];
    
	public function user()
    {
    	return $this->belongsTo('App\User');
    }

}
