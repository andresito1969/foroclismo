<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Topic;
use App\Models\User;
use App\Models\Comment;

class CommentTest extends TestCase
{

    public function test_create_comment() : void {
        $user = User::factory()->create();
        $topic = Topic::first();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/topic/' . $topic->id . '/create_comment', [
                'text' => 'Testeo!'
            ]);

        $user->comments()->delete();
        $user->delete();

        $response->assertRedirect('/topic/' . $topic->id);
    }

    public function test_incorrect_create_comment_no_auth() {
        $topic = Topic::first();
        $response = $this->post('/topic/' . $topic->id . '/create_comment', [
            'text' => 'Testeo!'
        ]);

        $response->assertRedirect('login');
    }

    public function test_incorrect_create_comment_no_text() {
        $user = User::factory()->create();
        $topic = Topic::first();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/topic/' . $topic->id . '/create_comment');

        $user->comments()->delete();
        $user->delete();

        $response->assertRedirect('');
    }

    public function test_edit_existent_comment_view() : void {
        $user = User::factory()->create();
        $topic = Topic::first();
        $comment = Comment::factory()->create([
            'topic_id' => $topic->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id);

        $comment->delete();
        $user->delete();

        $response->assertStatus(200);
    }

    public function test_incorrect_edit_existent_comment_view_no_auth() : void {
        $comment = Comment::first();

        $response = $this->get('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id);

        $response->assertRedirect('login');
    }

    public function test_edit_comment() : void {
        $user = User::factory()->create();
        $topic = Topic::first();
        $comment = Comment::factory()->create([
            'topic_id' => $topic->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->patch('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id, [
                'text' => 'Funcionó?'
            ]);

        $comment->delete();
        $user->delete();

        $response->assertRedirect('/topic/' . $comment->topic_id);
    }

    public function test_incorrect_edit_comment_no_auth() : void {
        $topic = Topic::first();
        $comment = Comment::first();

        $response = $this->patch('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id, [
            'text' => 'Funcionó?'
        ]);

        $response->assertRedirect('/login');
    }

    public function test_incorrect_edit_comment_no_text() : void {
        $user = User::factory()->create();
        $topic = Topic::first();
        $comment = Comment::factory()->create([
            'topic_id' => $topic->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->patch('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id);

        $comment->delete();
        $user->delete();

        $response->assertRedirect('');
    }

    public function test_delete_comment() : void {
        $user = User::factory()->create();
        $topic = Topic::first();
        $comment = Comment::factory()->create([
            'topic_id' => $topic->id,
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/topic/' . $comment->topic_id . '/comment/' . $comment->id);
        
        $user->delete();

        $response->assertRedirect('/topic/' . $comment->topic_id);
    }

    public function test_incorrect_delete_comment_no_auth() : void {
        $comment = Comment::first();

        $response = $this->delete('/topic/' . $comment->topic_id . '/comment/' . $comment->id);
        $response->assertRedirect('login');
    }

    public function test_incorrect_delete_comment_malicious_auth() : void {
        $user = User::factory()->create();
        $comment = Comment::first();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/topic/' . $comment->topic_id . '/comment/' . $comment->id);
    
        $user->delete();

        $response->assertStatus(404);
    }
}
