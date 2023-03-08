<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class PlanetDTO extends Data
{
    public function __construct(
        public string $name,
        public string $rotation_period,
        public string $orbital_period,
        public string $diameter,
        public string $climate,
        public string $gravity,
        public string $terrain,
        public string $surface_water,
        public string $population,
        public array $residents,
        public array $films,
        public string $created,
        public string $edited,
        public string $url,
    ) {
    }
}