<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;

trait UtilsTrait {
    // TODO : There's a better way for sure of implementing and avoid traits.

    public function checkValidAuthUser($userId) {
        return $userId == Auth::user()->id;
    }

    private function isSuperUser() {
        return Auth::user()->is_admin || Auth::user()->is_mod;
    }
}