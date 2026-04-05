<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $transactions = \App\Models\Payment::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'approved')
            ->orderBy('date', 'asc')
            ->get();

        $balance = \App\Models\Payment::where('date', '<', $startDate)
            ->where('status', 'approved')
            ->sum(\Illuminate\Support\Facades\DB::raw('amount_in - amount_out'));

        return view('financial.index', compact('transactions', 'balance', 'startDate', 'endDate'));
    }
}
