<?php

namespace Tests\Feature\StarWarsApi;

use App\Interfaces\StarWarsApi;
use App\Models\User;
use App\Services\SWAPIServiceMock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanetControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->instance(StarWarsApi::class, new SWAPIServiceMock);
    }

    public function test_a_collection_of_planets_can_be_fetched(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson(route('planet.index'));

        $response->assertSuccessful();
    }

    public function test_can_switch_between_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson(route('planet.index', [
            'page' => 2
        ]));

        $response->assertSuccessful();

        $response = $this->getJson(route('planet.index', [
            'page' => 3
        ]));

        $response->assertSuccessful();
    }

    public function test_one_planet_can_be_fetched(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson(route('planet.show', [1]));

        $response->assertSuccessful();
    }

    public function test_not_found_response_if_planet_does_not_exist(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson(route('planet.show', [2]));

        $response->assertNotFound();
    }

    public function test_unauthorized_response_if_not_authenticated(): void
    {
        $response = $this->getJson(route('planet.index'));

        $response->assertUnauthorized();
    }
}
