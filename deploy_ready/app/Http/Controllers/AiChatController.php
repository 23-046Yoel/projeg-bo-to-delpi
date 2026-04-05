<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Order;
use App\Models\Payment;
use App\Services\AiBotService;
use Illuminate\Http\Request;

class AiChatController extends Controller
{
    protected $aiService;

    public function __construct(AiBotService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function query(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:500',
            ]);

            $message = $request->message;

            // Fetch context from database
            $context = $this->getDatabaseContext();

            $response = $this->aiService->generateResponse($message, $context);

            return response()->json([
                'success' => true,
                'reply' => $response
            ]);
        } catch (\Exception $e) {
            \Log::error("AiChatController Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'reply' => 'Maaf, terjadi kesalahan teknis pada sistem chatbot.'
            ], 500);
        }
    }

    protected $contextLimit = 5;

    protected function getDatabaseContext()
    {
        $materials = Material::select('name', 'stock')->get();
        $recentOrders = Order::with('supplier')->latest()->take(5)->get();
        $recentPayments = Payment::latest()->take(5)->get();

        $context = "DATA STOK BARANG:\n";
        foreach ($materials as $m) {
            $context .= "- {$m->name}: {$m->stock}\n";
        }

        $context .= "\nPESANAN TERAKHIR:\n";
        foreach ($recentOrders as $o) {
            $supplierName = $o->supplier ? $o->supplier->name : 'Unknown';
            $context .= "- Pesanan ke {$supplierName} senilai Rp" . number_format($o->total_amount, 0, ',', '.') . " (Status: {$o->status})\n";
        }

        $context .= "\nPEMBAYARAN TERAKHIR:\n";
        foreach ($recentPayments as $p) {
            $context .= "- Pembayaran Rp" . number_format($p->amount, 0, ',', '.') . " (" . ($p->notes ?? 'Tanpa catatan') . ")\n";
        }

        return $context;
    }
}
