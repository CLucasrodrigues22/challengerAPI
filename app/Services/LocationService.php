<?php

namespace App\Services;

use App\DTO\CreateLocationDTO;
use App\DTO\UpdateLocationDTO;
use App\Repositories\LocationRepositoryInterface;
use Illuminate\Http\Request;

class LocationService
{
    public function __construct(protected LocationRepositoryInterface $locationsRepository)
    {}

    public function get(Request $request = null): array
    {
        return $this->locationsRepository->getLocations($request);
    }
    public function getById(int $id): array
    {
        return $this->locationsRepository->getLocationById($id);
    }
    public function create(CreateLocationDTO $dto): array
    {
        // create a new city using a city repository and return to controller
        return $this->locationsRepository->createLocation($dto);
    }

    public function update(UpdateLocationDTO $dto, int $id): array
    {
        return $this->locationsRepository->updateLocation($dto, $id);
    }

    public function delete(int $id): array
    {
        return $this->locationsRepository->deleteLocation($id);
    }
}
