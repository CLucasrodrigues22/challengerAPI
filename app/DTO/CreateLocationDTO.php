<?php

namespace App\DTO;

use App\Http\Requests\StoreLocationRequest;

class CreateLocationDTO
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $city,
        public string $state
    )
    {}

    public static function makeFromRequest(StoreLocationRequest $request): self
    {
        // encapsulating the data needed to create a city
        return new self(
            $request->name,
            $request->slug,
            $request->city,
            $request->state
        );
    }
}
