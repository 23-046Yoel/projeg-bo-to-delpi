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
            $user = auth()->user();

            // PUBLIC SECURITY FILTER
            $financialKeywords = ['keuangan', 'saldo', 'dana', 'bayar', 'beli', 'uang', 'transaksi', 'biaya', 'pembayaran', 'budget'];
            $isFinancialQuery = false;
            foreach ($financialKeywords as $word) {
                if (stripos($message, $word) !== false) {
                    $isFinancialQuery = true;
                    break;
                }
            }

            if (!$user && $isFinancialQuery) {
                return response()->json([
                    'success' => true,
                    'reply' => 'Maaf, untuk informasi terkait keuangan, dana, atau transaksi, Anda harus melakukan login terlebih dahulu ke sistem BoTo Delphi demi keamanan data.'
                ]);
            }

            // Fetch context from database (Scoped by user)
            if ($user) {
                $context = $this->getDatabaseContext($user);
            } else {
                $context = $this->getPublicContext();
            }

            $response = $this->aiService->generateResponse($message, $context, $user ? $user->name : 'Publik');

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

    protected function getDatabaseContext($user)
    {
        $sppgId = $user->sppg_id;
        
        $materials = Material::when($sppgId, fn($q) => $q->where('sppg_id', $sppgId))->select('name', 'stock')->get();
        $recentOrders = Order::when($sppgId, fn($q) => $q->where('sppg_id', $sppgId))->with('supplier')->latest()->take(5)->get();
        $recentPayments = Payment::when($sppgId, fn($q) => $q->where('sppg_id', $sppgId))->latest()->take(5)->get();

        $context = "DATA UNIT SPPG: " . ($user->sppg->name ?? 'ALL') . "\n\n";
        $context .= "DATA STOK BARANG:\n";
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

    protected function getPublicContext()
    {
        $today = now()->toDateString();
        $menus = \App\Models\Menu::with(['sppg', 'dishes'])
            ->whereBetween('date', [$today, now()->addDays(7)->toDateString()])
            ->orderBy('date')
            ->get();

        $context = "INFO PUBLIK - PROGRAM MBG ALAD ELPHI\n";
        $context .= "Website: https://aladelphi.or.id\n";
        $context .= "Jadwal Menu Publik: https://aladelphi.or.id/jadwal-menu\n\n";

        if ($menus->count() > 0) {
            $context .= "JADWAL MENU MBG 7 HARI KE DEPAN:\n";
            foreach ($menus as $menu) {
                $tanggal = \Carbon\Carbon::parse($menu->date)->translatedFormat('l, d F Y');
                $dapur = $menu->sppg->name ?? 'Semua Dapur';
                $dishNames = $menu->dishes->pluck('name')->implode(', ');

                $karbo = $menu->karbo ?? '-';
                $protein = $menu->protein_hewani ?? '-';
                $sayur = $menu->sayur ?? '-';

                $context .= "📅 {$tanggal} | Dapur: {$dapur}\n";
                $context .= "   Karbohidrat: {$karbo} | Protein: {$protein} | Sayur: {$sayur}\n";
                if ($dishNames) $context .= "   Hidangan: {$dishNames}\n";
                $context .= "\n";
            }
        } else {
            $context .= "Belum ada jadwal menu yang dipublikasikan untuk minggu ini.\n";
        }

        $context .= "\nFORMULIR DAN LAYANAN:\n";
        $context .= "- Pengaduan: https://aladelphi.or.id/complaints/create\n";
        $context .= "- Daftar Supplier: https://aladelphi.or.id/pendaftaran-pemasok\n";
        $context .= "- Harga Komunitas: https://aladelphi.or.id/harga-komunitas\n";
        $context .= "- Profil Dapur: https://aladelphi.or.id/dapur\n";

        return $context;
    }
}
