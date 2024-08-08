<?php

namespace App\Repositories;

use App\DTO\{CreateLocationDTO, UpdateLocationDTO};
use Illuminate\Support\Facades\Log;
use App\Models\Location;

class LocationEloquentORM implements LocationRepositoryInterface
{
    public function __construct(protected Location $city)
    {}

    public function createLocation(CreateLocationDTO $dto): array
    {
        try {
            // convert the $dto to an array
            $attributes = (array) $dto;

            $location = $this->city->create($attributes);

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
                'status_code' => 201,
            ];
        }
    }

    public function updateLocation(UpdateLocationDTO $dto): array
    {
        return [
            'status_code' => 200
        ];
    }
}
