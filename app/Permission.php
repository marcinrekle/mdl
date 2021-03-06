<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

}
