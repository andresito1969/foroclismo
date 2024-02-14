<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'last_name' => 'Admin',
            'is_admin' => true,
            'email' => 'admin@foroclismo.com',
            'password' => bcrypt('test12')
        ]);

        // aquí creamos un usuario no admin (sin especificarlo), como el valor por defecto es false, ya lo creará sin la necesidad de poner el booleano. 
        DB::table('users')->insert([
            'name' => 'Juan',
            'last_name' => 'Gómez',
            'email' => 'juan_gomez@foroclismo.com',
            'password' => bcrypt('test12')
        ]);

        DB::table('users')->insert([
            'name' => 'Mod',
            'last_name' => 'Mod',
            'email' => 'mod@foroclismo.com',
            'is_mod' => 1,
            'password' => bcrypt('test12')
        ]);

        DB::table('users')->insert([
            'name' => 'Banned',
            'last_name' => 'User',
            'email' => 'banned@foroclismo.com',
            'banned_user' => 1,
            'password' => bcrypt('test12')
        ]);
    }
}
