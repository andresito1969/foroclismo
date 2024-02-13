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

    // TODO: I SHOULD GO TO THE ROUTE NAME INSTEAD OF ABSOLUTE ROUTE (TOPIC/CREATE)
    public function test_create_topic(): void {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/topic/create', [
                'title' => 'Test título',
                'topic_text' => 'Esta es una prueba',
                'user_id' => $user->id
            ]);

        $topic = Topic::where('user_id', $user->id);
        
        // Borra los datos que acabamos de crear, para evitar inconsistencias
        $topic->delete();
        $user->delete();

        $response->assertStatus(302);
    }

    public function test_incorrect_create_topic_missing_id(): void {
        $response = $this->post('/topic/create', [
                'title' => 'Test título',
                'topic_text' => 'Esta es una prueba'
            ]);

        $response->assertRedirect('/login');
    }

    public function test_incorrect_create_topic_missing_title(): void {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/topic/create', [
                'topic_text' => 'Esta es una prueba',
                'user_id' => $user->id
            ]);

        $topic = Topic::where('user_id', $user->id);
        
        // Borra los datos que acabamos de crear, para evitar inconsistencias
        $topic->delete();
        $user->delete();

        $response->assertRedirect('/topic/create/topic');
    }
}
