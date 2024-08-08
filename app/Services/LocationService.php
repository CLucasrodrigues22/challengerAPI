<?php

namespace App\Services;

use App\DTO\CreateLocationDTO;
use App\Repositories\LocationRepositoryInterface;

class LocationService
{
    public function __construct(protected LocationRepositoryInterface $locationsRepository)
    {}

    public function create(CreateLocationDTO $dto): array
    {
        // create a new city using a city repository and return to controller
        return $this->locationsRepository->createLocation($dto);
    }
}
