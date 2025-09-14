<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class LeadController extends Controller
{
    public function index()
    {
        return Lead::with('client','user')->get();
    }

    public function show($id)
    {
        return Lead::with('client','user')->findOrFail($id);
    }

    public function store(Request $request)
    {
        return Lead::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($request->all());
        return $lead;
    }

    public function destroy($id)
    {
        Lead::destroy($id);
        return response()->json(['success' => true]);
    }
}