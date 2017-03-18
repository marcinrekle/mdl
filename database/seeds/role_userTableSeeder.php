<?php

use Illuminate\Database\Seeder;

class role_userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 6 ; $i++) { 
        	DB::table('role_user')->insert([
            	'user_id' 	=> $i,
            	'role_id'	=> $i,
        	]);
        }
        
    }
}
