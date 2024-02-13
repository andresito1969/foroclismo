<?php

namespace App\Repositories;
use App\Models\Topic;


class TopicRepository implements TopicRepositoryInterface{

    public function createTopic(array $data) : void {
        $topic = new Topic($data);

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