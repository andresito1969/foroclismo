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
    private User $user;
    private Comment $comment;
    private Comment $createdComment;
    private Topic $topic;

    // Constructor called in every call of a test, so we have default models instead of creating them in every call
    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->topic = Topic::first();
        $this->comment = Comment::first();
        $this->createdComment = Comment::factory()->create([
            'topic_id' => $this->topic->id,
            'user_id' => $this->user->id
        ]);
    }

    // Destruct all the fake data created
    protected function tearDown() : void {
        $this->user->comments()->delete();
        $this->user->delete();
        parent::tearDown();
    }

    public function test_create_comment() : void {
        $response = $this->actingAs($this->user)
            ->withSession(['banned' => false])
            ->post('/topic/' . $this->topic->id . '/create_comment', [
                'text' => 'Testeo!'
            ]);

        $response->assertRedirect('/topic/' . $this->topic->id);
    }

    public function test_incorrect_create_comment_no_auth() {
        $topic = $this->topic;
        $response = $this->post('/topic/' . $topic->id . '/create_comment', [
            'text' => 'Testeo!'
        ]);

        $response->assertRedirect('login');
    }

    public function test_incorrect_create_comment_no_text() {
        $user = $this->user;
        $topic = $this->topic;

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/topic/' . $topic->id . '/create_comment');

        $response->assertRedirect('');
    }

    public function test_edit_existent_comment_view() : void {
        $user = $this->user;
        $topic = $this->topic;
        $comment = $this->createdComment;

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id);

        $response->assertStatus(200);
    }

    public function test_incorrect_edit_existent_comment_view_no_auth() : void {
        $comment = $this->comment;

        $response = $this->get('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id);

        $response->assertRedirect('login');
    }

    public function test_edit_comment() : void {
        $user = $this->user;
        $topic = $this->topic;
        $comment = $this->createdComment;

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->patch('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id, [
                'text' => 'Funcionó?'
            ]);

        $response->assertRedirect('/topic/' . $comment->topic_id);
    }

    public function test_incorrect_edit_comment_no_auth() : void {
        $topic = $this->topic;
        $comment = $this->comment;

        $response = $this->patch('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id, [
            'text' => 'Funcionó?'
        ]);

        $response->assertRedirect('/login');
    }

    public function test_incorrect_edit_comment_no_text() : void {
        $user = $this->user;
        $topic = $this->topic;
        $comment = $this->createdComment;

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->patch('/topic/' . $comment->topic_id . '/edit_comment/' . $comment->id);

        $response->assertRedirect('');
    }

    public function test_delete_comment() : void {
        $user = $this->user;
        $topic = $this->topic;
        $comment = $this->createdComment;

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/topic/' . $comment->topic_id . '/comment/' . $comment->id);
        
        $response->assertRedirect('/topic/' . $comment->topic_id);
    }

    public function test_incorrect_delete_comment_no_auth() : void {
        $comment = $this->comment;

        $response = $this->delete('/topic/' . $comment->topic_id . '/comment/' . $comment->id);
        $response->assertRedirect('login');
    }

    public function test_incorrect_delete_comment_malicious_auth() : void {
        $user = $this->user;
        $comment = $this->comment;

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->delete('/topic/' . $comment->topic_id . '/comment/' . $comment->id);
    
        $response->assertStatus(404);
    }
}
