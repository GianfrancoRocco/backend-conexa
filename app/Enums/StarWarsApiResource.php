<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum StarWarsApiResource
{
    case PERSON;
    case PLANET;
    case VEHICLE;

    public function getAllMethodName(): string
    {
        return Str::plural(Str::lower($this->name));
    }

    public function getOneMethodName(): string
    {
        return Str::lower($this->name);
    }
}