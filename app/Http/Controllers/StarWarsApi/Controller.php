<?php

namespace App\Http\Controllers\StarWarsApi;

use App\Enums\StarWarsApiResource;
use App\Exceptions\StarWarsApiException;
use App\Http\Controllers\Controller as BaseController;
use App\Interfaces\StarWarsApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Controller extends BaseController
{
    protected StarWarsApiResource $resource;

    public function __construct(protected StarWarsApi $starWarsApi)
    { }

    public function index(Request $request): JsonResponse
    {
        $data = $this->starWarsApi->{$this->resource->getAllMethodName()}($request->get('page', 1));

        return response()->json([
            'data' => $data
        ]);
    }

    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->starWarsApi->{$this->resource->getOneMethodName()}($id));
        } catch (Throwable $t) {
            return response()->json([
                'message' => $t instanceof StarWarsApiException
                    ? $t->getMessage()
                    : 'An unknown error has ocurred'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
