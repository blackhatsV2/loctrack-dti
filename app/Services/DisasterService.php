<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DisasterService
{
    /**
     * Get or fetch recent earthquakes.
     *
     * @param bool $sync Force refresh cache
     * @return array
     */
    public function getCachedEarthquakes(bool $sync = false): array
    {
        if (!$sync) {
            $cached = Cache::get('usgs_earthquakes');
            if ($cached) {
                return $cached;
            }
        }

        try {
            $startTime = now()->subDays(3)->format('Y-m-d');
            
            $response = Http::timeout(30)->get('https://earthquake.usgs.gov/fdsnws/event/1/query', [
                'format' => 'geojson',
                'starttime' => $startTime,
                'minmagnitude' => 2.5,
                'orderby' => 'time',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Cache::put('usgs_earthquakes', $data, now()->addDays(7));
                return $data;
            }
        } catch (\Exception $e) {
            Log::error('USGS API Error in DisasterService: ' . $e->getMessage());
        }

        // Fallback to stale cache if it exists, otherwise empty GeoJSON structure
        return Cache::get('usgs_earthquakes') ?: ['features' => []];
    }

    /**
     * Get or fetch natural events from NASA EONET.
     *
     * @param bool $sync Force refresh cache
     * @return array
     */
    public function getCachedNaturalEvents(bool $sync = false): array
    {
        if (!$sync) {
            $cached = Cache::get('nasa_events');
            if ($cached) {
                return $cached;
            }
        }

        try {
            $response = Http::timeout(30)->get('https://eonet.gsfc.nasa.gov/api/v3/events', [
                'status' => 'open',
                'limit' => 50,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Cache::put('nasa_events', $data, now()->addDays(7));
                return $data;
            }
        } catch (\Exception $e) {
            Log::error('NASA EONET API Error in DisasterService: ' . $e->getMessage());
        }

        // Fallback to stale cache if it exists, otherwise empty structure
        return Cache::get('nasa_events') ?: ['events' => []];
    }

    /**
     * Calculate distance between two coordinate pairs using the Haversine formula.
     *
     * @param float $lat1
     * @param float $lon1
     * @param float $lat2
     * @param float $lon2
     * @return float Distance in kilometers
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // km
        $lat1Rad = deg2rad($lat1);
        $lon1Rad = deg2rad($lon1);
        $lat2Rad = deg2rad($lat2);
        $lon2Rad = deg2rad($lon2);

        $dLat = $lat2Rad - $lat1Rad;
        $dLon = $lon2Rad - $lon1Rad;

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos($lat1Rad) * cos($lat2Rad) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
