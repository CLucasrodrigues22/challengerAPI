<?php

namespace App\Http\Controllers;

use App\DTO\CreateLocationDTO;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
        return response()->json('ok');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, int $id): JsonResponse
    {
        return response()->json('ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        return response()->json('ok');
    }
}
