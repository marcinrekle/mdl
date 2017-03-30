<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAttrs extends Model
{
    // Cast attributes JSON to array
    protected $casts = [
        'values' => 'array'
    ];

    /**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
