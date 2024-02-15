<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;

class ShowProfileTest extends TestCase
{
    private User $user;
    protected function setUp() : void {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    protected function tearDown() : void {
        $this->user->delete();
        parent::tearDown();
    }

    public function test_show_existent_profile(): void {
        $user = $this->user;
        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/user/' . $user->id);

        $response->assertStatus(200);
    }

    public function test_show_profile_incorrect_id(): void{
        $user = $this->user;
        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/user/-1');
        $response->assertStatus(404);
    }

    public function test_show_incorrect_profile_no_auth() : void {
        $response = $this->get('/user/-1');
        $response->assertRedirect('login');
    }

    public function test_show_ban_button_profile(): void {
        $user = User::factory()->create(['is_admin' => 1]);
        $response = $this->actingAs($user)
                ->withSession(['banned' => false])
                ->get('/user/' . $user->id);
        $response->assertSee('Banea');
        $user->delete();
    }

    public function test_dont_show_ban_button_profile(): void {
        $response = $this->actingAs($this->user)
                ->withSession(['banned' => false])
                ->get('/user/' . $this->user->id);
        $response->assertDontSee('Banea');
    }
}
