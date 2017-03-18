<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' 			=> 'user-create',
            'display_name'	=> 'Dodawanie użytkownika',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'user-retrive',
            'display_name'	=> 'Przeglądania użytkownika',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'user-update',
            'display_name'	=> 'Edycja użytkownika',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'user-delete',
            'display_name'	=> 'Usuwanie użytkownika',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'student-crud',
            'display_name'	=> 'Operacje na kursantach',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'instructor-crud',
            'display_name'	=> 'Operacje na Instruktorach',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'officce-crud',
            'display_name'	=> 'Operacje na pracownikach biurowych',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'admin-crud',
            'display_name'	=> 'Operacje na adminach',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'payment-crud',
            'display_name'	=> 'Operacje na płatnościach',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'hours-crud',
            'display_name'	=> 'Operacje na jazdach',
            'description'	=> ''
        ]);

        DB::table('permissions')->insert([
            'name' 			=> 'hours-add',
            'display_name'	=> 'Zapis na jazdy',
            'description'	=> ''
        ]);
    }
}
