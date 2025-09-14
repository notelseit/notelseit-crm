<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailLog;

class EmailLogSeeder extends Seeder
{
    public function run()
    {
        EmailLog::create([
            'to' => 'admin@crm.local',
            'role' => 'admin',
            'subject' => 'Benvenuto!',
            'sent_at' => now(),
        ]);
    }
}