<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class CustomMailer
{
    public static function send($role, $to, $subject, $data = [])
    {
        $setting = Setting::first();
        $text = $role === 'admin'
            ? $setting->email_text_admin
            : $setting->email_text_secretary;

        config([
            'mail.mailers.smtp.host' => $setting->smtp_host,
            'mail.mailers.smtp.port' => $setting->smtp_port,
            'mail.mailers.smtp.username' => $setting->smtp_username,
            'mail.mailers.smtp.password' => $setting->smtp_password,
            'mail.mailers.smtp.encryption' => $setting->smtp_encryption,
        ]);

        Mail::raw($text, function ($message) use ($to, $subject) {
            $message->to($to)
                    ->subject($subject);
        });
    }
}