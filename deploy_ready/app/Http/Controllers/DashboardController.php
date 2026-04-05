<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Beneficiary;
use App\Models\Material;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'suppliers_count' => Supplier::count(),
            'beneficiaries_count' => Beneficiary::count(),
            'materials_count' => Material::count(),
            'total_payments' => Payment::sum('amount'),
        ];

        return view('dashboard', compact('stats'));
    }
}
    