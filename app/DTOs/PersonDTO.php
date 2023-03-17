<?php

namespace App\DTOs;

use App\Interfaces\StarWarsApi\DTO;
use Spatie\LaravelData\Data;

class PersonDTO extends Data implements DTO
{
    /**
     * @param string $name
     * @param string $height
     * @param string $mass
     * @param string $hair_color
     * @param string $skin_color
     * @param string $eye_color
     * @param string $birth_year
     * @param string $gender
     * @param string $homeworld
     * @param array<string> $films
     * @param array<string> $species
     * @param array<string> $vehicles
     * @param array<string> $starships
     * @param string $created
     * @param string $edited
     * @param string $url
     */
    public function __construct(
        public string $name,
        public string $height,
        public string $mass,
        public string $hair_color,
        public string $skin_color,
        public string $eye_color,
        public string $birth_year,
        public string $gender,
        public string $homeworld,
        public array $films,
        public array $species,
        public array $vehicles,
        public array $starships,
        public string $created,
        public string $edited,
        public string $url
    ) {
    }
}