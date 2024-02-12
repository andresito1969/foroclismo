<?php

namespace App\Repositories;
use App\Models\Comment;
// use Illuminate\Support\Facades\Auth;


class CommentRepository {

    public function findByTopicId($topicId) {
        return Comment::select()
            ->join('users', 'users.id', 'comments.user_id')
            ->where('comments.topic_id', '=', $topicId)
            ->select('comments.*', 'users.name', 'users.last_name')
            ->orderBy('comments.id')
            ->get();
    }
}