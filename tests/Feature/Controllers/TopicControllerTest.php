<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicControllerTest extends TestCase
{
    public function test_index(): void
    {
        // when
        $response = $this->get(route('topic.index'));

        // then
        $response->assertStatus(200);
    }
}
