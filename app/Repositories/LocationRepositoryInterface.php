<?php

namespace App\Repositories;

use App\DTO\{CreateLocationDTO, UpdateLocationDTO};
use Illuminate\Http\Request;

interface LocationRepositoryInterface
{
    public function getLocations(Request $request): array;
    public function getLocationById(int $id): array|null;
    public function createLocation(CreateLocationDTO $dto): array;
    public function updateLocation(UpdateLocationDTO $dto, int $id): array;
}
