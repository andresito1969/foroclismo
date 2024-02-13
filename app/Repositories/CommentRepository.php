<?php

namespace App\Repositories;
use App\Models\Comment;
// use Illuminate\Support\Facades\Auth;


class CommentRepository implements CommentRepositoryInterface {
    public function createComment(array $data) : void {
        $comment = new Comment($data);
        $comment->save();
    }

    public function getSingleMessage($id) {
        return Comment::findOrFail($id);
    }

    public function findByTopicId($topicId) {
        return Comment::select()
            ->join('users', 'users.id', 'comments.user_id')
            ->where('comments.topic_id', '=', $topicId)
            ->select('comments.*', 'users.name', 'users.last_name')
            ->orderBy('comments.id')
            ->get();
    }

    public function update($commentModel, array $data) : void {
        $commentModel->update($data);
    }

    public function delete($commentModel) : void{
        $commentModel->delete();
    }

    public function getTextLengthCheck($text) {
        return strlen($text) > 0 && strlen($text) <= Comment::maxLengthText;
    }
}