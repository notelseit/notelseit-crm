<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_demo_users_are_listed()
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
        $response->assertSee('Demo User');
    }

    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin)->delete("/users/{$user->id}");
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}