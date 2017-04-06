<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
	protected $casts = [
        'options' => 'array'
    ];
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

}
