<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

use App\Permission;

class Role extends EntrustRole
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
	/*public function getRouteKeyName()
	{
	    return 'name';
	}
    */
}
