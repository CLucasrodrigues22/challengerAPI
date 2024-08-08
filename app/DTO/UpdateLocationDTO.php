<?php

namespace App\DTO;

use App\Http\Requests\UpdateLocationRequest;

class UpdateLocationDTO
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $city,
        public string $state
    )
    {}

    public static function makeFromRequest(UpdateLocationRequest $request): self
    {
        // encapsulating the data needed to update a city
        return new self(
            $request->name,
            $request->slug,
            $request->city,
            $request->state
        );
    }
}
