<?php

namespace App\Repositories;

use App\DTO\{CreateLocationDTO, UpdateLocationDTO};

interface LocationRepositoryInterface
{
    public function createLocation(CreateLocationDTO $dto): array;
    public function updateLocation(UpdateLocationDTO $dto): array;
}
