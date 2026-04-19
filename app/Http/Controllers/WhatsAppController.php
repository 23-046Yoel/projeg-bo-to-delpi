<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Beneficiary;
use App\Models\Payment;
use App\Models\Material;
use App\Models\MaterialLog;
use App\Models\MbgDistribution;
use App\Services\AiBotService;
use App\Services\BoToPersonalityService;
use App\Services\WhatsAppService;
use App\Services\GoogleSheetService;
use App\Services\AttendanceService;

class WhatsAppController extends Controller
{
    protected $bot;
    protected $wa;
    protected $sheets;
    protected $attendance;
    protected $ai;

    public function __construct(BoToPersonalityService $bot, WhatsAppService $wa, GoogleSheetService $sheets, AttendanceService $attendance, AiBotService $ai)
    {
        $this->bot = $bot;
        $this->wa = $wa;
        $this->sheets = $sheets;
        $this->attendance = $attendance;
        $this->ai = $ai;
    }

    public function webhook(Request $request)
    {
        \Log::info("WA Webhook Hit:", $request->all());
        
        $phone = $request->input('phone') ?? $request->input('from'); 
        $message = $request->input('message');

        // Allow empty message for location messages
        if (!$phone || (!$message && $request->input('messageType') != 'location')) {
            return response('No data', 200);
        }

        // 1. Crucial: Skip if message is from the bot itself
        $masterNumber = config('services.kirimi.master_number', '6285353325352');
        if ($request->input('isFromMe') || $phone == $masterNumber) {
            return response('Skip outgoing', 200);
        }

        // Normalize phone for user lookup and state tracking
        $cleanPhone = $phone;
        if (strpos($phone, '@') !== false) {
            $cleanPhone = explode('@', $phone)[0];
        }

        // 2. Find user
        // Priority: Search by clean phone (standard) 
        // Improvement: Also search by participant if numeric
        $participant = $request->input('participant');
        $cleanParticipant = $participant;
        if ($participant && strpos($participant, '@') !== false) {
            $cleanParticipant = explode('@', $participant)[0];
        }

        $user = User::where('phone', 'like', "%$cleanPhone%")->first();
        if (!$user && $cleanParticipant) {
             $user = User::where('phone', 'like', "%$cleanParticipant%")->first();
        }

        if (!$user && $request->has('name')) {
            $name = $request->input('name');
            $user = User::where('name', 'like', explode(' ', $name)[0] . '%')->first();
        }

        // --- NEW: AUTO-LOGIN / REGISTER FROM DB ---
        // If not found in users table, try to find in Sppg contacts, Suppliers, or Beneficiaries
        if (!$user) {
            $user = $this->tryAutoRegisterUser($cleanPhone);
        }

        // 3. Determine reply recipient & State ID
        // Default to the incoming phone/ID
        $replyTo = $phone;
        $stateId = $cleanPhone;

        // CRITICAL FIX: If we found a user with a verified phone,
        // ALWAYS reply to their verified phone to avoid Kirimi rejection of @lid IDs.
        // ALSO use that verified phone as the unique State ID for consistency.
        if ($user && !empty($user->phone)) {
            $replyTo = $user->phone;
            $stateId = $user->phone;
        }

        $state = cache()->get("bot_state_$stateId", 'idle');
        
        if ($message && (strtolower($message) == 'stop' || strtolower($message) == 'batal')) {
            cache()->forget("bot_state_$stateId");
            return $this->wa->sendMessage($replyTo, $this->bot->medanize("Okelah, kubatalkan semua ya lae. Balik lagi kita ke awal."));
        }

        // 1. Check for logged-in commands (ABSEN, TERIMA BAHAN, etc)
        $internalResponse = $this->handleInternalActions($stateId, $message, $user);
        if ($internalResponse) return $internalResponse;

        // Final check: If replyTo is still a weird ID (@lid etc) and we have NO real phone, 
        // we might need to warn the bot/user, but for now we let it try or skip.
        if (strpos($replyTo, '@') !== false && !$user) {
             // Optional: Log or handle unmapped linked devices
        }

        // --- SECURITY FILTER ---
        // If user is not registered and PUBLIC ACCESS is OFF, ignore the message.
        if (!$user && !env('WHATSAPP_PUBLIC_ACCESS', false)) {
            \Log::info("WA Bot: Ignoring message from unknown number: $phone");
            return response('Access Restricted', 200);
        }

        switch ($state) {
            case 'idle':
                return $this->handleIdle($replyTo, $message);
            case 'register_supplier':
                return $this->handleSupplierRegistration($replyTo, $message);
            case 'register_beneficiary':
                return $this->handleBeneficiaryRegistration($replyTo, $message);
            case 'internal_payment_ajukan':
                return $this->handlePaymentSubmission($replyTo, $message);
            case 'internal_material_in':
                return $this->handleMaterialReceipt($replyTo, $message, 'in');
            case 'internal_material_out':
                return $this->handleMaterialReceipt($replyTo, $message, 'out');
            case 'internal_mbg_dist':
                return $this->handleMbgDistribution($replyTo, $message);
            case 'update_menu':
                return $this->handleMenuUpdate($replyTo, $message);
            case 'consultation_gizi':
                return $this->handleConsultation($replyTo, $message);
            case 'verify_material_color':
            case 'verify_material_aroma':
            case 'verify_material_temp':
            case 'verify_material_storage':
                return $this->handleMaterialVerification($replyTo, $message, str_replace('verify_material_', '', $state));
            case strpos($state, 'confirm_') === 0:
                return $this->handleConfirmation($replyTo, $message, str_replace('confirm_', '', $state));
            case 'waiting_attendance_location':
                 return $this->handleAttendanceLocation($stateId, $request);
            default:
                return $this->wa->sendMessage($replyTo, $this->bot->medanize("Gak ngerti aku kau cakap apa lae. Ketik 'MENU' lah biar tau kau apa mau kubantu."));
        }
    }

