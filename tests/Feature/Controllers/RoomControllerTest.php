<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use App\Http\Requests\StoreTopicRoomRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomControllerTest extends TestCase
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
        $response = $this->get(route('rooms.create'));

        // then
        $response->assertStatus(200);
    }

    public function test_store_with_preexisting_topic(): void
    {
        // given
        Topic::factory()->create();
        $request = new StoreTopicRoomRequest();
        $request->merge([
            'name' => 'Test Room',
            'description' => 'Test Description',
            'topic' => Topic::first()->name
        ]);

        // when
        $response = $this->post(route('rooms.store'), $request->input());

        // then
        $response->assertRedirect(route('home'));
        $this->assertEquals(1, Topic::count());
        $this->assertEquals(1, Room::count());
    }

    public function test_store_with_nonexisting_topic(): void
    {
        // given
        $topicCountBefore = Topic::count();
        $request = new StoreTopicRoomRequest();
        $request->merge([
            'name' => 'Test Room',
            'description' => 'Test Description',
            'topic' => 'Hello'
        ]);

        // when
        $response = $this->post(route('rooms.store'), $request->input());

        // then
        $response->assertRedirect(route('home'));
        $this->assertEquals(0, $topicCountBefore);
        $this->assertEquals(1, Topic::count());
        $this->assertEquals(1, Room::count());
    }
}
