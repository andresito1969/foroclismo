<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;

trait UtilsTrait {
    public function checkValidAuthUser($userId) {
        return $userId == Auth::user()->id;
    }

    private function hasTheUserRights() {
        return Auth::user()->is_admin || Auth::user()->is_mod;
    }
}