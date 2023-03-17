<?php

namespace App\Providers;

use App\Interfaces\StarWarsApi\Api as StarWarsApi;
use App\Services\SWAPIService;
use App\Services\SWAPIServiceMock;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** @var array<string, string> $bindings */
    public array $bindings = [
        //
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            StarWarsApi::class,
            app()->environment('testing') ? SWAPIServiceMock::class : SWAPIService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Collection::macro('paginate', function (int $total, int $perPage = 10, int $page = 1) {
            /** @var Collection<string, mixed> $this */

            $page = $page ?: LengthAwarePaginator::resolveCurrentPage('page');

            return new LengthAwarePaginator(
                $this->all(),
                $total,
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => 'page',
                ]
            );
        });
    }
}
