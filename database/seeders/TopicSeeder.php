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
    }
}
