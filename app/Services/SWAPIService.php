<?php

namespace App\Services;

use App\DTOs\PersonDTO;
use App\Interfaces\StarWarsApi;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SWAPIService implements StarWarsApi
{
    private string $api;

    public function __construct()
    {
        $this->api = config('star-wars-api.url');
    }

    public function people(int $page = 1): Collection
    {
        $response = Http::get("{$this->api}/people", [
            'page' => $page
        ])->json();

        $people = $response['results'];

        return Collection::make(Arr::map($people, fn (array $person) => new PersonDTO(...$person)));
    }
}