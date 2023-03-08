<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class PersonDTO extends Data
{
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