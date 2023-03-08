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
    {}

    public function index(Request $request): JsonResponse
    {
        return $this->handleApiCall(function () use ($request) {
            $data = $this->starWarsApi->{$this->resource->getAllMethodName()}($request->get('page', 1));
    
            return response()->json([
                'data' => $data
            ]);
        });
    }

    public function show(int $id): JsonResponse
    {
        return $this->handleApiCall(fn () => response()->json($this->starWarsApi->{$this->resource->getOneMethodName()}($id)));
    }

    private function handleApiCall(callable $callback): JsonResponse
    {
        $message = 'An unknown error has ocurred';
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        try {
            return $callback();
        } catch (StarWarsApiException $ex) {
            $message = $ex->getMessage();
            $status = $ex->getCode();
        } catch (Throwable $t) {}

        return response()->json([
            'message' => $message
        ], $status);
    }
}
