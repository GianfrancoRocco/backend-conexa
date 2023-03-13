<?php

namespace App\DTOs;

use App\Interfaces\StarWarsApi\DTO;
use Spatie\LaravelData\Data;

class PlanetDTO extends Data implements DTO
{
    /**
     * @param string $name
     * @param string $rotation_period
     * @param string $orbital_period
     * @param string $diameter
     * @param string $climate
     * @param string $gravity
     * @param string $terrain
     * @param string $surface_water
     * @param string $population
     * @param array<string> $residents
     * @param array<string> $films
     * @param string $created
     * @param string $edited
     * @param string $url
     */
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