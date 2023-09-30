<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{

    public function test_index(): void
    {
        // when
        $response = $this->get(route('home'));

        // then
        $response->assertStatus(200);
    }
}
