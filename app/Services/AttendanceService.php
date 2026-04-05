<?php

namespace App\Services;

use App\Models\Sppg;

class AttendanceService
{
    /**
     * Find the closest SPPG based on coordinates and radius.
     */
    public function findSppgByCoordinates($lat, $lng)
    {
        $sppgs = Sppg::all();
        $closestSppg = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($sppgs as $sppg) {
            if (!$sppg->latitude || !$sppg->longitude) continue;

            $distance = $this->calculateDistance($lat, $lng, $sppg->latitude, $sppg->longitude);
            
            if ($distance <= $sppg->radius) {
                if ($distance < $minDistance) {
                    $minDistance = $distance;
                    $closestSppg = $sppg;
                }
            }
        }

        return $closestSppg;
    }

    /**
     * Calculate distance between two points in meters using Haversine formula.
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius of the Earth in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
