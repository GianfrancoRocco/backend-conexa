<?php

namespace Tests\Feature\StarWarsApi;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_collection_of_people_can_be_fetched(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson(route('person.index'));

        $response->assertSuccessful();
    }

    public function test_can_switch_between_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson(route('person.index', [
            'page' => 2
        ]));

        $response->assertSuccessful();

        $response = $this->getJson(route('person.index', [
            'page' => 3
        ]));

        $response->assertSuccessful();
    }

    public function test_one_person_can_be_fetched(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson(route('person.show', [1]));

        $response->assertSuccessful();
    }

    public function test_not_found_response_if_person_does_not_exist(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson(route('person.show', [232323321]));

        $response->assertNotFound();
    }

    public function test_unauthorized_response_if_not_authenticated(): void
    {
        $response = $this->getJson(route('person.index'));

        $response->assertUnauthorized();
    }
}
