<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function show()
    {
        $setting = Setting::first();
        return response()->json($setting);
    }

    public function update(Request $request)
    {
        $setting = Setting::first() ?? new Setting();
        $setting->fill($request->all());
        $setting->save();
        return response()->json($setting);
    }
}