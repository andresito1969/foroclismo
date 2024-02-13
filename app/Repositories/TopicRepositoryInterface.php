<?php

namespace App\Repositories;

interface TopicRepositoryInterface{
    public function createTopic(array $data);

    public function getAllTopics();

    public function getSingleTopic($id);

    public function update($topicModel, array $data) : void;

    public function deleteTopic($topicModel) : void;

    public function getTitleLengthCheck(array $data);

    public function getTextLengthCheck(array $data);
}