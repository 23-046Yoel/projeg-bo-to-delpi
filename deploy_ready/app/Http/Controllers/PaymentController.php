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
        $payments = Payment::with('beneficiary')->latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $beneficiaries = Beneficiary::all();
        return view('payments.create', compact('beneficiaries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'required|in:pending,paid',
        ]);

        $payment = Payment::create(array_merge($request->all(), [
            'sppg_id' => auth()->user()->sppg_id
        ]));

        // Send WhatsApp Notification to Master Number
        try {
            $wa = app(\App\Services\WhatsAppService::class);
            $bot = app(\App\Services\BoToPersonalityService::class);
            $msg = "Lapor Bos! Ada pencatatan PEMBAYARAN baru senilai Rp " . number_format($payment->amount) . " via Website.";
            $wa->sendMessage($wa->getMasterNumber(), $bot->medanize($msg));
        } catch (\Exception $e) {
            \Log::error("Failed to notify payment: " . $e->getMessage());
        }

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
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
