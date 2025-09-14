<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        return Activity::with('client','contact','user')->get();
    }

    public function show($id)
    {
        return Activity::with('client','contact','user')->findOrFail($id);
    }

    public function store(Request $request)
    {
        return Activity::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->update($request->all());
        return $activity;
    }

    public function destroy($id)
    {
        Activity::destroy($id);
        return response()->json(['success' => true]);
    }
}