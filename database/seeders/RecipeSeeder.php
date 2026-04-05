<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipes = [
            'Nasi Putih' => [
                ['material' => 'beras', 'qty' => 0.06, 'unit' => 'kg']
            ],
            'Ayam Goreng Tepung' => [
                ['material' => 'ayam', 'qty' => 0.1, 'unit' => 'kg', 'notes' => '10 porsi/kg'],
                ['material' => 'tepung tapioka', 'qty' => 0.03, 'unit' => 'kg', 'notes' => '33 porsi/kg'],
                ['material' => 'garam', 'qty' => 0.002, 'unit' => 'kg', 'notes' => '500 porsi/kg']
            ],
            'Capcay' => [
                ['material' => 'buncis', 'qty' => 0.03, 'unit' => 'kg', 'notes' => '33 porsi/kg'],
                ['material' => 'bunga kol', 'qty' => 0.03, 'unit' => 'kg', 'notes' => '33 porsi/kg'],
                ['material' => 'wortel', 'qty' => 0.03, 'unit' => 'kg', 'notes' => '33 porsi/kg']
            ],
            'Pepaya' => [
                ['material' => 'Pepaya', 'qty' => 0.05, 'unit' => 'buah', 'notes' => '1 pepaya dipotong 20']
            ],
            'Ikan Nila Goreng' => [
                ['material' => 'Nila', 'qty' => 0.083, 'unit' => 'kg', 'notes' => '6 ekor / kg; 2 porsi /ekor']
            ],
            'Ikan Lele' => [
                ['material' => 'Lele', 'qty' => 0.1, 'unit' => 'kg', 'notes' => '10 ekor/kg']
            ],
            'Tahu Goreng' => [
                ['material' => 'tahu', 'qty' => 1, 'unit' => 'buah', 'notes' => '1 buah tahu/porsi']
            ],
            'Tempe Goreng' => [
                ['material' => 'tempe', 'qty' => 0.2, 'unit' => 'buah', 'notes' => '5 porsi/1 tempe']
            ]
        ];

        foreach ($recipes as $dishName => $ingredients) {
            $dish = \App\Models\Dish::firstOrCreate(['name' => $dishName]);
            foreach ($ingredients as $ing) {
                $material = \App\Models\Material::where('name', 'like', '%' . $ing['material'] . '%')->first();
                if (!$material) {
                    $material = \App\Models\Material::create(['name' => $ing['material']]);
                }

                \App\Models\Recipe::updateOrCreate(
                    ['dish_id' => $dish->id, 'material_id' => $material->id],
                    [
                        'quantity' => $ing['qty'],
                        'unit' => $ing['unit'],
                        'notes' => $ing['notes'] ?? null
                    ]
                );
            }
        }
    }
}
