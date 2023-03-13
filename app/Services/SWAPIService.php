<?php

namespace App\Services;

use App\DTOs\PersonDTO;
use App\DTOs\PlanetDTO;
use App\DTOs\VehicleDTO;
use App\Exceptions\StarWarsApiException;
use App\Interfaces\StarWarsApi\Api as StarWarsApi;
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
        /** @var string $url */
        $url = config('star-wars-api.url');

        $this->api = $url;
    }

    /**
     * Handle response by checking its HTTP status code and
     * reacting accordingly.
     *
     * @param ClientResponse $response
     * @return array<string, mixed>
     */
    protected function handleResponse(ClientResponse $response): array
    {
        $status = $response->status();

        /** @var array<string, mixed> $arrayResponse */
        $arrayResponse = $response->json();

        if ($status !== Response::HTTP_OK) {
            /** @var string $message */
            $message = $arrayResponse['detail'] ?? 'An unknown error ocurred';

            throw new StarWarsApiException($message, $status);
        }

        return $arrayResponse;
    }

    /**
     * Paginate a response's results.
     *
     * @param array<string, mixed> $response
     * @param integer $page
     * @param string $dtoClass
     * @return LengthAwarePaginator<\App\Interfaces\StarWarsApi\DTO>
     */
    protected function paginateResponse(array $response, int $page, string $dtoClass): LengthAwarePaginator
    {
        /** @var array<string, mixed> $results */
        $results = $response['results'];

        /** @var integer $total */
        $total = $response['count'];

        return Collection::make(Arr::map($results, fn (array $resource) => $dtoClass::from($resource)))
            ->paginate($total, page: $page);
    }

    public function people(int $page = 1): LengthAwarePaginator
    {
        $response = $this->handleResponse(Http::get("{$this->api}/people", [
            'page' => $page
        ]));

        return $this->paginateResponse($response, $page, PersonDTO::class);
    }


    public function person(int $id): PersonDTO
    {
        $response = $this->handleResponse(Http::get("{$this->api}/people/{$id}"));

        return PersonDTO::from($response);
    }

    public function planets(int $page = 1): LengthAwarePaginator
    {
        $response = $this->handleResponse(Http::get("{$this->api}/planets", [
            'page' => $page
        ]));

        return $this->paginateResponse($response, $page, PlanetDTO::class);
    }

    public function planet(int $id): PlanetDTO
    {
        $response = $this->handleResponse(Http::get("{$this->api}/planets/{$id}"));

        return PlanetDTO::from($response);
    }

    public function vehicles(int $page = 1): LengthAwarePaginator
    {
        $response = $this->handleResponse(Http::get("{$this->api}/vehicles", [
            'page' => $page
        ]));

        return $this->paginateResponse($response, $page, VehicleDTO::class);
    }

    public function vehicle(int $id): VehicleDTO
    {
        $response = $this->handleResponse(Http::get("{$this->api}/vehicles/{$id}"));

        return VehicleDTO::from($response);
    }
}