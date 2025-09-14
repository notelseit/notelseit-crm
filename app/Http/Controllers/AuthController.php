<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenziali non valide'], 401);
        }
        // Genera un token semplice (per demo)
        $token = base64_encode(str_random(40));
        $user->api_token = $token;
        $user->save();
        return response()->json(['token' => $token]);
    }
}