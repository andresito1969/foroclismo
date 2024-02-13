<?php

namespace App\Repositories;

interface CommentRepositoryInterface {
    public function createComment(array $data) : void;

    public function getSingleMessage($id);

    public function findByTopicId($id);

    public function update($commentModel, array $data) : void;

    public function delete($commentModel) : void;

    public function getTextLengthCheck($text);
}