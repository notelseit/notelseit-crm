<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        // Supponiamo che l'autenticazione passi l'utente
        $user = $request->user();
        return response()->json($user);
    }
}