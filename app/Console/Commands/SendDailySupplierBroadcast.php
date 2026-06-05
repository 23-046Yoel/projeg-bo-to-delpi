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
        
        // Ambil semua menu besok beserta SPPG, hidangan, resep, dan bahan makanan
        $menus = Menu::with(['sppg', 'dishes.recipes.material'])
            ->whereDate('date', $tomorrowDate)
            ->get();

        if ($menus->isEmpty()) {
            $this->info('Tidak ada jadwal menu / kebutuhan bahan baku untuk besok. Broadcast dilewati.');
            \Log::info('Supplier broadcast skipped: no menus for tomorrow.');
            return;
        }

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
        $broadcastCount = 0;

        foreach ($menus as $menu) {
            $sppgName = $menu->sppg ? $menu->sppg->name : 'Master Office';
            
            // Hitung kebutuhan bahan untuk menu ini
            $requirements = [];
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

            if (empty($requirements)) {
                continue;
            }

            // Urutkan bahan baku secara alfabetis
            uasort($requirements, fn($a, $b) => strcmp($a['name'], $b['name']));

            // Format pesan sesuai dengan template dari client
            $formattedDate = Carbon::parse($tomorrowDate)->translatedFormat('d F Y');
            $message = "Hallo besok ({$formattedDate}) {$sppgName} membutuhkan pasokan bahan sbb :\n";
            
            $i = 1;
            foreach ($requirements as $req) {
                $message .= "{$i}. {$req['name']} " . number_format($req['quantity'], 0, ',', '.') . " {$req['unit']}\n";
                $i++;
            }
            
            $message .= "\n";
            $message .= "WA kan ke no 085355039822\n";
            $message .= "Nama bahan :\n";
            $message .= "Qty yang dapat dipasok :\n";
            $message .= "Harga yang anda tawarkan:\n\n";
            $message .= "Terima kasih";

            // Kirim ke semua pemasok yang terdaftar
            foreach ($normalizedPhones as $phone) {
                $this->info("Mengirim kebutuhan {$sppgName} ke +{$phone}...");
                $wa->sendMessage($phone, $message);
                $broadcastCount++;
            }
        }

        $this->info("Broadcast selesai. Total pesan terkirim: {$broadcastCount}.");
        \Log::info("Supplier broadcast completed. Sent total {$broadcastCount} messages.");
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
