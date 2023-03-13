<?php

namespace App\Interfaces\StarWarsApi;

use Illuminate\Pagination\LengthAwarePaginator;

interface Api
{
    /**
     * Get a collection of people.
     *
     * @param integer $page
     * @return LengthAwarePaginator<\App\Interfaces\StarWarsApi\DTO>
     */
    public function people(int $page = 1): LengthAwarePaginator;

    /**
     * Get a single person by its ID.
     * 
     * @param integer $id
     * @return \App\Interfaces\StarWarsApi\DTO
     */
    public function person(int $id): DTO;

    /**
     * Get a collection of planets.
     *
     * @param integer $page
     * @return LengthAwarePaginator<\App\Interfaces\StarWarsApi\DTO>
     */
    public function planets(int $page = 1): LengthAwarePaginator;

    /**
     * Get a single planet by its ID.
     * 
     * @param integer $id
     * @return \App\Interfaces\StarWarsApi\DTO
     */
    public function planet(int $id): DTO;

    /**
     * Get a collection of vehicles.
     *
     * @param integer $page
     * @return LengthAwarePaginator<\App\Interfaces\StarWarsApi\DTO>
     */
    public function vehicles(int $page = 1): LengthAwarePaginator;

    /**
     * Get a single vehicle by its ID.
     * 
     * @param integer $id
     * @return \App\Interfaces\StarWarsApi\DTO
     */
    public function vehicle(int $id): DTO;
}