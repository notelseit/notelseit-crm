<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_email()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/send-email', [
            'to' => 'someone@crm.local',
            'role' => 'admin',
            'subject' => 'Oggetto Test',
        ], ['X-Admin-Key' => 'fanculo2025']);

        $response->assertStatus(200)->assertJson(['status' => 'Email inviata']);
    }
}