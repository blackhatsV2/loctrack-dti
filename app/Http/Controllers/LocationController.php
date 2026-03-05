<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        EmployeeLocation::create([
            'user_id' => Auth::id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'recorded_at' => now(),
        ]);

        return response()->json(['status' => 'success']);
    }

    public function index()
    {
        // Define admin email to exclude
        $adminEmail = 'admin@dti6.gov.ph';
        $adminIds = \App\Models\User::where('is_admin', true)->orWhere('email', $adminEmail)->pluck('id');

        // Get latest location ID for each non-admin user
        $latestLocationIds = EmployeeLocation::whereNotIn('user_id', $adminIds)
            ->selectRaw('MAX(id) as max_id')
            ->groupBy('user_id')
            ->pluck('max_id');

        $locations = EmployeeLocation::whereIn('id', $latestLocationIds)
            ->with('user')
            ->get();

        return response()->json($locations);
    }
}
