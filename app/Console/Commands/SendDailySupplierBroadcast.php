<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Menu;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class SendDailySupplierBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:broadcast-requirements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Broadcast tomorrow\'s and 2 days later\'s material requirements to suppliers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrowDate = Carbon::now()->addDay()->toDateString();
        $twoDaysLaterDate = Carbon::now()->addDays(2)->toDateString();

        $tomorrowRequirements = $this->getRequirementsForDate($tomorrowDate);
        $twoDaysLaterRequirements = $this->getRequirementsForDate($twoDaysLaterDate);

        // Jika kedua tanggal tidak memiliki kebutuhan, log info dan lewati broadcast
        if (empty($tomorrowRequirements) && empty($twoDaysLaterRequirements)) {
            $this->info('Tidak ada kebutuhan bahan baku untuk besok dan lusa. Broadcast dibatalkan.');
            \Log::info('Supplier broadcast skipped: no requirements for tomorrow and two days later.');
            return;
        }

        // Format pesan broadcast
        $message = "*[INFORMASI KEBUTUHAN BAHAN]*\n";
        $message .= "Halo Bapak/Ibu Pemasok 👋\n\n";
        $message .= "Berikut adalah daftar kebutuhan bahan makanan untuk program Makan Bergizi Gratis (MBG) Alad Delphi:\n\n";

        // Kebutuhan besok
        $message .= "📅 *Besok (" . Carbon::parse($tomorrowDate)->translatedFormat('l, d F Y') . ")*:\n";
        if (!empty($tomorrowRequirements)) {
            foreach ($tomorrowRequirements as $req) {
                $message .= "- " . $req['name'] . ": " . number_format($req['quantity'], 0, ',', '.') . " " . $req['unit'] . "\n";
            }
        } else {
            $message .= "_Tidak ada jadwal menu / kebutuhan bahan._\n";
        }
        $message .= "\n";

        // Kebutuhan lusa (2 hari setelahnya)
        $message .= "📅 *Lusa (" . Carbon::parse($twoDaysLaterDate)->translatedFormat('l, d F Y') . ")*:\n";
        if (!empty($twoDaysLaterRequirements)) {
            foreach ($twoDaysLaterRequirements as $req) {
                $message .= "- " . $req['name'] . ": " . number_format($req['quantity'], 0, ',', '.') . " " . $req['unit'] . "\n";
            }
        } else {
            $message .= "_Tidak ada jadwal menu / kebutuhan bahan._\n";
        }
        $message .= "\n";

        $message .= "Jika anda memiliki bahan harap kirim wa ke 085355039822\n\n";
        $message .= "Terima kasih atas kerjasamanya! 🙏";

        // Himpun semua nomor HP unik dari Pemasok (tabel suppliers & users ber-role pemasok)
        $supplierPhones = Supplier::whereNotNull('phone')->pluck('phone')->toArray();
        $userPhones = User::where('role', User::ROLE_PEMASOK)->whereNotNull('phone')->pluck('phone')->toArray();

        $allPhones = array_merge($supplierPhones, $userPhones);
        $normalizedPhones = [];

        foreach ($allPhones as $rawPhone) {
            $phone = preg_replace('/[^0-9]/', '', $rawPhone);
            if (str_starts_with($phone, '620')) {
                $phone = '62' . substr($phone, 3);
            } elseif (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            } elseif (str_starts_with($phone, '8')) {
                $phone = '62' . $phone;
            }

            if (!empty($phone) && !in_array($phone, $normalizedPhones)) {
                $normalizedPhones[] = $phone;
            }
        }

        if (empty($normalizedPhones)) {
            $this->warn('Tidak ada nomor HP pemasok yang terdaftar.');
            return;
        }

        $wa = app(WhatsAppService::class);
        $count = 0;

        foreach ($normalizedPhones as $phone) {
            $this->info("Mengirim kebutuhan bahan ke +{$phone}...");
            $wa->sendMessage($phone, $message);
            $count++;
        }

        $this->info("Broadcast selesai. Berhasil mengirim ke {$count} nomor pemasok.");
        \Log::info("Supplier broadcast completed. Sent to {$count} suppliers.");
    }

    /**
     * Hitung kebutuhan bahan untuk tanggal tertentu
     */
    private function getRequirementsForDate($date)
    {
        $requirements = [];
        $menus = Menu::with(['dishes.recipes.material'])
            ->whereDate('date', $date)
            ->get();

        foreach ($menus as $menu) {
            foreach ($menu->dishes as $dish) {
                $portions = ($dish->pivot->porsi_besar + $dish->pivot->porsi_kecil) ?: $dish->pivot->portions;
                foreach ($dish->recipes as $recipe) {
                    if (!$recipe->material) continue;
                    $matId = $recipe->material_id;
                    $needed = $recipe->quantity * $portions;
                    if (!isset($requirements[$matId])) {
                        $requirements[$matId] = [
                            'name'     => $recipe->material->name,
                            'quantity' => 0,
                            'unit'     => $recipe->unit,
                        ];
                    }
                    $requirements[$matId]['quantity'] += $needed;
                }
            }
        }

        // Urutkan nama bahan secara alfabetis
        uasort($requirements, fn($a, $b) => strcmp($a['name'], $b['name']));

        return $requirements;
    }
}
