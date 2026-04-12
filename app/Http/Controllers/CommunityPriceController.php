<?php

namespace App\Http\Controllers;

use App\Models\CommunityPrice;
use Illuminate\Http\Request;

class CommunityPriceController extends Controller
{
    /** Public: List all prices (social feed) */
    public function index()
    {
        $prices = CommunityPrice::latest()->paginate(12);
        return view('prices.community', compact('prices'));
    }

    /** Public: Submit a new price report */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name'      => 'required|string|max:100',
            'price'          => 'required|numeric|min:0',
            'unit'           => 'required|string|max:20',
            'reporter_name'  => 'nullable|string|max:100',
            'reporter_phone' => 'nullable|string|max:20',
            'location'       => 'required|string|max:100',
        ]);

        CommunityPrice::create([
            'item_name'      => $validated['item_name'],
            'price'          => $validated['price'],
            'unit'           => $validated['unit'],
            'reporter_name'  => $validated['reporter_name'] ?? 'Anonim',
            'reporter_phone' => $validated['reporter_phone'] ?? null,
            'location'       => $validated['location'],
            'is_verified'    => false,
        ]);

        return back()->with('success', 'Laporan harga berhasil dikirim! Terima kasih kontribusinya.');
    }

    /** Public: Like a price report */
    public function like(CommunityPrice $price)
    {
        $price->increment('likes');
        return response()->json(['likes' => $price->fresh()->likes]);
    }
}
