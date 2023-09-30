<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreSessionRequest;
use App\Http\Controllers\SessionController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create(): void
    {
        // when
        $response = $this->get(route('login'));

        // then
        $response->assertStatus(200);
    }

    public function test_store_with_valid_credentials(): void
    {
        // Given
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $request = new StoreSessionRequest();
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // When
        $response = $this->post(route('authenticate'), $request->input());

        // Then
        $this->assertTrue(Auth::check());
        $this->assertNotNull(Session::getId());
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('message', 'You are now logged in');
    }

    public function test_store_with_invalid_credentials(): void {
        // Given a StoreSessionRequest with invalid credentials
        $request = $this->createRequest(['password' => 'incorrect_password']);

        // When the store request is made
        $response = $this->post(route('authenticate'), $request->input());

        // Then the user should not be authenticated
        $this->assertFalse(Auth::check());
        $response->assertRedirect();
        $response->assertSessionHasErrors('email', 'Invalid Credentials');
    }

    private function createRequest(array $data = [])
    {
        $request = new StoreSessionRequest();
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        return $request;
    }

    public function test_destroy(): void {
        // Given
        $user = User::factory()->create();
        Auth::login($user);

        $request = Request::create('/logout', 'POST');
        $request->setLaravelSession(app('session.store'));

        // When
        $response = $this->app->make(SessionController::class)->destroy($request);

        // Then the user should be logged out
        $this->assertFalse(Auth::check());

        // Then the session should be invalidated
        $this->assertFalse(Session::has(Auth::guard()->getName()));

        // Then the session token should be regenerated
        $this->assertNotNull($request->session()->token());

        // Then the response should redirect to the home route
        // $response->assertRedirect($uri = route('home'));

        // Then the response should contain the expected message
        // $response->assertSessionHas('message', 'You have been logged out successfully');
    }
}
