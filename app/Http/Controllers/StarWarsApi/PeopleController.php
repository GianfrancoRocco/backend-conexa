<?php

namespace App\Http\Controllers\StarWarsApi;

use App\Enums\StarWarsApiResource;

class PeopleController extends Controller
{
    protected StarWarsApiResource $resource = StarWarsApiResource::PERSON;
}
