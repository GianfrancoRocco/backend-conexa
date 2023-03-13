<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    /** @dataProvider validLoginData */
    public function test_user_can_login_and_have_access_to_auth_token(array $data): void
    {
        User::factory()->create($data);

        $response = $this->postJson(route('auth.login'), [
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'auth' => [
                    'token',
                    'type'
                ]
            ]);
    }

    public function test_login_returns_bad_request_response_if_invalid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'randompassword'
        ]);

        $response->assertBadRequest();
    }

    /** @dataProvider validRegisterData */
    public function test_user_can_register(array $data): void
    {
        $response = $this->postJson(route('auth.register'), $data);

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'auth' => [
                    'token',
                    'type'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    /** @dataProvider invalidRegisterData */
    public function test_user_can_not_register_if_invalid_data(array $data): void
    {
        $response = $this->postJson(route('auth.register'), $data);

        $response->assertUnprocessable();

        $this->assertDatabaseMissing('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public static function validLoginData(): array
    {
        return [
            ['#1' => [
                'email' => fake()->unique()->email(),
                'password' => fake()->password()
            ]],
            ['#2' => [
                'email' => fake()->unique()->email(),
                'password' => fake()->password()
            ]],
            ['#3' => [
                'email' => fake()->unique()->email(),
                'password' => fake()->password()
            ]],
        ];
    }

    public static function invalidRegisterData(): array
    {
        return [
            ['no name' => [
                'name' => null,
                'email' => fake()->unique()->email(),
                'password' => 'Acoolpassword'
            ]],
            ['invalid email' => [
                'name' => fake()->name(),
                'email' => 'rasdasdasd',
                'password' => 'Acoolpassword'
            ]],
            ['invalid password' => [
                'name' => fake()->name(),
                'email' => fake()->unique()->email(),
                'password' => fake()->password(2, 2)
            ]],
            ['empty fields' => [
                'name' => null,
                'email' => null,
                'password' => null
            ]],
        ];
    }

    public static function validRegisterData(): array
    {
        return [
            ['#1' => [
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => 'Acoolpassword'
            ]],
            ['#2' => [
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => 'Acoolpassword'
            ]],
            ['#3' => [
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => 'Acoolpassword'
            ]],
        ];
    }
}
