<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['payment_date', 'user_id','payment_for', 'amount'];

    public function users()
    {
    	return $this->belongsTo('App\User');
    }
}
