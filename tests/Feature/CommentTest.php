<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DB;

class CommentTest extends TestCase
{
    public function test_show_existent_comment(): void
    {

        $commentList = DB::table('comments')
                ->join('users', 'users.id', 'comments.user_id')
                ->where('comments.topic_id', '=', 1)
                ->orderBy('comments.id')
                ->get();
        $foundComments = count($commentList) > 0;
        $this->assertTrue($foundComments);

    }

    public function test_show_unexistent_comment(): void
    {

        $commentList = DB::table('comments')
                ->join('users', 'users.id', 'comments.user_id')
                ->where('comments.topic_id', '=', -1)
                ->orderBy('comments.id')
                ->get();
        $foundComments = count($commentList) == 0;
        $this->assertTrue($foundComments);

    }
}
