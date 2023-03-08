<?php

namespace App\Http\Controllers\StarWarsApi;

use App\Http\Controllers\Controller;
use App\Interfaces\StarWarsApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(private StarWarsApi $starWarsApi)
    {}

    public function index(Request $request): JsonResponse
    {
        $vehicles = $this->starWarsApi->vehicles($request->get('page', 1));

        return response()->json([
            'data' => $vehicles
        ]);
    }
}
