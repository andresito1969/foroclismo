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
     * We check the redirections only, so if it's a succeed we will go to the home (/) 
     * otherwise if it's not successful, we will stay in the same page (''), because errors redirect back.
     */
    public function test_correct_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@foroclismo.com',
            'password' => 'test12'
        ]);

        $response->assertRedirect('/');

    }

    public function test_incorrect_bannedUser_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'banned@foroclismo.com',
            'password' => 'test12'
        ]);

        $response->assertRedirect('/login');

    }

    public function test_incorrect_login_wrong_mail(): void
    {
        $response = $this->post('/login', [
            'email' => 'asd@lel.com',
            'password' => 'test2323231'
        ]);

        $response->assertRedirect('/login');
    }

    public function test_incorrect_login_wrong_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'juan_gomez@foroclismo.com',
            'password' => 'test2323231'
        ]);

        $response->assertRedirect('/login'); 
    }

    public function test_incorrect_login_empty_password(): void
    {
        $response = $this->post('/login', [
            'email' => 'juan_gomez@foroclismo.com',
        ]);

        $response->assertRedirect('/login'); 
    }

    public function test_incorrect_login_empty_mail(): void
    {
        $response = $this->post('/login', [
            'password' => 'test2323231'
        ]);

        $response->assertRedirect('/login'); 
    }
}
