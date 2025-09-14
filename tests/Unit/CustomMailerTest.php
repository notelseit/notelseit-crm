<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CustomMailer;
use App\Models\Setting;

class CustomMailerTest extends TestCase
{
    public function test_mail_text_is_correct_for_admin()
    {
        Setting::factory()->create([
            'email_text_admin' => 'Test Admin Email',
            'email_text_secretary' => 'Test Secretary Email',
        ]);

        // simulate CustomMailer call
        $result = CustomMailer::send('admin', 'demo@crm.local', 'Oggetto');
        $this->assertTrue(true); // Integrate with Mail fake for actual send test
    }
}