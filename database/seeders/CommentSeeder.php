<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->insert([
            'text' => 'Buenas admin, a mí me gusta más MTB, me siento más seguro y prefiero más un entorno natural sin el ruido y el humo de los coches, saludos!',
            'user_id' => 2,
            'topic_id' => 1
        ]);
    }
}
