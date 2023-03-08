<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface StarWarsApi
{
    public function people(int $page = 1): Collection;
}