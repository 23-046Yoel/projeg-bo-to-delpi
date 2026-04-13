<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Beneficiary;
use App\Models\Material;
use App\Models\Payment;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'suppliers_count' => Supplier::count(),
            'beneficiaries_count' => \App\Models\BeneficiaryGroup::sum('total_beneficiaries'),
            'materials_count' => Material::count(),
            'total_payments' => Payment::sum('amount'),
            'posts_count' => \App\Models\News::count() + \App\Models\Aspiration::count(),
        ];

        $latest_suppliers = Supplier::with('sppg')->latest()->take(5)->get();
        $latest_complaints = Complaint::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'latest_suppliers', 'latest_complaints'));
    }
}
    