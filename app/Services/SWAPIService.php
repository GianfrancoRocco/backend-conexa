<?php

namespace App\Services;

use App\DTOs\PersonDTO;
use App\DTOs\PlanetDTO;
use App\DTOs\VehicleDTO;
use App\Exceptions\StarWarsApiException;
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

    public function person(int $id): PersonDTO
    {
        $response = Http::get("{$this->api}/people/{$id}")->json();

        return new PersonDTO(...$response);
    }

    public function planets(int $page = 1): Collection
    {
        $response = Http::get("{$this->api}/planets", [
            'page' => $page
        ])->json();

        $planets = $response['results'];

        return Collection::make(Arr::map($planets, fn (array $planet) => new PlanetDTO(...$planet)));
    }

    public function planet(int $id): PlanetDTO
    {
        $response = Http::get("{$this->api}/planets/{$id}")->json();

        return new PlanetDTO(...$response);
    }

    public function vehicles(int $page = 1): Collection
    {
        $response = Http::get("{$this->api}/vehicles", [
            'page' => $page
        ])->json();

        $vehicles = $response['results'];

        return Collection::make(Arr::map($vehicles, fn (array $vehicle) => new VehicleDTO(...$vehicle)));
    }

    public function vehicle(int $id): VehicleDTO
    {
        $response = Http::get("{$this->api}/vehicles/{$id}")->json();

        if (!empty($response['detail'])) {
            throw new StarWarsApiException($response['detail']);
        }

        return new VehicleDTO(...$response);
    }
}