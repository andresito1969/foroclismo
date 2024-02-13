<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;

class ShowProfileTest extends TestCase
{
    public function test_show_existent_profile(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/user/' . $user->id);

        $user->delete();
        $response->assertStatus(200);
    }

    public function test_show_profile_incorrect_id(): void{
        $response = $this->get('/user/-1');

        $response->assertRedirect('/login');
    }
}
