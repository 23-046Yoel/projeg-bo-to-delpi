<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialLog;

class PublicPriceController extends Controller
{
    public function index()
    {
        // Ambil data bahan baku yang memiliki harga (sebagai referensi transparansi)
        $prices = \App\Models\Material::with('sppg')
            ->where(function($q) {
                $q->where('price', '>', 0)
                  ->orWhere('last_price', '>', 0);
            })
            ->latest()
            ->paginate(20);

        return view('prices.index', compact('prices'));
    }
}

