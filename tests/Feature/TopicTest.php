<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Topic;
use App\Models\User;


class TopicTest extends TestCase
{
    public function test_show_existent_topic(): void
    {

        $response = $this->get('/topic/1');

        $response->assertStatus(200);

    }

    public function test_show_unexistent_topic(): void
    {

        $response = $this->get('/topic/-1');

        $response->assertStatus(404);

    }

    private function getUser() {

        $user = User::create([
            'name' => 'test',
            'last_name' => 'test',
            'email' => 'test1@foroclismo.com',
            'password' => bcrypt(123)
        ]);

        return $user;
    }

    public function test_create_topic(): void {

        $user = $this->getUser();

        $response = $this->post('/create_topic', [
            'title' => 'Test título',
            'topic_text' => 'Esta es una prueba',
            'user_id' => $user->id
        ]);

        $topic = Topic::where('user_id', $user->id);
        $response->assertStatus(302);
        
        // Borra los datos que acabamos de crear, para evitar inconsistencias
        $topic->delete();
        $user->delete();
    }

    public function test_incorrect_create_topic_missing_id(): void {

        // Borra el usuario que acabamos de crear, para evitar inconsistencias

        $response = $this->post('/create_topic', [
            'title' => 'Test título',
            'topic_text' => 'Esta es una prueba',
        ]);


        $response->assertStatus(500);
    }

    public function test_incorrect_create_topic_missing_title(): void {

        // Borra el usuario que acabamos de crear, para evitar inconsistencias

        $response = $this->post('/create_topic', [
            'topic_text' => 'Esta es una prueba',
            'user_id' => 1
        ]);


        $response->assertStatus(500);
    }

    public function test_incorrect_create_topic_missing_topic_text(): void {

        // Borra el usuario que acabamos de crear, para evitar inconsistencias

        $response = $this->post('/create_topic', [
            'title' => 'Test título',
            'user_id' => 1
        ]);


        $response->assertStatus(500);
    }
}
