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
            ->select('employee_locations.id', 'employee_locations.user_id', 'employee_locations.employee_id_no', 'employee_locations.address', 'employee_locations.latitude', 'employee_locations.longitude', 'employee_locations.mobile_no', 'employee_locations.office', 'employee_locations.employee_type', 'employee_locations.recorded_at')
            ->join(
                \DB::raw('(select max(id) as max_id from employee_locations group by user_id) as latest'),
                'employee_locations.id', '=', 'latest.max_id'
            )
            ->get();

        return response()->json($locations);
    }
}
