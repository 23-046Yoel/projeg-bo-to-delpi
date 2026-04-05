<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendDailyRecapWA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recap:send-wa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily recap to key stakeholders via WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        $sppgs = \App\Models\Sppg::all();

        foreach ($sppgs as $sppg) {
            $stats = $this->getStats($sppg->id, $today);
            $message = $this->formatMessage($sppg->name, $stats);

            // Notify stakeholders for this SPPG
            $stakeholders = \App\Models\User::where('sppg_id', $sppg->id)
                ->whereIn('role', ['aslap', 'head', 'finance'])
                ->get();

            $wa = app(\App\Services\WhatsAppService::class);
            $bot = app(\App\Services\BoToPersonalityService::class);

            // Send to database stakeholders
            foreach ($stakeholders as $user) {
                if ($user->phone) $wa->sendMessage($user->phone, $bot->medanize($message));
            }

            // Always send to master number
            $wa->sendMessage($wa->getMasterNumber(), $bot->medanize($message));
        }
    }

    private function getStats($sppgId, $date)
    {
        return [
            'porsi' => \App\Models\MbgDistribution::where('sppg_id', $sppgId)->whereDate('distributed_at', $date)->sum('quantity'),
            'bahan_masuk' => \App\Models\MaterialLog::where('sppg_id', $sppgId)->whereDate('date', $date)->where('type', 'in')->count(),
            'dana_cair' => \App\Models\Payment::where('sppg_id', $sppgId)->whereDate('date', $date)->where('status', 'approved')->sum('amount'),
        ];
    }

    private function formatMessage($name, $stats)
    {
        return "REKAP HARIAN SPPG $name\n" .
               "--------------------------\n" .
               "MBG Terdistribusi: " . $stats['porsi'] . " porsi\n" .
               "Log Bahan Masuk: " . $stats['bahan_masuk'] . " item\n" .
               "Realisasi Dana: Rp " . number_format($stats['dana_cair']) . "\n" .
               "--------------------------\n" .
               "Paten kali kerjanya hari ini bah!";
    }
}
