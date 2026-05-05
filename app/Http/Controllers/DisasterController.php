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
}
