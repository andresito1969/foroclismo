<?php

namespace App\Repositories;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;


class TopicRepository {

    public function createTopic(array $data) : void {
        $topic = new Topic([
            'title' => $data['title'],
            'topic_text' => $data['topic_text'],
            'user_id' => Auth::id()
        ]);

        $topic->save();
    }

    public function getAllTopics() {
        return Topic::select()
            ->leftjoin('users', 'users.id', 'topics.user_id')
            ->select('topics.*', 'users.name', 'users.last_name')
            ->orderBy('topics.id', 'DESC')
            ->get();
    }

    public function getSingleTopic($id) {
        return Topic::findOrFail($id);
    }

    public function update($topicModel, array $data) : void {
        $topicModel->update($data);
    }

    public function deleteTopic($topicModel) : void {
        $topicModel->comments()->delete(); 
        $topicModel->delete();
    }

    public function getTitleLengthCheck(array $data) {
        return Topic::titleLengthCheck($data['title']);
    }

    public function getTextLengthCheck(array $data) {
        return Topic::textLengthCheck($data['topic_text']);
    }
}