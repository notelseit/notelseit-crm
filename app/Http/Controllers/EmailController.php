<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailLog;
use App\Services\CustomMailer;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        CustomMailer::send($request->role, $request->to, $request->subject);
        EmailLog::create([
            'to' => $request->to,
            'role' => $request->role,
            'subject' => $request->subject,
            'sent_at' => now()
        ]);
        return response()->json(['status' => 'Email inviata']);
    }

    public function history()
    {
        return EmailLog::orderBy('sent_at', 'desc')->get();
    }
}