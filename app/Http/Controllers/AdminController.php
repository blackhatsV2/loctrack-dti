<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Get admin user IDs (cached for 10 minutes to avoid redundant remote DB queries).
     */
    private function getAdminIds()
    {
        return Cache::remember('admin_user_ids', 600, function () {
            $adminEmail = 'admin@dti6.gov.ph';
            return User::where('is_admin', true)->orWhere('email', $adminEmail)->pluck('id')->toArray();
        });
    }

    /**
     * Get real coordinates for DTI Region 6 offices.
     */
    private function getOfficeCoordinates(string $office)
    {
        $coordinates = [
            'DTI Regional Office VI' => ['lat' => 10.7202, 'lng' => 122.5621],
            'DTI Aklan'             => ['lat' => 11.7061, 'lng' => 122.3653],
            'DTI Antique'           => ['lat' => 10.7441, 'lng' => 121.9421],
            'DTI Capiz'             => ['lat' => 11.5851, 'lng' => 122.7531],
            'DTI Guimaras'          => ['lat' => 10.5931, 'lng' => 122.5881],
            'DTI Iloilo'            => ['lat' => 10.7202, 'lng' => 122.5621],
            'DTI Negros Occidental' => ['lat' => 10.6761, 'lng' => 122.9511],
        ];

        return $coordinates[$office] ?? ['lat' => 10.7202, 'lng' => 122.5621]; // Default to Regional Office if unknown
    }
    /**
     * List all employees (non-admin users).
     */
    public function index(Request $request)
    {
        // Only show non-admin users (KML entries only)
        $adminIds = $this->getAdminIds();
        $query = User::whereNotIn('id', $adminIds)->where('is_admin', false);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($office = $request->input('office')) {
            $query->whereHas('locations', function ($q) use ($office) {
                $q->where('office', $office);
            });
        }

        $employees = $query->with(['locations' => function ($q) {
            $q->latest('id')->limit(1);
        }])
        ->orderBy('name')
        ->paginate(20);

        // Get unique offices for filter dropdown (only from non-admin users' locations)
        $offices = EmployeeLocation::whereNotIn('user_id', $adminIds)
            ->select('office')
            ->distinct()
            ->whereNotNull('office')
            ->where('office', '!=', '')
            ->orderBy('office')
            ->pluck('office')
            ->toArray();

        // Default DTI Region 6 offices if none or few found
        $defaultOffices = [
            'DTI Regional Office VI',
            'DTI Aklan',
            'DTI Antique',
            'DTI Capiz',
            'DTI Guimaras',
            'DTI Iloilo',
            'DTI Negros Occidental'
        ];

        $offices = array_unique(array_merge($offices, $defaultOffices));
        sort($offices);

        return view('admin.employees', compact('employees', 'offices'));
    }

    /**
     * Store a new employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'office' => 'required|string|max:255',
            'employee_id_no' => 'nullable|string|max:50',
            'mobile_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        // Standardize inputs
        $name = \Illuminate\Support\Str::title(trim($request->name));
        $email = strtolower(trim($request->email));
        $office = trim($request->office);
        $employeeIdNo = $request->employee_id_no ? strtoupper(trim($request->employee_id_no)) : null;
        $mobileNo = $request->mobile_no ? trim($request->mobile_no) : null;
        $address = $request->address ? trim($request->address) : null;

        if (str_contains($name, ',')) {
            $parts = explode(',', $name);
            $lastName = trim($parts[0]);
            $firstName = trim($parts[1] ?? '');
        } else {
            $parts = explode(' ', $name);
            $lastName = trim(array_pop($parts));
            $firstName = trim(implode('', $parts));
        }
        
        $password = strtolower(str_replace(' ', '', $lastName . $firstName)) . '06';

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'employee_id_no' => $employeeIdNo,
            'mobile_no' => $mobileNo,
            'office' => $office,
            'is_admin' => false,
        ]);

        // Get office coordinates
        $coords = $this->getOfficeCoordinates($office);

        // Create initial location record
        EmployeeLocation::create([
            'user_id' => $user->id,
            'employee_id_no' => $employeeIdNo,
            'office' => $office,
            'mobile_no' => $mobileNo,
            'address' => $address,
            'latitude' => $coords['lat'],
            'longitude' => $coords['lng'],
            'recorded_at' => now(),
        ]);

        return redirect()->route('admin.employees')->with('success', "Employee '{$user->name}' added successfully.");
    }

    /**
     * Show edit form for an employee.
     */
    public function edit(User $user)
    {
        $location = EmployeeLocation::where('user_id', $user->id)->latest('id')->first();

        $offices = EmployeeLocation::select('office')->distinct()
            ->whereNotNull('office')->where('office', '!=', '')
            ->orderBy('office')->pluck('office');

        $employeeTypes = EmployeeLocation::select('employee_type')->distinct()
            ->whereNotNull('employee_type')->where('employee_type', '!=', '')
            ->orderBy('employee_type')->pluck('employee_type');

        return view('admin.employee-edit', compact('user', 'location', 'offices', 'employeeTypes'));
    }

    /**
     * Update employee details.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:500',
            'mobile_no' => 'nullable|string|max:100',
            'office' => 'nullable|string|max:255',
            'employee_id_no' => 'nullable|string|max:50',
            'employee_type' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Standardize inputs
        $name = \Illuminate\Support\Str::title(trim($request->name));
        $email = strtolower(trim($request->email));
        $office = $request->office ? trim($request->office) : null;
        $employeeIdNo = $request->employee_id_no ? strtoupper(trim($request->employee_id_no)) : null;
        $mobileNo = $request->mobile_no ? trim($request->mobile_no) : null;
        $address = $request->address ? trim($request->address) : null;
        $employeeType = $request->employee_type ? trim($request->employee_type) : null;

        // Update user
        $user->update([
            'name' => $name,
            'email' => $email,
            'employee_id_no' => $employeeIdNo,
            'mobile_no' => $mobileNo,
            'office' => $office,
            'employee_type' => $employeeType,
        ]);

        // Update or create location record
        $location = EmployeeLocation::where('user_id', $user->id)->latest('id')->first();

        if ($location) {
            $lat = $request->latitude ?? $location->latitude;
            $lng = $request->longitude ?? $location->longitude;

            // Auto-update coordinates if they are 0 and office is set
            if (($lat == 0 && $lng == 0) && $office) {
                $coords = $this->getOfficeCoordinates($office);
                $lat = $coords['lat'];
                $lng = $coords['lng'];
            }

            $location->update([
                'address' => $address,
                'mobile_no' => $mobileNo,
                'office' => $office,
                'employee_id_no' => $employeeIdNo,
                'employee_type' => $employeeType,
                'latitude' => $lat,
                'longitude' => $lng,
            ]);
        }

        return redirect()->route('admin.employees')->with('success', "Employee '{$user->name}' updated successfully.");
    }

    /**
     * Show location history for an employee.
     */
    public function locationHistory(User $user)
    {
        $locations = EmployeeLocation::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->paginate(25);

        return view('admin.employee-history', compact('user', 'locations'));
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Cannot delete an admin account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.employees')->with('success', "Employee '{$name}' deleted successfully.");
    }

    /**
     * Admin dashboard overview.
     */
    public function dashboard()
    {
        $adminIds = $this->getAdminIds();

        // Cache statistics for 5 minutes to ensure snappy dashboard loads
        $stats = Cache::remember('admin_dashboard_stats', 300, function() use ($adminIds) {
            return [
                'totalEmployees' => User::whereNotIn('id', $adminIds)->count(),
                'totalOffices' => EmployeeLocation::whereIn('id', function($query) {
                        $query->selectRaw('MAX(id)')
                            ->from('employee_locations')
                            ->groupBy('user_id');
                    })
                    ->whereNotIn('user_id', $adminIds)
                    ->whereNotNull('office')
                    ->where('office', '!=', '')
                    ->distinct()
                    ->count('office')
            ];
        });

        $totalEmployees = $stats['totalEmployees'];
        $totalOffices = $stats['totalOffices'];
        $totalLocations = $totalEmployees;

        // Filter for "Online" users (active in last 24 hours for testing)
        $activeThreshold = now()->subHours(24);
        $onlineUsers = User::where('is_admin', false)
            ->where('last_activity_at', '>=', $activeThreshold)
            ->select(['id', 'name', 'email', 'office', 'last_activity_at'])
            ->get();

        return view('admin.dashboard', compact(
            'totalEmployees', 
            'totalLocations', 
            'totalOffices', 
            'onlineUsers'
        ));
    }

    /**
     * Workforce geography and analytics view.
     */
    public function workforce()
    {
        $adminIds = $this->getAdminIds();

        $latestLocations = EmployeeLocation::whereIn('id', function($query) {
                $query->selectRaw('MAX(id)')
                    ->from('employee_locations')
                    ->groupBy('user_id');
            })
            ->whereNotIn('user_id', $adminIds)
            ->with('user:id,name,email,office')
            ->get();

        $allOffices = $latestLocations->pluck('office')->unique()->filter()->values();
        $employeeTypes = $latestLocations->pluck('employee_type')->unique()->filter()->values();

        // Analytics Data
        $officeDistribution = $latestLocations->groupBy('office')
            ->map(fn($group) => $group->count())
            ->filter(fn($count, $office) => !empty($office));

        $typeDistribution = $latestLocations->groupBy('employee_type')
            ->map(fn($group) => $group->count())
            ->filter(fn($count, $type) => !empty($type));

        // Reuse latestLocations as recentLocations instead of a separate 300-row query
        $recentLocations = $latestLocations;

        $offices = $allOffices;

        return view('admin.workforce', compact(
            'latestLocations',
            'allOffices',
            'employeeTypes',
            'officeDistribution',
            'typeDistribution',
            'recentLocations',
            'offices'
        ));
    }

    /**
     * Update current admin profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }
}