    private function handleInternalActions($phone, $message, $user = null)
    {
        if (!$user) {
            $user = User::with('sppg')->where('phone', $phone)->first();
        }
        
        if (!$user) return null;

        $msg = strtoupper($message);

        // Check for specific commands, if none match, return null to let the state machine handle it
        if (strpos($msg, 'KIRIM MBG') !== false) {
            cache()->put("bot_state_$phone", 'internal_mbg_dist', 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Berapa porsi MBG yang kau kirim tadi lae? Dan ke mana tujuannya? (Format: Jumlah, Tujuan)"));
        }

        if (strpos($msg, 'TERIMA BAHAN') !== false) {
            cache()->put("bot_state_$phone", 'internal_material_in', 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Bahan apa yang masuk ke gudang? Sebutkan jumlah barangnya ya lae, bukan harga duitnya!\n\n(Format: Bahan, Jumlah. Misal: Ayam, 10)"));
        }

        if (strpos($msg, 'PAKAI BAHAN') !== false) {
            cache()->put("bot_state_$phone", 'internal_material_out', 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Bahan apa yang mau kau pakai? Sebutkan jumlah barangnya ya!\n\n(Format: Bahan, Jumlah. Misal: Beras, 25)"));
        }

        if (strpos($msg, 'CEK STOK') !== false) {
            $sppgId = $user->sppg_id;
            $materials = \App\Models\Material::where(function($q) use ($sppgId) {
                $q->whereNull('sppg_id')->orWhere('sppg_id', $sppgId);
            })->get();
            
            $report = "*LAPORAN STOK GUDANG (" . ($user->sppg->name ?? 'Global') . ")*\n\n";
            $totalValue = 0;

            foreach ($materials as $m) {
                // Calculate stock based on logs for this SPPG
                $query = \App\Models\MaterialLog::where('material_id', $m->id);
                if ($sppgId) $query->where('sppg_id', $sppgId);
                
                $in = (clone $query)->where('type', 'in')->sum('quantity');
                $out = (clone $query)->where('type', 'out')->sum('quantity');
                $currentStock = $in - $out;
                $value = $currentStock * $m->price;
                $totalValue += $value;

                if ($currentStock != 0) {
                    $report .= "- *{$m->name}*: " . number_format($currentStock) . " " . ($m->unit ?? 'Unit') . "\n";
                    $report .= "  Nilai: Rp " . number_format($value) . "\n";
                }
            }
            $report .= "\n*Total Nilai Aset Gudang: Rp " . number_format($totalValue) . "*";
            return $this->wa->sendMessage($phone, $this->bot->medanize($report));
        }

        if (strpos($msg, 'UPDATE MENU') !== false) {
            cache()->put("bot_state_$phone", 'update_menu', 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Apa menu baru kita hari ini bah? Ketik aja pilihannya!"));
        }

        if (strpos($msg, 'AJUKAN DANA') !== false) {
            cache()->put("bot_state_$phone", 'internal_payment_ajukan', 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Mau ajukan dana berapa kau bah? Sebutkan nominal dan alasannya!"));
        }

        if (strpos($msg, 'MAKER') === 0) {
            $paymentId = trim(str_replace('MAKER', '', $msg));
            $payment = Payment::find($paymentId);
            if ($payment) {
                cache()->put("bot_state_$phone", 'confirm_maker', 600);
                cache()->put("conf_data_$phone", ['id' => $paymentId], 600);
                return $this->wa->sendMessage($phone, $this->bot->medanize("Kau mau jadi MAKER buat pengajuan Rp " . number_format($payment->amount) . " ini? (Y/N)"));
            }
        }

        if (strpos($msg, 'APPROVE') === 0) {
            $paymentId = trim(str_replace('APPROVE', '', $msg));
            $payment = Payment::find($paymentId);
            if ($payment) {
                cache()->put("bot_state_$phone", 'confirm_approve', 600);
                cache()->put("conf_data_$phone", ['id' => $paymentId], 600);
                return $this->wa->sendMessage($phone, $this->bot->medanize("Bos mau APPROVE pengajuan Rp " . number_format($payment->amount) . " ini? (Y/N)"));
            }
        }

        if (strpos($msg, 'ABSEN') !== false) {
            cache()->put("bot_state_$phone", 'waiting_attendance_location', 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Baik. Silakan kirimkan lokasi GPS Anda melalui fitur Share Location di WhatsApp untuk mencatat kehadiran."));
        }

        // --- NEW: DRIVER MONITORING LOGIC ---
        if ($msg == 'BERANGKAT' || $msg == 'TIBA') {
            // Find active route for this phone number for today
            $route = \App\Models\DistributionRoute::where(function($query) use ($phone) {
                $query->where('driver_phone', $phone)
                      ->orWhereHas('driver', function($q) use ($phone) {
                          $q->where('phone', $phone);
                      });
            })
            ->whereDate('date', now())
            ->whereIn('status', ['planned', 'active'])
            ->first();

            if (!$route) {
                return $this->wa->sendMessage($phone, $this->bot->medanize("Gak ada jadwal jalanmu hari ini lae. Hubungi aslapmu ya!"));
            }

            if ($msg == 'BERANGKAT') {
                $route->update([
                    'status' => 'active',
                    'departure_time' => now()
                ]);
                return $this->wa->sendMessage($phone, $this->bot->medanize("Mantap! Hati-hati di jalan ya lae. Semangat!"));
            }

            if ($msg == 'TIBA') {
                // Find next pending stop
                $stop = $route->stops()->where('status', 'pending')->orderBy('order')->first();
                if ($stop) {
                    $stop->update([
                        'status' => 'completed',
                        'arrival_time' => now()
                    ]);
                    
                    // If no more stops, complete the route
                    if ($route->stops()->where('status', 'pending')->count() == 0) {
                        $route->update(['status' => 'completed', 'arrival_time' => now()]);
                    }
                    
                    return $this->wa->sendMessage($phone, $this->bot->medanize("Siap! Sudah kucatat kau sampai di " . $stop->beneficiaryGroup->name . ". Lanjut ke titik berikutnya!"));
                }
                return $this->wa->sendMessage($phone, $this->bot->medanize("Sudah sampai semua titikmu lae! Makasih ya!"));
            }
        }

        // Sapaan dan pertanyaan umum lainnya tidak lagi ditangani di sini,
        // melainkan akan jatuh ke AI Agent di bagian bawah alur (handleIdle).
        return null; // biarkan alur berlanjut ke AI Agent

        return null; // No internal command matched, continue to idle/state logic

    }

    private function handleIdle($phone, $message)
    {
        // Deteksi intent daftar supplier via keyword
        if (preg_match('/daftar.*(pemasok|supplier|jualan|jual)/i', $message)) {
            cache()->put("bot_state_$phone", 'register_supplier', 600);
            return $this->wa->sendMessage($phone, "Baik! Untuk mendaftar sebagai pemasok program MBG, saya perlu beberapa data.\n\nSiapa nama lengkap Anda?");
        }

        // Deteksi intent daftar penerima manfaat via keyword
        if (preg_match('/daftar.*(anak|penerima|manfaat|siswa|murid)/i', $message)) {
            cache()->put("bot_state_$phone", 'register_beneficiary', 600);
            return $this->wa->sendMessage($phone, "Baik! Untuk mendaftarkan penerima manfaat MBG, siapa nama anak yang ingin didaftarkan?");
        }

        // Semua pertanyaan lain (termasuk menu, halo, sapaan) → AI Agent
        return $this->handleAiAgent($phone, $message);
    }

    /**
     * AI Agent: jawab semua pertanyaan menggunakan Groq/Gemini
     * dengan konteks menu harian dan info MBG dari database.
     */
    private function handleAiAgent($phone, $message)
    {
        try {
            $context = $this->getPublicWaContext();
            $aiReply = $this->ai->generateResponse($message, $context, 'Pengguna WhatsApp');
            return $this->wa->sendMessage($phone, $aiReply);
        } catch (\Exception $e) {
            \Log::error("WA AI Agent Error: " . $e->getMessage());
            return $this->wa->sendMessage($phone, "Maaf, saya sedang mengalami gangguan teknis. Silakan hubungi kami di aladelphi.or.id atau coba lagi beberapa saat.");
        }
    }

    /**
     * Ambil konteks publik untuk AI WA: menu hari ini + 7 hari ke depan + info formulir
     */
    private function getPublicWaContext(): string
    {
        $today = now()->toDateString();
        $menus = \App\Models\Menu::with(['sppg', 'dishes'])
            ->whereBetween('date', [$today, now()->addDays(7)->toDateString()])
            ->orderBy('date')
            ->get();

        $context = "=== SISTEM BoTo Delphi — Program MBG Alad Elphi ===\n";
        $context .= "Website resmi: https://aladelphi.or.id\n";
        $context .= "Tanggal hari ini: " . now()->translatedFormat('l, d F Y') . "\n\n";

        if ($menus->count() > 0) {
            $context .= "JADWAL MENU MBG (Hari Ini & 7 Hari ke Depan):\n";
            foreach ($menus as $menu) {
                $tgl = \Carbon\Carbon::parse($menu->date)->translatedFormat('l, d F Y');
                $isToday = $menu->date === $today ? ' [HARI INI]' : '';
                $dapur = $menu->sppg->name ?? 'Semua Dapur';
                $items = array_filter([
                    $menu->karbo       ? "Karbo: {$menu->karbo}" : null,
                    $menu->protein_hewani ? "Protein Hewani: {$menu->protein_hewani}" : null,
                    $menu->protein_nabati ? "Protein Nabati: {$menu->protein_nabati}" : null,
                    $menu->sayur       ? "Sayur: {$menu->sayur}" : null,
                    $menu->buah        ? "Buah: {$menu->buah}" : null,
                    $menu->pelengkap   ? "Pelengkap: {$menu->pelengkap}" : null,
                ]);
                $dishNames = $menu->dishes->pluck('name')->implode(', ');

                $context .= "📅 {$tgl}{$isToday} | Dapur: {$dapur}\n";
                $context .= "   " . implode(' | ', $items) . "\n";
                if ($dishNames) $context .= "   Hidangan: {$dishNames}\n";
                $context .= "\n";
            }
        } else {
            $context .= "Jadwal menu untuk minggu ini belum dipublikasikan.\n\n";
        }

        $context .= "FORMULIR DAN LAYANAN (arahkan user ke link ini):\n";
        $context .= "- Lihat Jadwal Menu Lengkap: https://aladelphi.or.id/jadwal-menu\n";
        $context .= "- Sampaikan Pengaduan: https://aladelphi.or.id/complaints/create\n";
        $context .= "- Daftar Jadi Pemasok/Supplier: https://aladelphi.or.id/pendaftaran-pemasok\n";
        $context .= "- Harga Komunitas: https://aladelphi.or.id/harga-komunitas\n";
        $context .= "- Profil Dapur SPPG: https://aladelphi.or.id/dapur\n";
        $context .= "\nATURAN PENTING:\n";
        $context .= "- Jika user ingin daftar pemasok via WA, minta mereka ketik: 'daftar pemasok'\n";
        $context .= "- Jika user ingin daftar anak penerima MBG via WA, minta mereka ketik: 'daftar anak'\n";
        $context .= "- Untuk pengaduan, SELALU arahkan ke link complaints/create di atas\n";

        return $context;
    }

    private function handleConsultation($phone, $message)
    {
        // Gunakan AI untuk konsultasi gizi
        cache()->forget("bot_state_$phone");
        return $this->handleAiAgent($phone, $message);
    }

    private function handleSupplierRegistration($phone, $message)
    {
        $data = cache()->get("reg_data_$phone", []);
        if (!isset($data['name'])) {
            $data['name'] = $message;
            cache()->put("reg_data_$phone", $data, 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Tinggal di desa mana kau?"));
        }
        if (!isset($data['village'])) {
            $data['village'] = $message;
            cache()->put("reg_data_$phone", $data, 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Barang apa yang kau tawarkan? Dan berapa harganya? (Format: Barang, Harga)"));
        }
        
        $parts = explode(',', $message);
        $data['items'] = trim($parts[0]);
        $data['price'] = count($parts) > 1 ? (float) preg_replace('/[^0-9.]/', '', $parts[1]) : 0;
        $data['phone'] = $phone;

        cache()->put("conf_data_$phone", $data, 600);
        cache()->put("bot_state_$phone", 'confirm_supplier', 600);

        $summary = "Nama: {$data['name']}\nDesa: {$data['village']}\nBarang: {$data['items']}\nHarga: " . number_format($data['price']);
        return $this->wa->sendMessage($phone, $this->bot->medanize("Cek dulu lae, benernya datamu ini?\n\n$summary\n\nKetik 'Y' kalo bener, 'N' kalo salah!"));
    }

    private function handleBeneficiaryRegistration($phone, $message)
    {
        $data = cache()->get("reg_ben_$phone", []);
        $steps = [
            'name' => "Siapa nama anak yang mau didaftarkan bah?",
            'parent_name' => "Siapa nama orang tua atau walinya?",
            'marga' => "Apa marga atau sukunya lae?",
            'origin' => "Dari desa mana asalnya?",
            'address' => "Di mana alamat tempat tinggal sekarang?",
            'school' => "Apa nama sekolah atau posyandunya?",
            'dob' => "Kapan tanggal lahirnya? (Format: TTTT-BB-HH, misal 2015-05-20)",
            'weight' => "Berat badannya berapa kg? (Sebutkan angka aja)",
            'height' => "Tinggi badannya berapa cm? (Sebutkan angka aja)",
            'allergies' => "Ada alergi makanan gak? (Ketik 'TIDAK' kalo gak ada)",
            'notes' => "Pesan dan kesanmu untuk pelayanan SPPG selama ini?"
        ];

        $keys = array_keys($steps);
        
        foreach ($steps as $field => $question) {
            if (!isset($data[$field])) {
                if (empty($data) || !isset($data['name'])) {
                    $data['name'] = $message;
                    cache()->put("reg_ben_$phone", $data, 600);
                    return $this->wa->sendMessage($phone, $this->bot->medanize($steps['parent_name']));
                }
                
                $data[$field] = $message;
                $currentIndex = array_search($field, $keys);
                $nextField = $keys[$currentIndex + 1] ?? null;

                if ($nextField) {
                    cache()->put("reg_ben_$phone", $data, 600);
                    return $this->wa->sendMessage($phone, $this->bot->medanize($steps[$nextField]));
                } else {
                    cache()->put("conf_data_$phone", $data, 600);
                    cache()->put("bot_state_$phone", 'confirm_beneficiary', 600);
                    
                    $summary = "Nama: {$data['name']}\nOrtu: {$data['parent_name']}\nMarga: {$data['marga']}\nAlamat: {$data['address']}";
                    return $this->wa->sendMessage($phone, $this->bot->medanize("Sudah pas datamu ini lae?\n\n$summary\n\nKetik 'Y' kalo pas!"));
                }
            }
        }
    }

    private function handlePaymentSubmission($phone, $message)
    {
        $user = User::where('phone', $phone)->first();
        preg_match('/(\d+)[\s,]+(.*)/', $message, $matches);
        if (!$matches) return $this->wa->sendMessage($phone, $this->bot->medanize("Gak gitu caranya lae! 'Nominal Alasan'. Contoh: 500000 Beli sapu."));

        $data = [
            'amount' => $matches[1],
            'notes' => "[Bot] " . $matches[2],
            'sppg_id' => $user->sppg_id ?? null
        ];

        cache()->put("conf_data_$phone", $data, 600);
        cache()->put("bot_state_$phone", 'confirm_payment', 600);

        return $this->wa->sendMessage($phone, $this->bot->medanize("Kau mau ajukan dana Rp " . number_format($data['amount']) . " buat '{$data['notes']}'? (Y/N)"));
    }

    private function handleMaterialReceipt($phone, $message, $type = 'in')
    {
        $user = User::where('phone', $phone)->first();
        $parts = explode(',', $message);
        
        if (count($parts) < 2) {
            return $this->wa->sendMessage($phone, $this->bot->medanize("Formatnya salah lae! Sebutkan nama barang dan jumlahnya ya. Contoh: 'Ayam, 10'"));
        }

        $materialName = trim($parts[0]);
        $qtyString = trim($parts[1]);
        $qty = (float) preg_replace('/[^0-9.]/', '', $qtyString);

        if ($qty <= 0) return $this->wa->sendMessage($phone, $this->bot->medanize("Jumlahnya mana bah? Kasih angka yang bener lah!"));

        // Find the material
        $sppgId = $user->sppg_id ?? null;
        $mat = Material::where('name', 'like', "%$materialName%")
            ->where(function($q) use ($sppgId) {
                $q->whereNull('sppg_id')->orWhere('sppg_id', $sppgId);
            })->first();

        if (!$mat) {
            return $this->wa->sendMessage($phone, $this->bot->medanize("Bahan '$materialName' gak ketemu di daftar kita bah! Coba cek ejaannya."));
        }

        $data = [
            'material_id' => $mat->id,
            'material_name' => $mat->name,
            'material_unit' => $mat->unit ?? 'Unit',
            'type' => $type,
            'quantity' => $qty,
            'sppg_id' => $sppgId
        ];

        cache()->put("conf_data_$phone", $data, 600);
        
        if ($type == 'in') {
            cache()->put("bot_state_$phone", "verify_material_color", 600);
            return $this->wa->sendMessage($phone, $this->bot->medanize("Oke, kucatat masuk {$data['quantity']} {$data['material_unit']} {$data['material_name']}.\n\nGimana warnanya lae? (Sesuai / Tidak Sesuai)"));
        }

        cache()->put("bot_state_$phone", "confirm_material_$type", 600);
        $action = $type == 'in' ? 'terima' : 'pakai';
        return $this->wa->sendMessage($phone, $this->bot->medanize("Betul kau mau $action {$data['material_name']} sebanyak {$data['quantity']} {$data['material_unit']}? (Y/N)"));
    }

    private function handleMaterialVerification($phone, $message, $stage)
    {
        $data = cache()->get("conf_data_$phone", []);
        
        switch ($stage) {
            case 'color':
                $data['color'] = $message;
                cache()->put("conf_data_$phone", $data, 600);
                cache()->put("bot_state_$phone", "verify_material_aroma", 600);
                return $this->wa->sendMessage($phone, $this->bot->medanize("Aroma bahannya cemana pula? (Sesuai / Tidak Sesuai)"));
            case 'aroma':
                $data['aroma'] = $message;
                cache()->put("conf_data_$phone", $data, 600);
                cache()->put("bot_state_$phone", "verify_material_temp", 600);
                return $this->wa->sendMessage($phone, $this->bot->medanize("Suhu bahannya pas? (Sesuai / Tidak Sesuai)"));
            case 'temp':
                $data['temperature'] = $message;
                cache()->put("conf_data_$phone", $data, 600);
                cache()->put("bot_state_$phone", "verify_material_storage", 600);
                return $this->wa->sendMessage($phone, $this->bot->medanize("Di mana kau simpan barangi tu bah? (Gudang Kering / Gudang Basah)"));
            case 'storage':
                $data['storage_location'] = $message;
                cache()->put("conf_data_$phone", $data, 600);
                cache()->put("bot_state_$phone", "confirm_material_in", 600);
                
                $summary = "Bahan: {$data['material_name']}\nJumlah: {$data['quantity']} {$data['material_unit']}\nWarna: {$data['color']}\nAroma: {$data['aroma']}\nSuhu: {$data['temperature']}\nTempat: {$data['storage_location']}";
                return $this->wa->sendMessage($phone, $this->bot->medanize("Sudah pas pendataanmu ini lae? Ingat ya, ini jumlah barang, bukan rupiah!\n\n$summary\n\nKetik 'Y' kalo pas!"));
        }
    }

    private function handleMbgDistribution($phone, $message)
    {
        $user = User::where('phone', $phone)->first();
        $parts = explode(',', $message);
        $qty = (float) preg_replace('/[^0-9.]/', '', trim($parts[0]));
        if ($qty <= 0) return $this->wa->sendMessage($phone, $this->bot->medanize("Berapa porsinya? Kasih angka lah!"));

        $data = [
            'quantity' => $qty,
            'tujuan' => trim($parts[1]),
            'sppg_id' => $user->sppg_id ?? null,
            'beneficiary_id' => 1
        ];

        cache()->put("conf_data_$phone", $data, 600);
        cache()->put("bot_state_$phone", 'confirm_mbg_dist', 600);

        return $this->wa->sendMessage($phone, $this->bot->medanize("Kau kirim {$data['quantity']} porsi ke {$data['tujuan']} tadi? Betul? (Y/N)"));
    }

    private function handleMenuUpdate($phone, $message)
    {
        $dishes = array_map('trim', explode(',', $message));
        $ingredientsList = [];
        $totalText = "Bahan yang otomatis terhitung bah:\n";

        foreach ($dishes as $dishName) {
            $dish = \App\Models\Dish::where('name', 'like', "%$dishName%")->first();
            if ($dish) {
                foreach ($dish->recipes as $recipe) {
                    $ingredientsList[] = [
                        'material' => $recipe->material->name,
                        'qty' => $recipe->quantity,
                        'unit' => $recipe->unit
                    ];
                }
            }
        }

        cache()->put("conf_data_$phone", [
            'menu' => $message,
            'ingredients' => $ingredientsList
        ], 600);
        
        cache()->put("bot_state_$phone", 'confirm_menu', 600);
        
        if (!empty($ingredientsList)) {
            foreach ($ingredientsList as $ing) {
                $totalText .= "- {$ing['material']} pas {$ing['qty']} {$ing['unit']} (per porsi)\n";
            }
            return $this->wa->sendMessage($phone, $this->bot->medanize("Ini menu barunya: '$message'?\n\n$totalText\nOke? (Y/N)"));
        }

        return $this->wa->sendMessage($phone, $this->bot->medanize("Ini menu barunya: '$message'? Tapi gak ada resepnya di daftar kita bah! Oke tetap? (Y/N)"));
    }

    private function handleConfirmation($phone, $message, $type)
    {
        if (strtolower($message) != 'y') {
            cache()->forget("bot_state_$phone");
            cache()->forget("conf_data_$phone");
            return $this->wa->sendMessage($phone, $this->bot->medanize("Okelah, gagal maning! Batalkan aja semua!"));
        }

        $data = cache()->get("conf_data_$phone");
        $user = User::where('phone', $phone)->first();
        $replyMsg = "[SISTEM] Data telah berhasil diproses dan dicatat.";

        switch ($type) {
            case 'supplier':
                $supplier = Supplier::create($data);
                $this->sheets->syncSupplier($supplier);
                $replyMsg = "[SISTEM] Pendaftaran pemasok atas nama {$data['name']} telah berhasil dicatat.";
                break;
            case 'beneficiary':
                $ben = Beneficiary::create($data);
                $this->sheets->syncBeneficiary($ben);
                $replyMsg = "[SISTEM] Pendaftaran penerima manfaat atas nama {$data['name']} telah berhasil dicatat.";
                break;
            case 'payment':
                $payment = Payment::create(array_merge($data, [
                    'date' => now(), 
                    'status' => 'pending', 
                    'transaction_type' => 'belanja bahan baku' // default
                ]));
                $finance = User::where('role', 'finance')->where('sppg_id', $data['sppg_id'])->first();
                if ($finance) $this->wa->sendMessage($finance->phone, $this->bot->medanize("Lapor! Ada pengajuan dana baru Rp " . number_format($data['amount']) . ". Ketik 'MAKER {$payment->id}'!"));
                
                // Always notify master number
                $this->wa->sendMessage($this->wa->getMasterNumber(), $this->bot->medanize("Lapor Bos! Ada pengajuan dana baru Rp " . number_format($data['amount']) . " untuk {$data['notes']} oleh " . ($user->name ?? 'User')));
                $replyMsg = "[SISTEM] Pengajuan dana sebesar Rp " . number_format($data['amount']) . " telah berhasil dicatat.";
                break;
            case 'material_in':
            case 'material_out':
                $log = MaterialLog::create(array_merge($data, [
                    'date' => now(),
                    'color' => $data['color'] ?? null,
                    'aroma' => $data['aroma'] ?? null,
                    'temperature' => $data['temperature'] ?? null,
                    'storage_location' => $data['storage_location'] ?? null,
                ]));
                
                // CRITICAL: Synchronize with Web Dashboard stock column
                $material = Material::find($data['material_id']);
                if ($material) {
                    if ($data['type'] == 'in') {
                        $material->increment('stock', $data['quantity']);
                    } else {
                        $material->decrement('stock', $data['quantity']);
                    }
                }

                $this->sheets->syncMaterialLog($log);
                $head = User::where('role', 'head')->where('sppg_id', $data['sppg_id'])->first();
                if ($head) $this->wa->sendMessage($head->phone, $this->bot->medanize("Lapor pak! " . ($data['type'] == 'in' ? 'Terima' : 'Pakai') . " {$data['material_name']} sebanyak {$data['quantity']} {$data['material_unit']}. Kualitas: {$data['color']}/{$data['aroma']}/{$data['temperature']}!"));
                
                // Always notify master number
                $this->wa->sendMessage($this->wa->getMasterNumber(), $this->bot->medanize("Lapor Bos! " . ($data['type'] == 'in' ? 'Terima' : 'Pakai') . " {$data['material_name']} sebanyak {$data['quantity']} {$data['material_unit']} di " . ($user->sppg->name ?? 'SPPG')));
                
                $actionStr = $data['type'] == 'in' ? 'Barang masuk' : 'Pemakaian barang';
                $replyMsg = "[SISTEM] $actionStr berupa {$data['material_name']} sebanyak {$data['quantity']} {$data['material_unit']} telah berhasil dicatat.";
                break;
            case 'mbg_dist':
                $dist = MbgDistribution::create(array_merge($data, ['distributed_at' => now()]));
                $this->sheets->syncMbgDistribution($dist);
                $replyMsg = "[SISTEM] Pengiriman {$data['quantity']} porsi MBG telah berhasil dicatat.";
                break;
            case 'menu':
                $menu = \App\Models\Menu::create([
                    'date' => now(),
                    'content' => $data['menu'],
                    'sppg_id' => $user->sppg_id
                ]);
                
                // Auto-create material logs for usage based on recipes
                if (isset($data['ingredients'])) {
                    foreach ($data['ingredients'] as $ing) {
                        $mat = Material::where('name', $ing['material'])->first();
                        if ($mat) {
                            $log = MaterialLog::create([
                                'material_id' => $mat->id,
                                'type' => 'out',
                                'quantity' => $ing['qty'], // assuming 1 portion for now as base
                                'date' => now(),
                                'sppg_id' => $user->sppg_id,
                                'notes' => 'Auto-usage from Menu: ' . $data['menu']
                            ]);
                            $this->sheets->syncMaterialLog($log);
                        }
                    }
                }
                
                $this->sheets->syncMenu($menu);
                $replyMsg = "[SISTEM] Menu baru '{$data['menu']}' telah berhasil dicatat.";
                break;
            case 'maker':
                $payment = Payment::find($data['id']);
                $payment->update(['status' => 'maker']); // change 'made' to 'maker' per spec
                $head = User::where('role', 'head')->where('sppg_id', $payment->sppg_id)->first();
                if ($head) $this->wa->sendMessage($head->phone, $this->bot->medanize("Lapor pak! Pengajuan dana ID {$data['id']} sudah di-MAKER oleh Yayasan. Tolong APPROVE!"));
                $replyMsg = "[SISTEM] Status MAKER untuk pengajuan dana telah berhasil dicatat.";
                break;
            case 'approve':
                $payment = Payment::find($data['id']);
                $payment->update(['status' => 'approved']);
                $this->sheets->syncPayment($payment);
                $this->notifyPaymentSuccess($payment);
                $replyMsg = "[SISTEM] Status APPROVE untuk pengajuan dana telah berhasil dicatat.";
                break;
        }

        cache()->forget("bot_state_$phone");
        cache()->forget("conf_data_$phone");
        cache()->forget("reg_ben_$phone");
        cache()->forget("reg_data_$phone");
        
        return $this->wa->sendMessage($phone, $replyMsg);
    }

    private function notifyPaymentSuccess($payment)
    {
        $users = User::where('sppg_id', $payment->sppg_id)->get();
        foreach ($users as $u) {
            if ($u->phone) $this->wa->sendMessage($u->phone, $this->bot->medanize("INFO: Pembayaran ID $payment->id sudah CAIR!"));
        }
        
        // Always notify master number
        $this->wa->sendMessage('6285353325352', $this->bot->medanize("INFO: Pembayaran ID $payment->id sudah CAIR dan selesai diproses!"));
    }

    private function handleAttendanceLocation($phone, $request)
    {
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');
        $address = $request->input('address');
        $message = $request->input('message');

        // Fallback: Check if coordinates are in the "message" field (Kirimi.id format)
        if ((!$lat || !$lng) && $message && stripos($message, 'Location:') !== false) {
            // Format example: "Location: -7.123, 112.456"
            if (preg_match('/Location:\s*([-\d.]+),\s*([-\d.]+)/i', $message, $matches)) {
                $lat = $matches[1];
                $lng = $matches[2];
            }
        }

        if (!$lat || !$lng) {
            return $this->wa->sendMessage($phone, $this->bot->medanize("Mana lokasimu lae? Kirimkanlah lewat fitur 'Share Location' di WA!"));
        }

        $user = User::where('phone', $phone)->first();
        
        // Detect SPPG via Geofence
        $targetSppg = $this->attendance->findSppgByCoordinates($lat, $lng);
        
        $sppgId = $targetSppg ? $targetSppg->id : ($user->sppg_id ?? null);
        $locationName = $targetSppg ? $targetSppg->name : ($user->sppg->name ?? 'Lokasi Luar');
        $isOutside = !$targetSppg;

        if (!$sppgId) {
            return $this->wa->sendMessage($phone, $this->bot->medanize("Maaf lae, belum terdaftar SPPG-mu di database. Hubungi admin ya biar didaftarkan dulu!"));
        }

        \App\Models\VolunteerAttendance::create([
            'user_id' => $user->id,
            'sppg_id' => $sppgId,
            'latitude' => $lat,
            'longitude' => $lng,
            'address' => $address,
            'status' => 'in'
        ]);

        cache()->forget("bot_state_$phone");

        // Notify admin of attendance
        $adminNumber = env('ADMIN_NOTIFICATION_NUMBER');
        if ($adminNumber) {
            $adminMsg = "*[NOTIFIKASI ABSEN" . ($isOutside ? " - LUAR AREA" : "") . "]*\n\n" .
                "Nama: *" . $user->name . "*\n" .
                "Nomor: +62" . ltrim($phone, '62') . "\n" .
                "SPPG: *$locationName*\n" .
                "Koordinat: $lat, $lng\n" .
                "Waktu: " . now()->format('d/m/Y H:i:s');
            $this->wa->sendMessage($adminNumber, $adminMsg);
        }

        $msg = "Kehadiran Anda telah berhasil dicatat di $locationName. Terima kasih dan semangat bekerja!";
        if ($isOutside) {
            $msg = "Kehadiran Anda berhasil dicatat meskipun di luar area SPPG ($locationName). Semangat bekerja ya lae!";
        }

        return $this->wa->sendMessage($phone, $this->bot->medanize($msg));
    }

    /**
     * Try to find a phone number in other tables and create a User record for it.
     */
    private function tryAutoRegisterUser($phone)
    {
        // Normalize the search phone (search for last 10 digits as a fallback)
        $shortPhone = strlen($phone) > 10 ? substr($phone, -10) : $phone;

        // 1. Check SPPG contacts (KA, Finance, Nutrition, or SPPG Phone)
        $sppg = \App\Models\Sppg::where('phone', 'like', "%$shortPhone%")
            ->orWhere('phone_ka', 'like', "%$shortPhone%")
            ->orWhere('phone_keuangan', 'like', "%$shortPhone%")
            ->orWhere('phone_gizi', 'like', "%$shortPhone%")
            ->first();
            
        if ($sppg) {
            $role = 'volunteer';
            $name = $sppg->name;
            
            if ($sppg->phone_ka && strpos($sppg->phone_ka, $shortPhone) !== false) { 
                $role = 'ka_sppg'; $name = $sppg->ka_sppg ?? "KA " . $sppg->name; 
            }
            elseif ($sppg->phone_keuangan && strpos($sppg->phone_keuangan, $shortPhone) !== false) { 
                $role = 'finance_supervisor'; $name = $sppg->pengawas_keuangan ?? "Finance " . $sppg->name; 
            }
            elseif ($sppg->phone_gizi && strpos($sppg->phone_gizi, $shortPhone) !== false) { 
                $role = 'nutrition_supervisor'; $name = $sppg->pengawas_gizi ?? "Gizi " . $sppg->name; 
            }
            
            return User::create([
                'name' => $name,
                'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name)) . "_" . rand(100, 999) . "@delphi.or.id",
                'phone' => $phone,
                'role' => $role,
                'sppg_id' => $sppg->id,
                'password' => \Hash::make(uniqid())
            ]);
        }
        
        // 2. Check Suppliers
        $supplier = \App\Models\Supplier::where('phone', 'like', "%$shortPhone%")->first();
        if ($supplier) {
            return User::create([
                'name' => $supplier->name,
                'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $supplier->name)) . "_" . rand(100, 999) . "@supplier.delphi.or.id",
                'phone' => $phone,
                'role' => 'volunteer',
                'sppg_id' => $supplier->sppg_id,
                'password' => \Hash::make(uniqid())
            ]);
        }
        
        // 3. Check Beneficiaries (Parent/Guardian)
        $ben = \App\Models\Beneficiary::where('guardian_phone', 'like', "%$shortPhone%")->first();
        if ($ben) {
            $name = $ben->parent_name ?? "Wali " . $ben->name;
            return User::create([
                'name' => $name,
                'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name)) . "_" . rand(100, 999) . "@parent.delphi.or.id",
                'phone' => $phone,
                'role' => 'volunteer',
                'sppg_id' => $ben->sppg_id,
                'password' => \Hash::make(uniqid())
            ]);
        }
        
        return null;
    }
}
