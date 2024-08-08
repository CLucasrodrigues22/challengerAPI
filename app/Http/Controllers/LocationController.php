<?php

namespace App\Http\Controllers;

use App\DTO\CreateLocationDTO;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct(protected LocationService $locationService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        //
    }

    /**
     * Sends data received via POST to the service.
     */
    public function store(StoreLocationRequest $request): \Illuminate\Http\JsonResponse
    {
        $city = $this->locationService->create(
          CreateLocationDTO::makeFromRequest($request)
        );

        return response()->json($city, $city['status_code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }
}
