<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;

trait UtilsTrait {
    public function checkValidAuthUser($userId) {
        return $userId == Auth::user()->id;
    }
}