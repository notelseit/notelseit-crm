<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        return Offer::with('client')->get();
    }

    public function show($id)
    {
        return Offer::with('client')->findOrFail($id);
    }

    public function store(Request $request)
    {
        return Offer::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $offer->update($request->all());
        return $offer;
    }

    public function destroy($id)
    {
        Offer::destroy($id);
        return response()->json(['success' => true]);
    }
}