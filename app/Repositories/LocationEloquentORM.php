<?php

namespace App\Repositories;

use App\DTO\{CreateLocationDTO, UpdateLocationDTO};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Location;

class LocationEloquentORM implements LocationRepositoryInterface
{
    public function __construct(protected Location $location)
    {}

    public function getLocations(Request $request): array
    {
        try{
            // if there are filter parameters in the request
            $param = $request->input('name');

            if ($param) {
                $location = $this->location
                    ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($param) . '%'])
                    ->get()
                    ->toArray();

                if (empty($location)) {
                    return [
                        'message' => 'No location found with the specified name.',
                        'status_code' => 404
                    ];
                }

                return [
                    'location' => $location,
                    'status_code' => 200
                ];
            }

            // return all locations
            return [
                'location' => $this->location->all()->toArray(),
                'status_code' => 200
            ];
        } catch (\Exception $exception) {
            // creating an error log with description
            Log::channel('logExceptions')->error($exception->getMessage(), ['exception' => $exception]);
            // friendly error message
            return [
                'message' => 'An error occurred in the listing of the locations.',
                'status_code' => 500,
            ];
        }
    }

    public function getLocationById(int $id): array|null
    {
        try{
            $location = $this->location->find($id);
            if (empty($location)) {
                return [
                    'message' => 'No location found with the specified id.',
                    'status_code' => 404
                ];
            }
            return [
                'location' => $location,
                'status_code' => 200
            ];
        } catch (\Exception $exception) {
            // creating an error log with description
            Log::channel('logExceptions')->error($exception->getMessage(), ['exception' => $exception]);
            // friendly error message
            return [
                'message' => 'An error occurred in the listing of the location selected.',
                'status_code' => 500,
            ];
        }
    }

    public function createLocation(CreateLocationDTO $dto): array
    {
        try {
            // convert the $dto to an array
            $attributes = (array) $dto;

            $location = $this->location->create($attributes);

            return [
                'message' => 'Location successfully created.',
                'status_code' => 201,
            ];
        } catch (\Exception $exception) {
            // creating an error log with description
            Log::channel('logExceptions')->error($exception->getMessage(), ['exception' => $exception]);
            // friendly error message
            return [
                'message' => 'An error occurred in the creation of the location.',
                'status_code' => 500,
            ];
        }
    }

    public function updateLocation(UpdateLocationDTO $dto, int $id): array
    {
        try{
            $location = $this->location->find($id);
            if (empty($location)) {
                return [
                    'message' => 'No location found with the specified id.',
                    'status_code' => 404
                ];
            }
            $attributes = (array) $dto;
            $location->fill($attributes)->save();
            return [
                'message' => 'Location successfully updated.',
                'status_code' => 200
            ];
        } catch (\Exception $exception) {
            // creating an error log with description
            Log::channel('logExceptions')->error($exception->getMessage(), ['exception' => $exception]);
            // friendly error message
            return [
                'message' => 'An error occurred in the updated of the location.',
                'status_code' => 500,
            ];
        }
    }
}
