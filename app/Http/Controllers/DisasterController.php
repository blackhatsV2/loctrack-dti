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
        return view('disasters');
    }

    /**
     * Get recent earthquakes from USGS filtered for Philippines.
     */
    public function getEarthquakes()
    {
        try {
            // PH Bounding Box: minlat=4.5, maxlat=21.5, minlon=116.0, maxlon=127.0
            // Get past 7 days by default
            $startTime = now()->subDays(7)->format('Y-m-d');
            
            $response = Http::timeout(10)->get('https://earthquake.usgs.gov/fdsnws/event/1/query', [
                'format' => 'geojson',
                'starttime' => $startTime,
                'minlatitude' => 4.5,
                'maxlatitude' => 21.5,
                'minlongitude' => 116.0,
                'maxlongitude' => 127.0,
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
            $response = Http::timeout(10)->get('https://eonet.gsfc.nasa.gov/api/v3/events', [
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
