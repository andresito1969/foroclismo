<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Topic;
use App\Models\User;


class TopicTest extends TestCase
{
    private User $user;
    private Topic $topic;

    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->topic = Topic::factory()->create([
            'user_id' => $this->user->id
        ]);
    }

    protected function tearDown() : void {
        $this->user->topics()->delete();
        $this->user->delete();
        parent::tearDown();
    }

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
        $user = $this->user;
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/topic/create', [
                'title' => 'Test título',
                'topic_text' => 'Esta es una prueba',
                'user_id' => $user->id
            ]);

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
        $user = $this->user;
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/topic/create', [
                'topic_text' => 'Esta es una prueba',
                'user_id' => $user->id
            ]);

        $response->assertRedirect('/topic/create/topic');
    }

    public function test_edit_topic() : void {
        $user = $this->user;
        $topic = $this->topic;
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->patch('/topic/' . $topic->id . '/edit_topic', [
                'text' => 'lel',
                'title' => 'lal'
            ]);

        $response->assertRedirect('/topic/' . $topic->id);
    }

    public function test_incorrect_edit_topic_null_text() : void {
        $user = $this->user;
        $topic = $this->topic;
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->patch('/topic/' . $topic->id . '/edit_topic', [
                'text' => '',
                'title' => 'lal'
            ]);
        
        $response->assertRedirect('');
    }

    public function test_delete_topic() : void {
        $user = $this->user;
        $topic = $this->topic;

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/topic/' . $topic->id . '/delete');


        $response->assertStatus(302);
    }

    public function test_incorrect_delete_topic_malicious_auth() : void {
        $user = $this->user;
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/topic/1/delete');

        $response->assertStatus(404);
    }

    public function test_incorrect_delete_topic_not_logged() : void {
        $response = $this->delete('/topic/1/delete');

        $response->assertRedirect('login');
    }
}
