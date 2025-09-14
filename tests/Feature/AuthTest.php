<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@crm.local',
            'password' => bcrypt('test123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@crm.local',
            'password' => 'test123',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }
}