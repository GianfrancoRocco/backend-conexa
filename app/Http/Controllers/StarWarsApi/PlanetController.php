<?php

namespace App\Http\Controllers\StarWarsApi;

use App\Enums\StarWarsApiResource;

class PlanetController extends Controller
{
    protected StarWarsApiResource $resource = StarWarsApiResource::PLANET;
}
