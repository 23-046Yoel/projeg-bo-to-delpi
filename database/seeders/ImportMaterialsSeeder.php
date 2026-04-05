<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportMaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('database bahan baku .xlsx');

        if (!file_exists($filePath)) {
            $this->command->error("Excel file not found: $filePath");
            return;
        }

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            $imported = 0;
            $updated = 0;

            // Start from row 5 as per inspection
            foreach ($data as $index => $row) {
                if ($index < 5) continue;

                $code = trim($row['A'] ?? '');
                $name = trim($row['B'] ?? '');
                $unit = trim($row['C'] ?? '');
                $price = (float) preg_replace('/[^0-9.]/', '', $row['D'] ?? '0');

                if (!$name) continue;

                // Create or Update by Code or Name
                $material = Material::where('code', $code)
                    ->orWhere('name', $name)
                    ->first();

                if ($material) {
                    $material->update([
                        'code' => $code,
                        'name' => $name,
                        'unit' => $unit,
                        'price' => $price,
                        'type' => 'raw',
                    ]);
                    $updated++;
                } else {
                    Material::create([
                        'code' => $code,
                        'name' => $name,
                        'unit' => $unit,
                        'price' => $price,
                        'type' => 'raw',
                        'stock' => 0,
                        'sppg_id' => null, // Global materials
                    ]);
                    $imported++;
                }
            }

            $this->command->info("Data Import Complete!");
            $this->command->info("New records: $imported");
            $this->command->info("Updated records: $updated");

        } catch (\Exception $e) {
            $this->command->error("Error reading Excel: " . $e->getMessage());
        }
    }
}
