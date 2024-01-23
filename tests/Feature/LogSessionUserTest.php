<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Auth\RequestGuard;

class LogSessionUserTest extends TestCase
{
    /**
     * Test user login.
     */
    public function test_correct_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'juan_gomez@foroclismo.com',
            'password' => 'test'
        ]);

        $response->assertRedirect('/');

    }

    public function test_incorrect_login_wrong_mail(): void
    {
        $response = $this->post('/login', [
            'email' => 'asd@lel.com',
            'password' => 'test2323231'
        ]);

        $response->assertRedirect(''); // Porque ni redirecciona a la "/home o /", ni redirecciona al /login, simplemente se queda donde está
    }

    public function test_incorrect_login_wrong_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'juan_gomez@foroclismo.com',
            'password' => 'test2323231'
        ]);

        $response->assertRedirect(''); 
    }

    public function test_incorrect_login_empty_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'juan_gomez@foroclismo.com',
        ]);

        $response->assertRedirect(''); 
    }

    public function test_incorrect_login_empty_mail(): void
    {
        $response = $this->post('/login', [
            'password' => 'test2323231'
        ]);

        $response->assertRedirect(''); 
    }
}
