<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\EmployeeLocation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEmployeeManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@dti6.gov.ph',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $this->user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);
    }

    public function test_admin_can_view_employees_page()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.employees'));
        $response->assertStatus(200);
        $response->assertSee('Employees');
    }

    public function test_admin_can_add_employee()
    {
        $employeeData = [
            'name' => 'New Employee',
            'email' => 'new@example.com',
            'mobile_no' => '09123456789',
            'office' => 'DTI Regional Office VI',
            'employee_type' => 'Casual',
            'address' => '123 Test Street, Iloilo City',
            'latitude' => 10.7255,
            'longitude' => 122.5699,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.employees.store'), $employeeData);

        $response->assertRedirect(route('admin.employees'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'New Employee',
            'email' => 'new@example.com',
            'employee_type' => 'Casual',
            'is_admin' => false,
        ]);

        $newUser = User::where('email', 'new@example.com')->first();
        $this->assertDatabaseHas('employee_locations', [
            'user_id' => $newUser->id,
            'mobile_no' => '09123456789',
            'employee_type' => 'Casual',
            'address' => '123 Test Street, Iloilo City',
            'latitude' => 10.7255,
            'longitude' => 122.5699,
        ]);
    }

    public function test_admin_can_add_employee_with_office_coords_fallback()
    {
        $employeeData = [
            'name' => 'Fallback Employee',
            'email' => 'fallback@example.com',
            'office' => 'DTI Antique',
            'employee_type' => 'Regular',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.employees.store'), $employeeData);

        $response->assertRedirect(route('admin.employees'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Fallback Employee',
            'email' => 'fallback@example.com',
            'office' => 'DTI Antique',
            'employee_type' => 'Regular',
        ]);

        $newUser = User::where('email', 'fallback@example.com')->first();
        
        // DTI Antique coordinates are 10.7441, 121.9421
        $this->assertDatabaseHas('employee_locations', [
            'user_id' => $newUser->id,
            'office' => 'DTI Antique',
            'latitude' => 10.7441,
            'longitude' => 121.9421,
        ]);
    }

    public function test_admin_can_delete_employee()
    {
        $employee = User::create([
            'name' => 'To Be Deleted',
            'email' => 'deleted@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        EmployeeLocation::create([
            'user_id' => $employee->id,
            'mobile_no' => '123',
            'latitude' => 0,
            'longitude' => 0,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.employees.destroy', $employee));

        $response->assertRedirect(route('admin.employees'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $employee->id]);
        $this->assertDatabaseMissing('employee_locations', ['user_id' => $employee->id]);
    }

    public function test_non_admin_cannot_add_employee()
    {
        $employeeData = [
            'name' => 'Should Fail',
            'email' => 'fail@example.com',
            'mobile_no' => '000',
        ];

        $response = $this->actingAs($this->user)->post(route('admin.employees.store'), $employeeData);

        // Should be redirected to dashboard if not an admin
        $response->assertRedirect(route('dashboard')); 
        $this->assertDatabaseMissing('users', ['email' => 'fail@example.com']);
    }

    public function test_non_admin_cannot_delete_employee()
    {
        $employee = User::create([
            'name' => 'Safe User',
            'email' => 'safe@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $response = $this->actingAs($this->user)->delete(route('admin.employees.destroy', $employee));

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', ['id' => $employee->id]);
    }

    public function test_admin_is_redirected_from_regular_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route('dashboard'));
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_regular_user_can_view_regular_dashboard()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Disaster Tracker Dashboard');
    }

    public function test_admin_can_delete_individual_location_history_log()
    {
        $location = EmployeeLocation::create([
            'user_id' => $this->user->id,
            'latitude' => 10.1,
            'longitude' => 120.2,
            'recorded_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.history.destroy', $location));

        $response->assertStatus(302); // redirect back
        $this->assertDatabaseMissing('employee_locations', ['id' => $location->id]);
    }

    public function test_admin_can_delete_selected_location_history_logs()
    {
        $loc1 = EmployeeLocation::create([
            'user_id' => $this->user->id,
            'latitude' => 10.1,
            'longitude' => 120.2,
            'recorded_at' => now(),
        ]);
        $loc2 = EmployeeLocation::create([
            'user_id' => $this->user->id,
            'latitude' => 10.2,
            'longitude' => 120.3,
            'recorded_at' => now(),
        ]);
        $loc3 = EmployeeLocation::create([
            'user_id' => $this->user->id,
            'latitude' => 10.3,
            'longitude' => 120.4,
            'recorded_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.employees.history.bulk', $this->user), [
            'action' => 'selected',
            'ids' => [$loc1->id, $loc3->id],
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('employee_locations', ['id' => $loc1->id]);
        $this->assertDatabaseMissing('employee_locations', ['id' => $loc3->id]);
        $this->assertDatabaseHas('employee_locations', ['id' => $loc2->id]);
    }

    public function test_admin_can_clear_all_location_history_logs_for_employee()
    {
        EmployeeLocation::create([
            'user_id' => $this->user->id,
            'latitude' => 10.1,
            'longitude' => 120.2,
            'recorded_at' => now(),
        ]);
        EmployeeLocation::create([
            'user_id' => $this->user->id,
            'latitude' => 10.2,
            'longitude' => 120.3,
            'recorded_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.employees.history.bulk', $this->user), [
            'action' => 'all',
        ]);

        $response->assertStatus(302);
        $this->assertEquals(0, EmployeeLocation::where('user_id', $this->user->id)->count());
    }

    public function test_non_admin_cannot_delete_location_history_logs()
    {
        $location = EmployeeLocation::create([
            'user_id' => $this->user->id,
            'latitude' => 10.1,
            'longitude' => 120.2,
            'recorded_at' => now(),
        ]);

        $response = $this->actingAs($this->user)->delete(route('admin.history.destroy', $location));
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('employee_locations', ['id' => $location->id]);

        $response2 = $this->actingAs($this->user)->delete(route('admin.employees.history.bulk', $this->user), [
            'action' => 'all',
        ]);
        $response2->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('employee_locations', ['id' => $location->id]);
    }

    public function test_admin_cannot_delete_history_of_another_admin()
    {
        $anotherAdmin = User::create([
            'name' => 'Another Admin',
            'email' => 'anotheradmin@dti6.gov.ph',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $location = EmployeeLocation::create([
            'user_id' => $anotherAdmin->id,
            'latitude' => 10.1,
            'longitude' => 120.2,
            'recorded_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.history.destroy', $location));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('employee_locations', ['id' => $location->id]);

        $response2 = $this->actingAs($this->admin)->delete(route('admin.employees.history.bulk', $anotherAdmin), [
            'action' => 'all',
        ]);
        $response2->assertSessionHas('error');
        $this->assertDatabaseHas('employee_locations', ['id' => $location->id]);
    }
}
