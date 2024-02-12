<?php

namespace App\Repositories;

interface CommentRepositoryInterface {
    public function findByTopicId($id);
}