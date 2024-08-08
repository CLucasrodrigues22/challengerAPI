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
     * @OA\Get(
     *     tags={"locations"},
     *     path="/api/v1/locations",
     *     summary="Get all locations",
     *     description="Gets a list of all locations and allows filtering with the name parameter",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Filter locations by name",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of all locations"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No location found with the specified name."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred in the listing of the locations."
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $locations = $this->locationService->get($request);
        return response()->json($locations, $locations['status_code']);
    }

    /**
     * @OA\Get(
     *     tags={"locations"},
     *     path="/api/v1/locations/{id}",
     *     summary="Get a location by id",
     *     description="Get a location by id parameter",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the location",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location info list"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No location found with the specified id."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred in the listing of the locations."
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $location = $this->locationService->getById($id);
        return response()->json($location, $location['status_code']);
    }

    /**
     * @OA\Post(
     *     tags={"locations"},
     *     path="/v1/location",
     *     summary="Create location",
     *     description="Create a new location",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Location Name",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="slug",
     *         in="query",
     *         description="Location slug",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="Location city",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="state",
     *         in="query",
     *         description="Location state",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Location successfully created."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The slug has already been taken or param is required"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred in the creation of the location."
     *     ),
     * )
     */
    public function store(StoreLocationRequest $request): JsonResponse
    {
        $locations = $this->locationService->create(
          CreateLocationDTO::makeFromRequest($request)
        );

        return response()->json($locations, $locations['status_code']);
    }

    /**
     * @OA\Put(
     *     tags={"locations"},
     *     path="/v1/location/{id}",
     *     summary="Update location by id",
     *     description="Update a location by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the location",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Location Name",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="slug",
     *         in="query",
     *         description="Location slug",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="city",
     *         in="query",
     *         description="Location city",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="state",
     *         in="query",
     *         description="Location state",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location successfully updated."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No location found with the specified id."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The slug has already been taken or param is required"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred in the update of the location."
     *     )
     * )
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
     * @OA\Delete(
     *      tags={"locations"},
     *      path="/api/v1/locations/{id}",
     *      summary="Delete a location by id",
     *      description="Delete a location by id parameter",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the location",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Location successfully deleted."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No location found with the specified id."
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="An error occurred in the deleted of the location."
     *       ),
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $location = $this->locationService->delete($id);
        return response()->json($location, $location['status_code']);
    }
}
