<?php

namespace Tests\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Location;
use App\Services\LocationService;
use Mockery;

class LocationControllerTest extends TestCase
{
    /**
     * @return void
     **/
    public function test_index_method_returns_locations()
    {
        // simulating the service's expected response
        $expectedResponse = [
            'data' => [
                ['id' => 1, 'name' => 'Location 1', 'code' => 'LOC1'],
                ['id' => 2, 'name' => 'Location 2', 'code' => 'LOC2'],
            ],
            'status_code' => 200,
        ];

        // LocationService mock
        $locationServiceMock = Mockery::mock(LocationService::class);
        $locationServiceMock->shouldReceive('get')
            ->once()
            ->andReturn($expectedResponse);

        // replaces the original LocationService wit the mock
        $this->app->instance(LocationService::class, $locationServiceMock);

        // GET request for the route associated with the index method
        $response = $this->getJson(route('locations.index'));

        // checks that the answer is as expected
        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
    }
}
