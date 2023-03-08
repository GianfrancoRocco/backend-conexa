<?php

namespace App\Services;

use App\DTOs\PersonDTO;
use App\DTOs\PlanetDTO;
use App\DTOs\VehicleDTO;
use App\Exceptions\StarWarsApiException;
use App\Interfaces\StarWarsApi;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
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

    private function paginateResponse(array $response, int $page, string $dtoClass): LengthAwarePaginator
    {
        return Collection::make(
                Arr::map($response['results'], fn (array $resource) => new $dtoClass(...$resource))
            )
            ->paginate($response['count'], page: $page);
    }

    public function people(int $page = 1): LengthAwarePaginator
    {
        $response = $this->processResponse(Http::get("{$this->api}/people", [
            'page' => $page
        ]));

        return $this->paginateResponse($response, $page, PersonDTO::class);
    }

    public function person(int $id): PersonDTO
    {
        $response = $this->processResponse(Http::get("{$this->api}/people/{$id}"));

        return new PersonDTO(...$response);
    }

    public function planets(int $page = 1): LengthAwarePaginator
    {
        $response = $this->processResponse(Http::get("{$this->api}/planets", [
            'page' => $page
        ]));

        return $this->paginateResponse($response, $page, PlanetDTO::class);
    }

    public function planet(int $id): PlanetDTO
    {
        $response = $this->processResponse(Http::get("{$this->api}/planets/{$id}"));

        return new PlanetDTO(...$response);
    }

    public function vehicles(int $page = 1): LengthAwarePaginator
    {
        $response = $this->processResponse(Http::get("{$this->api}/vehicles", [
            'page' => $page
        ]));

        return $this->paginateResponse($response, $page, VehicleDTO::class);
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