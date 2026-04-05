<?php

namespace Database\Seeders;

use App\Models\Sppg;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SppgImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('Daftar (1).xlsx');
        
        if (!file_exists($filePath)) {
            $this->command->error("File not found: {$filePath}");
            return;
        }

        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray(null, true, true, true);

        // Berdasarkan struktur file:
        // A: ID DAPUR
        // B: NAMA DAPUR
        // C: KA SPPG
        // D: NO HP
        // E: PENGAWAS KEUANGAN
        // F: NO HP
        // G: PENGAWAS GIZI
        // H: NO HP
        
        $count = 0;
        foreach ($data as $index => $row) {
            // Lewati header (baris 1) dan baris kosong
            if ($index <= 1 || empty($row['B'])) {
                continue;
            }

            // Gunakan ID DAPUR sebagai kunci unik
            Sppg::updateOrCreate(
                ['code' => $row['A']],
                [
                    'name' => $row['B'],
                    'ka_sppg' => $row['C'],
                    'phone_ka' => $row['D'],
                    'pengawas_keuangan' => $row['E'],
                    'phone_keuangan' => $row['F'],
                    'pengawas_gizi' => $row['G'],
                    'phone_gizi' => $row['H'],
                    'phone' => $row['D'], // Default phone menggunakan NO HP KA SPPG
                ]
            );
            $count++;
        }

        $this->command->info("Berhasil mengimpor {$count} data Sppg.");
    }
}
