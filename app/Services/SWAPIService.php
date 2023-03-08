<?php

namespace App\Services;

use App\DTOs\PersonDTO;
use App\DTOs\PlanetDTO;
use App\DTOs\VehicleDTO;
use App\Exceptions\StarWarsApiException;
use App\Interfaces\StarWarsApi;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Response;
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
        $response = $this->processResponse(Http::get("{$this->api}/people", [
            'page' => $page
        ]));

        $people = $response['results'];

        return Collection::make(Arr::map($people, fn (array $person) => new PersonDTO(...$person)));
    }

    public function person(int $id): PersonDTO
    {
        $response = $this->processResponse(Http::get("{$this->api}/people/{$id}"));

        return new PersonDTO(...$response);
    }

    public function planets(int $page = 1): Collection
    {
        $response = $this->processResponse(Http::get("{$this->api}/planets", [
            'page' => $page
        ]));

        $planets = $response['results'];

        return Collection::make(Arr::map($planets, fn (array $planet) => new PlanetDTO(...$planet)));
    }

    public function planet(int $id): PlanetDTO
    {
        $response = $this->processResponse(Http::get("{$this->api}/planets/{$id}"));

        return new PlanetDTO(...$response);
    }

    public function vehicles(int $page = 1): Collection
    {
        $response = $this->processResponse(Http::get("{$this->api}/vehicles", [
            'page' => $page
        ]));

        $vehicles = $response['results'];

        return Collection::make(Arr::map($vehicles, fn (array $vehicle) => new VehicleDTO(...$vehicle)));
    }

    public function vehicle(int $id): VehicleDTO
    {
        $response = $this->processResponse(Http::get("{$this->api}/vehicles/{$id}"));

        return new VehicleDTO(...$response);
    }

    private function processResponse(ClientResponse $response): array
    {
        $status = $response->status();

        $response = $response->json();

        if ($status !== Response::HTTP_OK) {
            throw new StarWarsApiException($response['detail'] ?? 'An unknown error ocurred', $status);
        }

        return $response;
    }
}