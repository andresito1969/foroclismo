<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('topics')->insert([
            'title' => 'Bici MTB o Carretera?',
            'topic_text' => 'Soy bastante nuevo en esto del ciclismo, qué creéis que es mejor, hacer rutas en carretera o en montaña?',
            'user_id' => 1,
        ]);

        DB::table('topics')->insert([
            'title' => 'Cuántos km hacéis a la semana?',
            'topic_text' => 'Me gustaría saber más o menos de madia cuantos km hacéis!',
            'user_id' => 2,
        ]);

        DB::table('topics')->insert([
            'title' => 'Preséntate :D!',
            'topic_text' => 'Buenas a tod@s! Os habla el administrador del foro, podéis presentaros en este hilo!',
            'user_id' => 1,
        ]);
    }
}
