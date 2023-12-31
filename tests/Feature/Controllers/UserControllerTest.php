<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_create(): void
    {
        // when
        $response = $this->get(route('register'));

        // then
        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        // Given
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // When
        $response = $this->post(route('users.store'), $userData);

        // Then
        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertEquals(2, User::count());
    }

    public function test_show(): void
    {
        // given
        $user = User::factory()->create();

        // when
        $response = $this->get(route('users.show', ['user' => $user]));

        // then
        $response->assertStatus(200);
    }

    public function test_edit_same_user(): void
    {
        // given
        $user = auth()->user();

        // when
        $response = $this->get(route('users.edit', ['user' => $user]));

        // then
        $response->assertStatus(200);
    }

    public function test_edit_different_user(): void
    {
        // given
        $differentUser = User::factory()->create();

        // when
        $response = $this->get(route('users.edit', ['user' => $differentUser]));

        // then
        $response->assertStatus(403);
    }

    public function test_update_with_nonexisting_topic()
    {
        // given
        $user = auth()->user();

        $request = new UpdateUserRequest();
        $request->merge([
            'name' => 'Test Username',
            'bio' => 'Test Bio',
        ]);

        // when
        $response = $this->put(route('users.update', $user), $request->input());

        // then
        $response->assertRedirect(route('users.show', $user));
    }
}
