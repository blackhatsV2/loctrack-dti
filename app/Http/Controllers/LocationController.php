<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $latest = EmployeeLocation::where('user_id', $user->id)->latest('recorded_at')->first();

        EmployeeLocation::create([
            'user_id' => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'recorded_at' => now(),
            'address' => $latest?->address,
            'office' => $latest ? $latest->office : $user->office,
            'employee_id_no' => $latest ? $latest->employee_id_no : $user->employee_id_no,
            'mobile_no' => $latest ? $latest->mobile_no : $user->mobile_no,
            'employee_type' => $latest ? $latest->employee_type : $user->employee_type,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function index()
    {
        $user = Auth::user();
        
        // Use cached admin IDs
        $adminIds = Cache::remember('admin_user_ids', 600, function () {
            $adminEmail = 'admin@dti6.gov.ph';
            return \App\Models\User::where('is_admin', true)->orWhere('email', $adminEmail)->pluck('id')->toArray();
        });

        $query = EmployeeLocation::select('employee_locations.*')
            ->joinSub(function ($query) {
                $query->selectRaw('MAX(id) as max_id')
                    ->from('employee_locations')
                    ->groupBy('user_id', 'type');
            }, 'latest', 'employee_locations.id', '=', 'latest.max_id')
            ->whereNotIn('user_id', $adminIds);

        // If not admin, only show self
        if (!$user->is_admin) {
            $query->where('user_id', $user->id);
        }

        $locations = $query->with('user:id,name,email,office')
            ->get();

        return response()->json($locations);
    }

    /**
     * Show the employee geography management page.
     */
    public function geography()
    {
        $user = Auth::user();
        
        // Single query to get all user locations needed, ordered by most recent
        $userLocations = EmployeeLocation::where('user_id', $user->id)
            ->latest('recorded_at')
            ->limit(50)
            ->get();

        $homeLocation = $userLocations->first(function ($loc) {
            return $loc->type === 'home' || (is_null($loc->type) && !is_null($loc->address));
        });

        $officeLocation = $userLocations->first(function ($loc) {
            return $loc->type === 'office' || (is_null($loc->type) && !is_null($loc->office));
        });

        // Latest overall record for profile info
        $latestLocation = $userLocations->first();
        
        // Stats & History
        $totalCheckins = $userLocations->count(); // approximate from loaded records
        $recentHistory = $userLocations->take(8);

        // Activity Data (last 7 days) - filter from loaded collection
        $sevenDaysAgo = now()->subDays(7);
        $activityData = $userLocations->filter(function ($loc) use ($sevenDaysAgo) {
            return $loc->recorded_at && $loc->recorded_at->gte($sevenDaysAgo);
        })->groupBy(function ($loc) {
            return $loc->recorded_at->format('M d');
        })->map->count();

        // Cache dropdown options for 10 minutes (rarely change, expensive queries)
        $offices = Cache::remember('dropdown_offices', 600, function () {
            return EmployeeLocation::select('office')->distinct()
                ->whereNotNull('office')->where('office', '!=', '')
                ->orderBy('office')->pluck('office');
        });

        $employeeTypes = Cache::remember('dropdown_employee_types', 600, function () {
            return EmployeeLocation::select('employee_type')->distinct()
                ->whereNotNull('employee_type')->where('employee_type', '!=', '')
                ->orderBy('employee_type')->pluck('employee_type');
        });

        return view('geography', compact(
            'user', 
            'homeLocation', 
            'officeLocation', 
            'latestLocation', 
            'totalCheckins', 
            'recentHistory', 
            'activityData',
            'offices',
            'employeeTypes'
        ));
    }

    /**
     * Update employee address (Home or Office).
     */
    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'required|in:home,office',
        ]);

        $user = Auth::user();
        $latest = EmployeeLocation::where('user_id', $user->id)->latest('id')->first();

        $data = [
            'user_id' => $user->id,
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'recorded_at' => now(),
        ];

        if ($request->type === 'home') {
            $data['address'] = $request->address;
            $data['office'] = $latest ? $latest->office : $user->office;
            $data['employee_id_no'] = $latest ? $latest->employee_id_no : $user->employee_id_no;
            $data['mobile_no'] = $latest ? $latest->mobile_no : $user->mobile_no;
            $data['employee_type'] = $latest ? $latest->employee_type : $user->employee_type;
        } else {
            $data['office'] = $request->address; // Update office location
            $data['address'] = $latest ? $latest->address : null; // address is specific to home location
            $data['employee_id_no'] = $latest ? $latest->employee_id_no : $user->employee_id_no;
            $data['mobile_no'] = $latest ? $latest->mobile_no : $user->mobile_no;
            $data['employee_type'] = $latest ? $latest->employee_type : $user->employee_type;
        }

        EmployeeLocation::create($data);

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($request->type) . ' address updated successfully.'
        ]);
    }

    /**
     * Show the employee's own location history.
     */
    public function history()
    {
        $user = Auth::user();
        $locations = EmployeeLocation::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->paginate(25);

        return view('history', compact('user', 'locations'));
    }

    /**
     * Reuse a past location to create a new entry.
     */
    public function reuse($id)
    {
        $user = Auth::user();
        $location = EmployeeLocation::find($id);

        if (!$location) {
            return response()->json(['status' => 'error', 'message' => 'Location not found'], 404);
        }
        
        // Admin can reuse for any employee, User can only reuse their own
        if (!$user->is_admin && $location->user_id !== $user->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        try {
            $newLocation = $location->replicate();
            $newLocation->recorded_at = now();
            $newLocation->save();

            if (request()->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Location reused successfully.'
                ]);
            }

            return back()->with('success', 'Location reused successfully.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Database error'], 500);
            }
            return back()->withErrors(['Database error: ' . $e->getMessage()]);
        }
    }

    /**
     * Automatically broadcast current location.
     */
    public function broadcast(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $latest = EmployeeLocation::where('user_id', $user->id)->latest('recorded_at')->first();

        EmployeeLocation::create([
            'user_id' => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'recorded_at' => now(),
            'address' => $latest ? $latest->address : null,
            'office' => $latest ? $latest->office : $user->office,
            'employee_id_no' => $latest ? $latest->employee_id_no : $user->employee_id_no,
            'mobile_no' => $latest ? $latest->mobile_no : $user->mobile_no,
            'employee_type' => $latest ? $latest->employee_type : $user->employee_type,
            'type' => 'broadcast',
        ]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Update the user's professional profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'employee_id_no' => 'nullable|string|max:50',
            'mobile_no' => 'nullable|string|max:20',
            'office' => 'nullable|string|max:100',
            'employee_type' => 'nullable|string|max:50',
        ]);

        $user->update($validated);
        
        // Sync with latest location record to ensure dashboard reflects changes immediately
        $latest = EmployeeLocation::where('user_id', $user->id)->latest('id')->first();
        if ($latest) {
            $latest->update([
                'employee_id_no' => $request->employee_id_no,
                'mobile_no' => $request->mobile_no,
                'office' => $request->office,
                'employee_type' => $request->employee_type,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ], [
            'password.different' => 'The new password must be different from your current password.',
        ]);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully'
        ]);
    }
}
