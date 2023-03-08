<?php

namespace App\Services;

use App\DTOs\PersonDTO;
use App\DTOs\PlanetDTO;
use App\DTOs\VehicleDTO;
use App\Exceptions\StarWarsApiException;
use App\Interfaces\StarWarsApi;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SWAPIServiceMock implements StarWarsApi
{
    private string $mocksFolder = 'Services/Mocks/SWAPI';

    private const NOT_FOUND = 2;

    private function getMockFile(string $fileName): array
    {
        $path = app_path("{$this->mocksFolder}/{$fileName}");

        $file = file_get_contents($path);

        return json_decode($file, true);
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
        $response = $this->getMockFile('people.json');

        $response['page'] = $page;

        return $this->paginateResponse($response, $page, PersonDTO::class);
    }

    public function person(int $id): PersonDTO
    {
        $this->checkIfNotFound($id);

        $response = $this->getMockFile('person.json');

        return new PersonDTO(...$response);
    }

    public function planets(int $page = 1): LengthAwarePaginator
    {
        $response = $this->getMockFile('planets.json');

        $response['page'] = $page;

        return $this->paginateResponse($response, $page, PlanetDTO::class);
    }

    public function planet(int $id): PlanetDTO
    {
        $this->checkIfNotFound($id);

        $response = $this->getMockFile('planet.json');

        return new PlanetDTO(...$response);
    }

    public function vehicles(int $page = 1): LengthAwarePaginator
    {
        $response = $this->getMockFile('vehicles.json');

        $response['page'] = $page;

        return $this->paginateResponse($response, $page, VehicleDTO::class);
    }

    public function vehicle(int $id): VehicleDTO
    {
        $this->checkIfNotFound($id);

        $response = $this->getMockFile('vehicle.json');

        return new VehicleDTO(...$response);
    }

    private function checkIfNotFound(int $id): void
    {
        if ($id === self::NOT_FOUND) {
            throw new StarWarsApiException('Not found', Response::HTTP_NOT_FOUND);
        }
    }
}