<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialLog;

class PublicPriceController extends Controller
{
    public function index()
    {
        // Ambil log masuk (pembelian bahan baku dari petani/supplier)
        $prices = MaterialLog::with(['material', 'sppg'])
            ->where('type', 'in')
            ->latest('date')
            ->paginate(15);

        return view('prices.index', compact('prices'));
    }
}

