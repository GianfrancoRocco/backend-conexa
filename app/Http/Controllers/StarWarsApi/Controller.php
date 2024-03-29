<?php

namespace App\Http\Controllers\StarWarsApi;

use App\Enums\StarWarsApiResource;
use App\Exceptions\StarWarsApiException;
use App\Http\Controllers\Controller as BaseController;
use App\Interfaces\StarWarsApi\Api as StarWarsApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Throwable;

class Controller extends BaseController
{
    protected StarWarsApiResource $resource;

    public function __construct(protected StarWarsApi $starWarsApi)
    {}

    /**
     * Get a collection of the specified resource.
     *
     * @param Request $request
     * @return JsonResponse|LengthAwarePaginator<\App\Interfaces\StarWarsApi\DTO>
     */
    public function index(Request $request): JsonResponse|LengthAwarePaginator
    {
        return $this->handleApiCall(fn () => 
            $this->starWarsApi->{$this->resource->getAllMethodName()}($request->get('page', 1))
        );
    }

    /**
     * Get single resource by its ID.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return $this->handleApiCall(fn () => 
            $this->starWarsApi->{$this->resource->getOneMethodName()}($id)
        );
    }

    /**
     * @param callable $callback
     * @return JsonResponse
     */
    private function handleApiCall(callable $callback): JsonResponse
    {
        $message = 'An unknown error has ocurred';
        $status = Response::HTTP_INTERNAL_SERVER_ERROR;

        try {
            return response()->json($callback());
        } catch (StarWarsApiException $ex) {
            $message = $ex->getMessage();
            $status = $ex->getCode();
        } catch (Throwable $t) {
            Log::debug($t->getMessage());
        }

        return response()->json([
            'message' => $message
        ], $status);
    }
}
