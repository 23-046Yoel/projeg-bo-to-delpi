<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Helper function to get or create dish ID by name
        $getDishId = function($name) {
            $id = DB::table('dishes')->where('name', 'like', $name)->value('id');
            if ($id) {
                return $id;
            }
            return DB::table('dishes')->insertGetId([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        };

        // Resolve dish IDs dynamically
        $nasiPutihId = $getDishId('Nasi putih');
        $chickenTeriyakiId = $getDishId('Chicken teriyaki');
        $tahuGorengId = $getDishId('Tahu goreng');
        $tumisLabuId = $getDishId('Tumis labu siam & wortel');
        $semangkaId = $getDishId('Semangka');
        $seladaId = $getDishId('Selada');

        // 1. SPPG 3 (Karang Rejo)
        // Check if menu for 2026-05-17 already exists for SPPG 3
        $menu3Id = DB::table('menus')->where('date', '2026-05-17')->where('sppg_id', 3)->value('id');
        if (!$menu3Id) {
            $menu3Id = DB::table('menus')->insertGetId([
                'date' => '2026-05-17',
                'sppg_id' => 3,
                'content' => 'FIT & FRESH TERIYAKI CHICKEN MEAL',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Sync dishes for SPPG 3
        $dishes3 = [
            $nasiPutihId       => ['porsi_kecil' => 1015, 'porsi_besar' => 1540],
            $chickenTeriyakiId => ['porsi_kecil' => 1015, 'porsi_besar' => 1540],
            $tahuGorengId      => ['porsi_kecil' => 1015, 'porsi_besar' => 1540],
            $tumisLabuId       => ['porsi_kecil' => 1015, 'porsi_besar' => 1540],
            $semangkaId        => ['porsi_kecil' => 1015, 'porsi_besar' => 1540],
            $seladaId          => ['porsi_kecil' => 1015, 'porsi_besar' => 1540],
        ];

        DB::table('dish_menu')->where('menu_id', $menu3Id)->delete();
        foreach ($dishes3 as $dishId => $portions) {
            DB::table('dish_menu')->insert([
                'menu_id' => $menu3Id,
                'dish_id' => $dishId,
                'portions' => $portions['porsi_kecil'] + $portions['porsi_besar'],
                'porsi_kecil' => $portions['porsi_kecil'],
                'porsi_besar' => $portions['porsi_besar'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. SPPG 4 (Balimbingan II)
        // Check if menu for 2026-05-17 already exists for SPPG 4
        $menu4Id = DB::table('menus')->where('date', '2026-05-17')->where('sppg_id', 4)->value('id');
        if (!$menu4Id) {
            $menu4Id = DB::table('menus')->insertGetId([
                'date' => '2026-05-17',
                'sppg_id' => 4,
                'content' => 'FIT & FRESH TERIYAKI CHICKEN MEAL',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Sync dishes for SPPG 4 (using its standard portions: Kecil: 499, Besar: 2064)
        $dishes4 = [
            $nasiPutihId       => ['porsi_kecil' => 499, 'porsi_besar' => 2064],
            $chickenTeriyakiId => ['porsi_kecil' => 499, 'porsi_besar' => 2064],
            $tahuGorengId      => ['porsi_kecil' => 499, 'porsi_besar' => 2064],
            $tumisLabuId       => ['porsi_kecil' => 499, 'porsi_besar' => 2064],
            $semangkaId        => ['porsi_kecil' => 499, 'porsi_besar' => 2064],
            $seladaId          => ['porsi_kecil' => 499, 'porsi_besar' => 2064],
        ];

        DB::table('dish_menu')->where('menu_id', $menu4Id)->delete();
        foreach ($dishes4 as $dishId => $portions) {
            DB::table('dish_menu')->insert([
                'menu_id' => $menu4Id,
                'dish_id' => $dishId,
                'portions' => $portions['porsi_kecil'] + $portions['porsi_besar'],
                'porsi_kecil' => $portions['porsi_kecil'],
                'porsi_besar' => $portions['porsi_besar'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $menuIds = DB::table('menus')->where('date', '2026-05-17')->whereIn('sppg_id', [3, 4])->pluck('id');
        DB::table('dish_menu')->whereIn('menu_id', $menuIds)->delete();
        DB::table('menus')->whereIn('id', $menuIds)->delete();
    }
};
