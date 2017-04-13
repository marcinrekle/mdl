<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'count', 'drive_id',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function drive()
    {
    	return $this->belongsTo('App\Drive');
    }
}
