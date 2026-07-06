<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Services\DisasterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HazardSyncTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);
    }

    public function test_disaster_endpoints_retrieve_from_cache_by_default()
    {
        // Place fake data in cache
        Cache::put('usgs_earthquakes', ['features' => [['id' => 'fake_eq']]], 3600);
        Cache::put('nasa_events', ['events' => [['id' => 'fake_nasa']]], 3600);

        // Fake HTTP requests - we expect NO HTTP requests to be made since cache exists
        Http::fake([
            'earthquake.usgs.gov/*' => Http::response(['features' => []], 200),
            'eonet.gsfc.nasa.gov/*' => Http::response(['events' => []], 200),
        ]);

        $responseEq = $this->actingAs($this->user)->get(route('api.disasters.earthquakes'));
        $responseEv = $this->actingAs($this->user)->get(route('api.disasters.events'));

        $responseEq->assertStatus(200);
        $responseEq->assertJsonPath('features.0.id', 'fake_eq');

        $responseEv->assertStatus(200);
        $responseEv->assertJsonPath('events.0.id', 'fake_nasa');

        // Verify that no HTTP requests were made
        Http::assertNothingSent();
    }

    public function test_disaster_endpoints_perform_live_fetch_when_sync_is_true()
    {
        // Place fake data in cache
        Cache::put('usgs_earthquakes', ['features' => [['id' => 'fake_eq']]], 3600);
        Cache::put('nasa_events', ['events' => [['id' => 'fake_nasa']]], 3600);

        // Fake HTTP requests returning new data
        Http::fake([
            'earthquake.usgs.gov/*' => Http::response(['features' => [['id' => 'new_eq']]], 200),
            'eonet.gsfc.nasa.gov/*' => Http::response(['events' => [['id' => 'new_nasa']]], 200),
        ]);

        $responseEq = $this->actingAs($this->user)->get(route('api.disasters.earthquakes', ['sync' => 'true']));
        $responseEv = $this->actingAs($this->user)->get(route('api.disasters.events', ['sync' => 'true']));

        $responseEq->assertStatus(200);
        $responseEq->assertJsonPath('features.0.id', 'new_eq');

        $responseEv->assertStatus(200);
        $responseEv->assertJsonPath('events.0.id', 'new_nasa');

        // Check that the cache was updated with the new values
        $this->assertEquals('new_eq', Cache::get('usgs_earthquakes')['features'][0]['id']);
        $this->assertEquals('new_nasa', Cache::get('nasa_events')['events'][0]['id']);

        // Verify that HTTP requests were made
        Http::assertSentCount(2);
    }

    public function test_login_flow_pre_warms_cache_if_missing()
    {
        // Make sure cache is empty
        Cache::forget('usgs_earthquakes');
        Cache::forget('nasa_events');

        // Fake HTTP requests
        Http::fake([
            'earthquake.usgs.gov/*' => Http::response(['features' => [['id' => 'pre_warmed_eq']]], 200),
            'eonet.gsfc.nasa.gov/*' => Http::response(['events' => [['id' => 'pre_warmed_nasa']]], 200),
        ]);

        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');

        // Assert cache is now populated
        $this->assertTrue(Cache::has('usgs_earthquakes'));
        $this->assertTrue(Cache::has('nasa_events'));
        $this->assertEquals('pre_warmed_eq', Cache::get('usgs_earthquakes')['features'][0]['id']);
        $this->assertEquals('pre_warmed_nasa', Cache::get('nasa_events')['events'][0]['id']);
    }
}
