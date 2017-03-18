<?php

use Illuminate\Database\Seeder;

class permission_roleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 12; $i++) { 
            DB::table('permission_role')->insert([
                'permission_id' => $i,
                'role_id'       => 1,
            ]);            
        }

        DB::table('permission_role')->insert([
            'permission_id' => 1,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 2,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 3,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 4,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 5,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 6,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 8,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 9,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 10,
            'role_id'		=> 2,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 10,
            'role_id'		=> 3,
        ]);

        DB::table('permission_role')->insert([
            'permission_id' => 11,
            'role_id'		=> 4,
        ]);


        DB::table('permission_role')->insert([
            'permission_id' => 9,
            'role_id'       => 5,
        ]);

    }
}
