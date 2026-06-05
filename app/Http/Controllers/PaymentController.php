<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $sppgId = $user->sppg_id;

        $payments = Payment::with('beneficiary')
            ->when($sppgId, function ($query, $sppgId) {
                return $query->where('sppg_id', $sppgId);
            })
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $user = auth()->user();
        $sppgId = $user->sppg_id;

        $beneficiaries = Beneficiary::when($sppgId, function ($query, $sppgId) {
            return $query->where('sppg_id', $sppgId);
        })->get();

        $sppgs = collect();
        if ($user->isAdmin() && !$sppgId) {
            $sppgs = \App\Models\Sppg::orderBy('name')->get();
        }

        return view('payments.create', compact('beneficiaries', 'sppgs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'transaction_type' => 'required|string',
            'cash_type' => 'required|string',
            'amount_in' => 'nullable|numeric|min:0',
            'amount_out' => 'nullable|numeric|min:0',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'sppg_id' => 'nullable|exists:sppgs,id',
            'beneficiary_id' => 'nullable|exists:beneficiaries,id',
        ]);

        $user = auth()->user();
        $sppgId = $user->sppg_id;
        if ($user->isAdmin() && !$sppgId && $request->filled('sppg_id')) {
            $sppgId = $request->sppg_id;
        }
        
        // Check for saldo awal (any existing payment records for this SPPG)
        $paymentExists = Payment::where('sppg_id', $sppgId)->exists();
        if (!$paymentExists && ($request->amount_in == 0 && $request->amount_out == 0)) {
            return redirect()->back()->with('error', 'Silakan masukkan saldo awal (pemasukan) untuk memulai pencatatan transaksi.');
        }

        // Get current balance
        $lastPayment = Payment::where('sppg_id', $sppgId)->orderBy('id', 'desc')->first();
        $lastBalance = $lastPayment ? $lastPayment->balance : 0;
        
        $amountIn = $request->amount_in ?? 0;
        $amountOut = $request->amount_out ?? 0;
        $newBalance = $lastBalance + $amountIn - $amountOut;

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('payments', 'public');
        }

        $payment = Payment::create([
            'sppg_id' => $sppgId,
            'beneficiary_id' => $request->beneficiary_id ?: null,
            'date' => $request->date,
            'description' => $request->description,
            'transaction_type' => $request->transaction_type,
            'cash_type' => $request->cash_type,
            'amount_in' => $amountIn,
            'amount_out' => $amountOut,
            'balance' => $newBalance,
            'proof_file' => $filePath,
            'status' => 'paid'
        ]);

        // WhatsApp Notification
        try {
            $wa = app(\App\Services\WhatsAppService::class);
            $bot = app(\App\Services\BoToPersonalityService::class);
            $msg = "*[TRANSAKSI BARU]*\n" .
                   "Tgl: {$payment->date}\n" .
                   "Ket: {$payment->description}\n" .
                   "Masuk: Rp " . number_format($amountIn) . "\n" .
                   "Keluar: Rp " . number_format($amountOut) . "\n" .
                   "Saldo: Rp " . number_format($newBalance);
            $wa->sendMessage($wa->getMasterNumber(), $bot->medanize($msg));
        } catch (\Exception $e) {
            \Log::error("Failed to notify payment: " . $e->getMessage());
        }

        return redirect()->route('payments.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
