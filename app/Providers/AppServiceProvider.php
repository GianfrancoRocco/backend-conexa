<?php

namespace App\Providers;

use App\Interfaces\StarWarsApi;
use App\Services\SWAPIService;
use App\Services\SWAPIServiceMock;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        StarWarsApi::class => SWAPIService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Collection::macro('paginate', function (int $total, int $perPage = 10, int $page = 1) {
            /** @var Collection $this */
            $this;

            $page = $page ?: LengthAwarePaginator::resolveCurrentPage('page');

            return new LengthAwarePaginator(
                $this->all(),
                $total,
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => 'page',
                    'lastPage' => 9
                ]
            );
        });
    }
}
