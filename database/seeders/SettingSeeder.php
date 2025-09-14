<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        Setting::create([
            'smtp_host' => 'smtp.test.local',
            'smtp_port' => '587',
            'smtp_username' => 'user',
            'smtp_password' => 'pass',
            'smtp_encryption' => 'tls',
            'smtp_external' => false,
            'email_text_admin' => 'Ciao Admin, questa è una mail di test.',
            'email_text_secretary' => 'Ciao Segretaria, questa è una mail di test.',
        ]);
    }
}