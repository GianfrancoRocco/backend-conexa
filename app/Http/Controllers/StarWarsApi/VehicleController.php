<?php

namespace App\Http\Controllers\StarWarsApi;

use App\Exceptions\StarWarsApiException;
use App\Http\Controllers\Controller;
use App\Interfaces\StarWarsApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

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

    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->starWarsApi->vehicle($id));
        } catch (Throwable $t) {
            return response()->json([
                'message' => $t instanceof StarWarsApiException 
                    ? $t->getMessage()
                    : 'An unknown error has ocurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
