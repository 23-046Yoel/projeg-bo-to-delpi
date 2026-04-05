<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BeneficiaryGroup;
use App\Models\DistributionRoute;
use App\Models\DistributionStop;
use App\Models\Sppg;
use Carbon\Carbon;

class RouteMonitoringDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = '2026-03-18';
        // Ensure SPPG has coordinates
        $sppg = Sppg::first();
        if ($sppg) {
            $sppg->update([
                'latitude' => 2.9698,
                'longitude' => 99.1678,
                'location' => 'Balimbingan II'
            ]);
            $sppgId = $sppg->id;
        }

        // Mobil 1
        $route1 = DistributionRoute::create([
            'assistant_id' => 3,
            'driver_id' => 1,
            'sppg_id' => $sppgId,
            'date' => $date,
            'status' => 'planned',
        ]);

        $schools1 = [
            ['name' => 'SD Margosono', 'lat' => 2.9690, 'lng' => 99.1600, 'time' => '08:45:00'],
            ['name' => 'SMPN 3 Tanah Jawa', 'lat' => 2.9700, 'lng' => 99.1800, 'time' => '08:45:00'],
            ['name' => 'SD AFD C Balimbingan', 'lat' => 2.9710, 'lng' => 99.1650, 'time' => '08:45:00'],
            ['name' => 'SD Maligas Tongah', 'lat' => 2.9730, 'lng' => 99.1620, 'time' => '08:45:00'],
            ['name' => 'B3 Nagori Balimbingan', 'lat' => 2.9720, 'lng' => 99.1700, 'time' => '10:45:00'],
        ];

        foreach ($schools1 as $index => $school) {
            $group = BeneficiaryGroup::updateOrCreate(
                ['name' => $school['name']], 
                [
                    'sppg_id' => $sppgId,
                    'latitude' => $school['lat'],
                    'longitude' => $school['lng'],
                    'location' => $school['name']
                ]
            );
            DistributionStop::create([
                'distribution_route_id' => $route1->id,
                'beneficiary_id' => $group->id,
                'order' => $index + 1,
                'status' => 'pending',
                'arrival_time' => Carbon::parse($date . ' ' . $school['time']),
            ]);
        }

        // Mobil 2
        $route2 = DistributionRoute::create([
            'assistant_id' => 5,
            'driver_id' => 4,
            'sppg_id' => $sppgId,
            'date' => $date,
            'status' => 'planned',
        ]);

        $schools2 = [
            ['name' => 'SD Bajadolok', 'lat' => 2.9650, 'lng' => 99.1850, 'time' => '09:30:00'],
            ['name' => 'TK, SD, SMP dan SMA Nusantara', 'lat' => 2.9680, 'lng' => 99.1720, 'time' => '09:30:00'],
            ['name' => 'SMPN 2 Tanah Jawa', 'lat' => 2.9750, 'lng' => 99.1550, 'time' => '10:20:00'],
        ];

        foreach ($schools2 as $index => $school) {
            $group = BeneficiaryGroup::updateOrCreate(
                ['name' => $school['name']], 
                [
                    'sppg_id' => $sppgId,
                    'latitude' => $school['lat'],
                    'longitude' => $school['lng'],
                    'location' => $school['name']
                ]
            );
            DistributionStop::create([
                'distribution_route_id' => $route2->id,
                'beneficiary_id' => $group->id,
                'order' => $index + 1,
                'status' => 'pending',
                'arrival_time' => Carbon::parse($date . ' ' . $school['time']),
            ]);
        }
    }
}
