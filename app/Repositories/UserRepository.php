<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository implements UserRepositoryInterface {
    public function getUserById($id) {
        return User::findOrFail($id);
    }

    public function getUserByMail($mail) {
        return User::where('email', $mail)->first();
    }

    public function saveUser(array $data) : void {
        $user = new User($data);
        $user->save();
    }

    public function pwLengthCheck($password) {
        return strlen($password) > User::minLengthPassword && strlen($password) <= User::maxLengthPassword;
    }

    public function nameLengthCheck($name) {
        return strlen($name) > 0 && strlen($name) <= User::maxLengthName;
    }

    public function lastNameLengthCheck($lastName){
        return strlen($lastName) > 0 && strlen($lastName) <= User::maxLengthLastName;
    }
}
