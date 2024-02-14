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
            'email' => 'unit_test@foroclismo.com',
            'password' => 'test12'
        ]);

        $user = User::where('email', 'unit_test@foroclismo.com');
        $user->delete();

        $response->assertRedirect('/login');
    }

    public function test_incorrect_store_user_duplicated_mail(): void
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'last_name' => 'test',
            'email' => 'admin@foroclismo.com',
            'password' => 12345678,
        ]);

        $response->assertRedirect('/register');
    }

    public function test_incorrect_store_user_missing_name(): void{
        $response = $this->post('/register', [
            'last_name' => 'test',
            'email' => 'new@foroclismo.com',
            'password' => 123,
        ]);

        $response->assertRedirect('/register');
    }

    public function test_incorrect_store_user_missing_last_name(): void{
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'new@foroclismo.com',
            'password' => 123,
        ]);

        $response->assertRedirect('/register');
    }

    public function test_incorrect_store_user_missing_password(): void{
        $response = $this->post('/register', [
            'name' => 'test',
            'last_name' => 'test',
            'email' => 'new@foroclismo.com',
        ]);

        $response->assertRedirect('/register');
    }
}
