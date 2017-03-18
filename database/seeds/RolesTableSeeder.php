<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' 			=> 'SU',
            'display_name'	=> 'Super User',
            'description'	=> ''
        ]);

        DB::table('roles')->insert([
            'name' 			=> 'Admin',
            'display_name'	=> 'Administrator',
            'description'	=> ''
        ]);

        DB::table('roles')->insert([
            'name' 			=> 'Instructor',
            'display_name'	=> 'Instruktor',
            'description'	=> ''
        ]);

        DB::table('roles')->insert([
            'name' 			=> 'Student',
            'display_name'	=> 'Użytkownik',
            'description'	=> ''
        ]);

        DB::table('roles')->insert([
            'name' 			=> 'Officce',
            'display_name'	=> 'Pracownik biurowy',
            'description'	=> ''
        ]);
    }
}
