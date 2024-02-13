<?php

namespace App\Repositories;

interface UserRepositoryInterface{
    public function getUserById($id);

    public function getUserByMail($mail);

    public function saveUser(array $data) : void;

    public function pwLengthCheck($password);

    public function nameLengthCheck($name);

    public function lastNameLengthCheck($lastName);
    
}