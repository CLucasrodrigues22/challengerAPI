<?php

namespace Tests\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\DTO\{CreateLocationDTO, UpdateLocationDTO};
use App\Http\Requests\{StoreLocationRequest, UpdateLocationRequest};
use App\Services\LocationService;
use Mockery;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     **/
    public function test_index_method_returns_locations()
    {
        // simulating the service's expected response
        $expectedResponse = [
            'data' => [
                ['id' => 1, 'name' => 'Catedral Metropolitana', 'slug' => 'catedral-metropolitana', 'city' => 'Brasília', 'state' => 'Distrito Federal'],
                ['id' => 2, 'name' => 'Torre de TV', 'slug' => 'torre-de-tv', 'city' => 'Brasília', 'state' => 'Distrito Federal'],
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

    /**
     * @return void
     **/
    public function test_get_by_id_method_returns_location()
    {
        $locationId = 1;

        // simulating the service's expected response
        $expectedResponse = [
            'data' => [
                'id' => $locationId,
                'name' => 'Catedral Metropolitana',
                'slug' => 'catedral-metropolitana',
                'city' => 'Brasília',
                'state' => 'Distrito Federal',
            ],
            'status_code' => 200,
        ];

        // LocationService mock
        $locationServiceMock = Mockery::mock(LocationService::class);
        $locationServiceMock->shouldReceive('getById')
            ->with($locationId)
            ->once()
            ->andReturn($expectedResponse);

        // replaces the LocationService original with the mock
        $this->app->instance(LocationService::class, $locationServiceMock);

        // GET request for the route associated with the show method
        $response = $this->getJson(route('locations.show', ['location' => $locationId]));

        // validate response
        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
    }

    /**
     * @return void
     **/
    public function test_store_method_creates_location() {
        try {
            $requestData = [
                'name' => 'Ponte JK',
                'slug' => 'new-location',
                'city' => 'Brasília',
                'state' => 'Distrito Federal',
            ];

            $expectedResponse = [
                'data' => [
                    'message' => 'Location created successfully.',
                ],
                'status_code' => 201,
            ];

            // Mock to DTO
            $locationDTOMock = Mockery::mock(CreateLocationDTO::class);
            $locationDTOMock->shouldReceive('makeFromRequest')
                ->with(Mockery::type(StoreLocationRequest::class))
                ->andReturn($locationDTOMock);

            // mock to service
            $locationServiceMock = Mockery::mock(LocationService::class);
            $locationServiceMock->shouldReceive('create')
                ->with(Mockery::on(function ($dto) use ($requestData) {
                    return $dto->name === $requestData['name']
                        && $dto->slug === $requestData['slug']
                        && $dto->city === $requestData['city']
                        && $dto->state === $requestData['state'];
                }))
                ->once()
                ->andReturn($expectedResponse);

            // replaces the LocationService original and the DTO with the mock
            $this->app->instance(LocationService::class, $locationServiceMock);
            $this->app->instance(CreateLocationDTO::class, $locationDTOMock);

            // makes a POST request to the route associated with the store method
            $response = $this->postJson(route('locations.store'), $requestData);

            // verify response
            $response->assertStatus(201);
            $response->assertJson($expectedResponse);
        } catch (\Exception $e) {
            Log::error('Error in store method test: ' . $e->getMessage());
        }
    }

    /**
     * @return void
     **/
    public function test_update_method_updates_location() {
        try {
            // request simulate
            $requestData = [
                'name' => 'Ponte JK update',
                'slug' => 'ponte-jk-update',
                'city' => 'Brasília',
                'state' => 'Distrito Federal',
            ];

            $locationId = 1;

            // response simulate
            $expectedResponse = [
                'data' => [
                    'message' => 'Location updated successfully.',
                ],
                'status_code' => 200,
            ];

            // Mock do DTO
            $updateLocationDTOMock = Mockery::mock(UpdateLocationDTO::class);
            $updateLocationDTOMock->shouldReceive('makeFromRequest')
                ->with(Mockery::type(UpdateLocationRequest::class))
                ->andReturn($updateLocationDTOMock);

            // mock service
            $locationServiceMock = Mockery::mock(LocationService::class);
            $locationServiceMock->shouldReceive('update')
                ->with(
                    Mockery::on(function ($dto) use ($requestData) {
                        return $dto->name === $requestData['name']
                            && $dto->slug === $requestData['slug']
                            && $dto->city === $requestData['city']
                            && $dto->state === $requestData['state'];
                    }),
                    $locationId
                )
                ->once()
                ->andReturn($expectedResponse);

            // replaces the original service and the DTO with the mock
            $this->app->instance(LocationService::class, $locationServiceMock);
            $this->app->instance(UpdateLocationDTO::class, $updateLocationDTOMock);

            // make a PUT request to the route associated with the update method
            $response = $this->patchJson(route('locations.update', ['location' => $locationId]), $requestData);

            // logs from debug
            Log::info('Response content: ' . $response->getContent());

            // verify response
            $response->assertStatus(200);
            $response->assertJson($expectedResponse);
        } catch (\Exception $e) {
            Log::error('Error in update method test: ' . $e->getMessage());
        }

    }

    /**
     * @return void
     **/
    public function test_delete_method_deletes_location() {
        $locationId = 1;

        $expectedResponse = [
            'message' => 'Location deleted successfully',
            'status_code' => 200,
        ];

        // mock service
        $locationServiceMock = Mockery::mock(LocationService::class);
        $locationServiceMock->shouldReceive('delete')
            ->with($locationId)
            ->once()
            ->andReturn($expectedResponse);

        // replace original service to mock
        $this->app->instance(LocationService::class, $locationServiceMock);

        // request DELETE in route
        $response = $this->deleteJson(route('locations.destroy', ['location' => $locationId]));

        // logs to debug
        Log::info('Response content: ' . $response->getContent());

        // verify response
        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
    }
}
