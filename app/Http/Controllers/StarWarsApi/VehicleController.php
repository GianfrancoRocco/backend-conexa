<?php

namespace App\Http\Controllers\StarWarsApi;

use App\Enums\StarWarsApiResource;

class VehicleController extends Controller
{
    protected StarWarsApiResource $resource = StarWarsApiResource::VEHICLE;
}
