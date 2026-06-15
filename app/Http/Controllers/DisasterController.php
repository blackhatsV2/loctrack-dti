<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DisasterController extends Controller
{
    /**
     * Display the disaster tracker page.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user && $user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // Fetch stats for the dashboard highlight
        $totalCheckins = \App\Models\EmployeeLocation::where('user_id', $user->id)->count();
        $latestLocation = \App\Models\EmployeeLocation::where('user_id', $user->id)
            ->latest('recorded_at')
            ->first();

        // Get offices and employee types for profile editing (if we keep it on dashboard)
        $offices = \Illuminate\Support\Facades\Cache::remember('dropdown_offices', 600, function () {
            return \App\Models\EmployeeLocation::select('office')->distinct()
                ->whereNotNull('office')->where('office', '!=', '')
                ->orderBy('office')->pluck('office');
        });

        $employeeTypes = \Illuminate\Support\Facades\Cache::remember('dropdown_employee_types', 600, function () {
            return \App\Models\EmployeeLocation::select('employee_type')->distinct()
                ->whereNotNull('employee_type')->where('employee_type', '!=', '')
                ->orderBy('employee_type')->pluck('employee_type');
        });

        return view('disasters', compact('user', 'totalCheckins', 'latestLocation', 'offices', 'employeeTypes'));
    }

    /**
     * Get recent earthquakes from USGS filtered for Philippines.
     */
    public function getEarthquakes()
    {
        try {
            // Fetch global earthquakes from the past 3 days
            $startTime = now()->subDays(3)->format('Y-m-d');
            
            $response = Http::timeout(30)->get('https://earthquake.usgs.gov/fdsnws/event/1/query', [
                'format' => 'geojson',
                'starttime' => $startTime,
                'minmagnitude' => 2.5,
                'orderby' => 'time',
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Failed to fetch earthquake data'], 500);
        } catch (\Exception $e) {
            Log::error('USGS API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Service unavailable'], 503);
        }
    }

    /**
     * Get natural events from NASA EONET.
     */
    public function getNaturalEvents()
    {
        try {
            // NASA EONET v3
            $response = Http::timeout(30)->get('https://eonet.gsfc.nasa.gov/api/v3/events', [
                'status' => 'open',
                'limit' => 50,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Optional: Filter for PH bounding box if desired, 
                // but NASA events are often global/regional (like typhoons)
                // We'll return all and let the frontend filter or display them on the map.
                return response()->json($data);
            }

            return response()->json(['error' => 'Failed to fetch natural events'], 500);
        } catch (\Exception $e) {
            Log::error('NASA EONET API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Service unavailable'], 503);
        }
    }

    /**
     * Get the nearest disaster to the user's latest location.
     */
    public function nearestDisaster()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get the latest location of the user
        $latestLocation = $user->locations()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest('recorded_at')
            ->first();

        if (!$latestLocation) {
            return response()->json(['message' => 'No location recorded yet'], 200);
        }

        $userLat = $latestLocation->latitude;
        $userLon = $latestLocation->longitude;

        try {
            $startTime = now()->subDays(3)->format('Y-m-d');
            
            $usgsResponse = Http::timeout(15)->get('https://earthquake.usgs.gov/fdsnws/event/1/query', [
                'format' => 'geojson',
                'starttime' => $startTime,
                'minmagnitude' => 2.5,
                'orderby' => 'time',
            ]);

            $nasaResponse = Http::timeout(15)->get('https://eonet.gsfc.nasa.gov/api/v3/events', [
                'status' => 'open',
                'limit' => 50,
            ]);

            $nearest = null;
            $minDistance = PHP_FLOAT_MAX;

            $earthRadius = 6371; // km
            $userLatRad = deg2rad($userLat);
            $userLonRad = deg2rad($userLon);

            $calculateDistance = function($lat, $lon) use ($earthRadius, $userLatRad, $userLonRad, $userLat) {
                $dLat = deg2rad($lat - $userLat);
                $dLon = deg2rad($lon - rad2deg($userLonRad));
                $a = sin($dLat/2) * sin($dLat/2) +
                     cos($userLatRad) * cos(deg2rad($lat)) *
                     sin($dLon/2) * sin($dLon/2);
                $c = 2 * atan2(sqrt($a), sqrt(1-$a));
                return $earthRadius * $c;
            };

            $isAdmin = $user->isAdmin();
            $philippineDisasters = [];
            $isInPhilippines = function($lat, $lon) {
                return ($lat >= 4.5 && $lat <= 21.5 && $lon >= 116.0 && $lon <= 127.0);
            };

            // Process USGS
            if ($usgsResponse->successful()) {
                $features = $usgsResponse->json()['features'] ?? [];
                foreach ($features as $feature) {
                    $lon = $feature['geometry']['coordinates'][0] ?? null;
                    $lat = $feature['geometry']['coordinates'][1] ?? null;
                    if ($lat === null || $lon === null) continue;

                    $distance = $calculateDistance($lat, $lon);
                    $disasterItem = [
                        'id' => $feature['id'],
                        'title' => $feature['properties']['title'],
                        'type' => 'earthquake',
                        'magnitude' => $feature['properties']['mag'],
                        'time' => $feature['properties']['time'],
                        'distance_km' => round($distance, 2),
                        'latitude' => $lat,
                        'longitude' => $lon,
                    ];

                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $nearest = $disasterItem;
                    }

                    if ($isAdmin && $isInPhilippines($lat, $lon)) {
                        $philippineDisasters[] = $disasterItem;
                    }
                }
            }

            // Process NASA
            if ($nasaResponse->successful()) {
                $events = $nasaResponse->json()['events'] ?? [];
                foreach ($events as $event) {
                    $geom = $event['geometry'][0] ?? null;
                    if (!$geom || $geom['type'] !== 'Point') continue;

                    $lon = $geom['coordinates'][0] ?? null;
                    $lat = $geom['coordinates'][1] ?? null;
                    if ($lat === null || $lon === null) continue;

                    $distance = $calculateDistance($lat, $lon);
                    $disasterItem = [
                        'id' => $event['id'],
                        'title' => $event['title'],
                        'type' => 'nasa',
                        'category' => $event['categories'][0]['title'] ?? 'Natural Event',
                        'time' => isset($geom['date']) ? strtotime($geom['date']) * 1000 : time() * 1000,
                        'distance_km' => round($distance, 2),
                        'latitude' => $lat,
                        'longitude' => $lon,
                    ];

                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $nearest = $disasterItem;
                    }

                    if ($isAdmin && $isInPhilippines($lat, $lon)) {
                        $philippineDisasters[] = $disasterItem;
                    }
                }
            }

            if ($isAdmin) {
                usort($philippineDisasters, function($a, $b) {
                    return $b['time'] <=> $a['time']; // Descending order
                });
            }

            if ($nearest || $isAdmin) {
                return response()->json([
                    'nearest_disaster' => $nearest,
                    'philippine_disasters' => $philippineDisasters,
                    'user_location' => [
                        'latitude' => $userLat,
                        'longitude' => $userLon,
                        'address' => $latestLocation->address,
                    ],
                    'is_admin' => $isAdmin,
                ]);
            }

            return response()->json(['message' => 'No disasters found'], 200);
        } catch (\Exception $e) {
            Log::error('Disaster API Error for Nearest: ' . $e->getMessage());
            return response()->json(['error' => 'Service unavailable'], 503);
        }
    }
}
