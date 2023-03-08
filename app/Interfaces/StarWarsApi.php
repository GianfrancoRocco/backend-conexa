<?php

namespace App\Interfaces;

use App\DTOs\PersonDTO;
use App\DTOs\PlanetDTO;
use App\DTOs\VehicleDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface StarWarsApi
{
    public function people(int $page = 1): LengthAwarePaginator;

    public function person(int $id): PersonDTO;

    public function planets(int $page = 1): LengthAwarePaginator;

    public function planet(int $id): PlanetDTO;

    public function vehicles(int $page = 1): LengthAwarePaginator;

    public function vehicle(int $id): VehicleDTO;
}