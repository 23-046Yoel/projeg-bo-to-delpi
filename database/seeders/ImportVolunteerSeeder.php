<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Sppg;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;

class ImportVolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = base_path('DATA NOMOR HP RELAWAN.xlsx');

        if (!file_exists($file)) {
            $this->command->error("File not found: " . $file);
            return;
        }

        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();
            
            $sppg = Sppg::where('name', 'SPPG Karangrejo')->first();
            $sppgId = $sppg ? $sppg->id : null;
            
            if (!$sppgId) {
                $this->command->error("SPPG KARANGREJO not found in database.");
                return;
            }

            $count = 0;
            $foundData = false;
            foreach ($data as $row) {
                // Look for the start of data (Row where first column is "1")
                if (isset($row[0]) && $row[0] == '1') {
                    $foundData = true;
                }
                
                if ($foundData && !empty($row[1])) {
                    $name = trim($row[1]);
                    $phone = trim($row[2]);
                    
                    // Sanitize phone (remove spaces)
                    $phone = str_replace(' ', '', $phone);
                    // Normalize to 62 format
                    if (str_starts_with($phone, '0')) {
                        $phone = '62' . substr($phone, 1);
                    } elseif (str_starts_with($phone, '8')) {
                        $phone = '62' . $phone;
                    }
                    
                    // Generate a dummy email
                    $emailBase = Str::slug($name) . '@delphi.or.id';
                    $email = $emailBase;
                    $idx = 1;
                    while (User::where('email', $email)->where('phone', '!=', $phone)->exists()) {
                        $email = Str::slug($name) . $idx . '@delphi.or.id';
                        $idx++;
                    }

                    // Check if user already exists by phone or name
                    $user = User::where('phone', $phone)->first() ?? User::where('name', $name)->first();
                    
                    if (!$user) {
                        User::create([
                            'name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'role' => User::ROLE_VOLUNTEER,
                            'sppg_id' => $sppgId,
                            'password' => bcrypt('relawan123'),
                        ]);
                        $count++;
                    } else {
                        // Update existing user
                        $user->update([
                            'role' => User::ROLE_VOLUNTEER,
                            'sppg_id' => $sppgId,
                            'phone' => $phone,
                        ]);
                        $this->command->info("Updated user: " . $name);
                    }
                }
            }
            
            $this->command->info("Imported/Updated $count volunteers.");
            
        } catch (\Exception $e) {
            $this->command->error('Error during import: ' . $e->getMessage());
        }
    }
}
