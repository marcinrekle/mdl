<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustRole;
use Illuminate\Support\Facades\Config;

use App\Permission;

class Role extends LaratrustRole
{
 
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

    /**
	 * Get the route key for the model.
	 *
	 * @return string
	 */
	public function getRouteKeyName()
	{
	    return 'name';
	}

    /**
 * BelongsToMany relations with the user model.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
public function users()
{
    return $this->belongsToMany(Config::get('auth.providers.users.model'),Config::get('laratrust.role_user_table'),Config::get('laratrust.role_foreign_key'),Config::get('laratrust.user_foreign_key'));
}
    
}
