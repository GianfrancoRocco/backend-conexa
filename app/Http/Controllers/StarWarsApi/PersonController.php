<?php

namespace App\Http\Controllers\StarWarsApi;

use App\Enums\StarWarsApiResource;

class PersonController extends Controller
{
    protected StarWarsApiResource $resource = StarWarsApiResource::PERSON;
}
