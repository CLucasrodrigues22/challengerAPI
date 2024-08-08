<?php

namespace App\Repositories;

use App\DTO\{CreateLocationDTO, UpdateLocationDTO};

interface LocationRepositoryInterface
{
    public function createCity(CreateLocationDTO $dto): array;
    public function updateCity(UpdateLocationDTO $dto): array;
}
