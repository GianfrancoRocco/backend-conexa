<?php

namespace App\Services;

use App\DTOs\PersonDTO;
use App\DTOs\PlanetDTO;
use App\DTOs\VehicleDTO;
use App\Exceptions\StarWarsApiException;
use App\Interfaces\StarWarsApi\Api as StarWarsApi;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SWAPIServiceMock implements StarWarsApi
{
    private string $mocksFolder = 'Services/Mocks/SWAPI';

    private const NOT_FOUND = 2;

    /**
     * Get mock file.
     * 
     * @param string $fileName
     * @return array<string, mixed>
     */
    private function getMockFile(string $fileName): array
    {
        $path = app_path("{$this->mocksFolder}/{$fileName}");

        $file = file_get_contents($path);

        if (!$file) {
            throw new StarWarsApiException("Mock file '{$fileName}' not found at path: {$path}");
        }

        /** @var array<string, mixed> $decodedFile */
        $decodedFile = json_decode($file, true);
        
        return $decodedFile;
    }

    /**
     * Paginate a response's results.
     * 
     * @param array<string, mixed> $response
     * @param integer $page
     * @param string $dtoClass
     * @return LengthAwarePaginator<\App\Interfaces\StarWarsApi\DTO>
     */
    private function paginateResponse(array $response, int $page, string $dtoClass): LengthAwarePaginator
    {
        /** @var array<mixed> $results */
        $results = $response['results'];

        /** @var integer $total */
        $total = $response['count'];

        return Collection::make(Arr::map($results, fn (array $resource) => $dtoClass::from($resource)))
            ->paginate($total, page: $page);
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

        return PersonDTO::from($response);
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

        return PlanetDTO::from($response);
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

        return VehicleDTO::from($response);
    }

    private function checkIfNotFound(int $id): void
    {
        if ($id === self::NOT_FOUND) {
            throw new StarWarsApiException('Not found', Response::HTTP_NOT_FOUND);
        }
    }
}