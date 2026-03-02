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
        $locations = EmployeeLocation::with('user')
            ->select('id', 'user_id', 'employee_id_no', 'address', 'latitude', 'longitude', 'mobile_no', 'office', 'employee_type', 'recorded_at')
            ->whereIn('id', function($query) {
                $query->selectRaw('max(id)')
                    ->from('employee_locations')
                    ->groupBy('user_id');
            })
            ->get();

        return response()->json($locations);
    }
}
