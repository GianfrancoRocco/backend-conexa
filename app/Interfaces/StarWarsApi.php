<?php

namespace App\Interfaces;

use App\DTOs\PersonDTO;
use App\DTOs\PlanetDTO;
use Illuminate\Support\Collection;

interface StarWarsApi
{
    public function people(int $page = 1): Collection;

    public function person(int $id): PersonDTO;

    public function planets(int $page = 1): Collection;

    public function planet(int $id): PlanetDTO;

    public function vehicles(int $page = 1): Collection;
}