<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class VehicleDTO extends Data
{
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