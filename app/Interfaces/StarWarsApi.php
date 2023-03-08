<?php

namespace App\Interfaces;

use App\DTOs\PersonDTO;
use Illuminate\Support\Collection;

interface StarWarsApi
{
    public function people(int $page = 1): Collection;

    public function person(int $id): PersonDTO;

    public function planets(int $page = 1): Collection;
}