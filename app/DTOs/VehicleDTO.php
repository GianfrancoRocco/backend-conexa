<?php

namespace App\DTOs;

use App\Interfaces\StarWarsApi\DTO;
use Spatie\LaravelData\Data;

class VehicleDTO extends Data implements DTO
{
    /**
     * @param string $name
     * @param string $model
     * @param string $manufacturer
     * @param string $cost_in_credits
     * @param string $length
     * @param string $max_atmosphering_speed
     * @param string $crew
     * @param string $passengers
     * @param string $cargo_capacity
     * @param string $consumables
     * @param string $vehicle_class
     * @param array<string> $pilots
     * @param array<string> $films
     * @param string $created
     * @param string $edited
     * @param string $url
     */
    public function __construct(
        public string $name,
        public string $model,
        public string $manufacturer,
        public string $cost_in_credits,
        public string $length,
        public string $max_atmosphering_speed,
        public string $crew,
        public string $passengers,
        public string $cargo_capacity,
        public string $consumables,
        public string $vehicle_class,
        public array $pilots,
        public array $films,
        public string $created,
        public string $edited,
        public string $url
    ) {        
    }
}