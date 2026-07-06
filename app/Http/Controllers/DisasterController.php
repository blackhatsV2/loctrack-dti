<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DisasterController extends Controller
{
    protected $disasterService;

    public function __construct(\App\Services\DisasterService $disasterService)
    {
        $this->disasterService = $disasterService;
    }

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
    public function getEarthquakes(Request $request)
    {
        $sync = $request->query('sync') === 'true';
        $data = $this->disasterService->getCachedEarthquakes($sync);
        return response()->json($data);
    }

    /**
     * Get natural events from NASA EONET.
     */
    public function getNaturalEvents(Request $request)
    {
        $sync = $request->query('sync') === 'true';
        $data = $this->disasterService->getCachedNaturalEvents($sync);
        return response()->json($data);
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

        $userLat = (float) $latestLocation->latitude;
        $userLon = (float) $latestLocation->longitude;

        try {
            // Retrieve data using standard cached helpers (do not force sync here to avoid lag on normal notifications checks)
            $usgsData = $this->disasterService->getCachedEarthquakes(false);
            $nasaData = $this->disasterService->getCachedNaturalEvents(false);

            $nearest = null;
            $minDistance = PHP_FLOAT_MAX;
            $philippineDisasters = [];

            $isInPhilippines = function($lat, $lon) {
                return ($lat >= 4.5 && $lat <= 21.5 && $lon >= 116.0 && $lon <= 127.0);
            };

            $isAdmin = $user->isAdmin();

            // Process USGS earthquakes
            $features = $usgsData['features'] ?? [];
            foreach ($features as $feature) {
                $lon = $feature['geometry']['coordinates'][0] ?? null;
                $lat = $feature['geometry']['coordinates'][1] ?? null;
                if ($lat === null || $lon === null) continue;

                $distance = $this->disasterService->calculateDistance($userLat, $userLon, (float)$lat, (float)$lon);
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

            // Process NASA events
            $events = $nasaData['events'] ?? [];
            foreach ($events as $event) {
                $geom = $event['geometry'][0] ?? null;
                if (!$geom || $geom['type'] !== 'Point') continue;

                $lon = $geom['coordinates'][0] ?? null;
                $lat = $geom['coordinates'][1] ?? null;
                if ($lat === null || $lon === null) continue;

                $distance = $this->disasterService->calculateDistance($userLat, $userLon, (float)$lat, (float)$lon);
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
