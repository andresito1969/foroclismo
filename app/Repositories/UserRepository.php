<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository implements UserRepositoryInterface {
    public function getUserById($id) {
        return User::findOrFail($id);
    }

    public function saveUser(array $data) : void {
        $user = new User($data);
        $user->save();
    }

    public function pwLengthCheck($password) {
        return User::passwordLengthCheck($password);
    }

    public function nameLengthCheck($name) {
        return User::nameLengthCheck($name);
    }

    public function lastNameLengthCheck($lastName){
        return User::lastNameLengthCheck($lastName);
    }
}
