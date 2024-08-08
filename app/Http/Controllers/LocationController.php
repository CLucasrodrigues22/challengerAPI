<?php

namespace App\Http\Controllers;

use App\DTO\{CreateLocationDTO,UpdateLocationDTO};
use App\Http\Requests\{StoreLocationRequest, UpdateLocationRequest};
use Illuminate\Http\{Request, JsonResponse};
use App\Services\LocationService;

class LocationController extends Controller
{
    public function __construct(protected LocationService $locationService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $locations = $this->locationService->get($request);
        return response()->json($locations, $locations['status_code']);
    }

    /**
     * Sends data received via POST to the service.
     */
    public function store(StoreLocationRequest $request): JsonResponse
    {
        $locations = $this->locationService->create(
          CreateLocationDTO::makeFromRequest($request)
        );

        return response()->json($locations, $locations['status_code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $location = $this->locationService->getById($id);
        return response()->json($location, $location['status_code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, int $id): JsonResponse
    {
        $location = $this->locationService->update(
            UpdateLocationDTO::makeFromRequest($request),
            $id
        );
        return response()->json($location, $location['status_code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        //
    }
}
