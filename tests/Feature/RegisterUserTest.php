<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterUserTest extends TestCase
{

    public function test_correct_store_user(): void
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'last_name' => 'test',
            'email' => 'test@foroclismo.com',
            'password' => bcrypt(123)
        ]);

        // Borra el usuario que acabamos de crear, para evitar inconsistencias
        $user = User::where('email', 'test@foroclismo.com');
        $user->delete();

        $response->assertRedirect('/login');

    }

    public function test_incorrect_store_user_duplicated_mail(): void
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'last_name' => 'test',
            'email' => 'admin@foroclismo.com',
            'password' => bcrypt(123),
        ]);

        $response->assertStatus(500);

    }

    public function test_incorrect_store_user_missing_name(): void{
        $response = $this->post('/register', [
            'last_name' => 'test',
            'email' => 'new@foroclismo.com',
            'password' => bcrypt(123),
        ]);

        $response->assertStatus(500);
    }

    public function test_incorrect_store_user_missing_last_name(): void{
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'new@foroclismo.com',
            'password' => bcrypt(123),
        ]);

        $response->assertStatus(500);
    }

    public function test_incorrect_store_user_missing_password(): void{
        $response = $this->post('/register', [
            'name' => 'test',
            'last_name' => 'test',
            'email' => 'new@foroclismo.com',
        ]);

        $response->assertStatus(500);
    }
}
