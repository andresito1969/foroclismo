<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowProfileTest extends TestCase
{
    // Testeo del perfil de un usuario existente
    public function test_show_existent_profile(): void
    {
        $response = $this->get('/user/1');

        $response->assertStatus(200);

    }

    // Testeo de qué pasaría si pasamos un string al parámetro /user/{id} 
    public function test_show_profile_with_string_id(): void {
        $response = $this->get('/user/asd');

        $response->assertStatus(404);
        // $response->dump();
    }

    public function test_show_profile_incorrect_id(): void{
        $response = $this->get('/user/-1');

        $response->assertStatus(404);
    }
}
