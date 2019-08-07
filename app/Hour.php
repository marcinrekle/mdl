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
        'service_id', 'count', 'drive_id',
    ];

    public function services()
    {
    	return $this->belongsTo('App\Services');
    }

    public function drive()
    {
    	return $this->belongsTo('App\Drive');
    }
}
