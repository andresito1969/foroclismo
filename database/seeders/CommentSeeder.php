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

        DB::table('comments')->insert([
            'text' => 'Gracias Juan por el comentario!',
            'user_id' => 1,
            'topic_id' => 1
        ]);

        // otro comentario que nada tiene que ver con el primer post, este comentario es del 2do post
        DB::table('comments')->insert([
            'text' => 'Suelo hacer 20km, que se me había olvidado de poner el texto del post!',
            'user_id' => 1,
            'topic_id' => 2
        ]);
    }
}
