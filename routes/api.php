<?php

use App\Auth\AuthController;
use App\Http\Controllers\StarWarsApi\PersonController;
use App\Http\Controllers\StarWarsApi\PlanetController;
use App\Http\Controllers\StarWarsApi\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', fn (Request $request) => $request->user());

Route::controller(AuthController::class)
    ->name('auth.')
    ->group(function () {
        Route::post('/register', 'register')->name('register');

        Route::post('/login', 'login')->name('login');
    });

Route::middleware('auth:api')
    ->group(function () {
        Route::controller(PersonController::class)
            ->name('person.')
            ->prefix('people')
            ->group(function() {
                Route::get('/', 'index')->name('index');

                Route::get('/{id}', 'show')->name('show');
            });

        Route::controller(PlanetController::class)
            ->name('planet.')
            ->prefix('planets')
            ->group(function() {
                Route::get('/', 'index')->name('index');

                Route::get('/{id}', 'show')->name('show');
            });

        Route::controller(VehicleController::class)
            ->name('vehicle.')
            ->prefix('vehicles')
            ->group(function() {
                Route::get('/', 'index')->name('index');

                Route::get('/{id}', 'show')->name('show');
            });
    });