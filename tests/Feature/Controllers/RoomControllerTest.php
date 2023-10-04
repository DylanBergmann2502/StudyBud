<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use App\Http\Requests\StoreTopicRoomRequest;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\UpdateTopicRoomRequest;
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

    public function test_show(): void
    {
        // given
        $host = User::factory()->create();
        $topic = Topic::factory()->create();
        $room = Room::create(['name' => fake()->sentence(), 'host_id' => $host->id, 'topic_id' => $topic->id]);

        // when
        $response = $this->get(route('rooms.show', ['room' => $room]));

        // then
        $response->assertStatus(200);
    }

    public function test_edit_different_user()
    {

        // given
        $topic = Topic::factory()->create();
        $host = User::factory()->create();
        $room = Room::create(['name' => fake()->sentence(), 'topic_id' => $topic->id, 'host_id' => $host->id]);

        // when
        $response = $this->get(route('rooms.edit', $room));

        // then
        $response->assertStatus(403);
    }

    public function test_edit_same_user()
    {
        // given
        $topic = Topic::factory()->create();
        $host = auth()->user();
        $room = Room::create(['name' => fake()->sentence(), 'topic_id' => $topic->id, 'host_id' => $host->id]);

        // when
        $response = $this->get(route('rooms.edit', $room));

        // then
        $response->assertStatus(200);
    }

    public function test_update_with_preexisting_topic()
    {
        // given
        $topic = Topic::factory()->create();
        $host = auth()->user();
        $room = Room::create(['name' => fake()->sentence(), 'topic_id' => $topic->id, 'host_id' => $host->id]);

        $request = new UpdateTopicRoomRequest();
        $request->merge([
            'name' => 'Test Room',
            'description' => 'Test Description',
            'topic' => Topic::first()->name
        ]);

        // when
        $response = $this->put(route('rooms.update', ['room' => $room->id]), $request->input());

        // then
        $response->assertRedirect(route('rooms.update', ['room' => $room->id]));
        $this->assertEquals(1, Topic::count());
    }

    public function test_update_with_nonexisting_topic()
    {
        // given
        $topic = Topic::factory()->create();
        $host = auth()->user();
        $room = Room::create(['name' => fake()->sentence(), 'topic_id' => $topic->id, 'host_id' => $host->id]);

        $request = new UpdateTopicRoomRequest();
        $request->merge([
            'name' => 'Test Room',
            'description' => 'Test Description',
            'topic' => 'Hello',
        ]);

        $topicCountBefore = Topic::count();

        // when
        $response = $this->put(route('rooms.update', ['room' => $room->id]), $request->input());

        // then
        $response->assertRedirect(route('rooms.update', ['room' => $room->id]));
        $this->assertEquals(1, $topicCountBefore);
        $this->assertEquals(2, Topic::count());
    }

    public function test_destroy()
    {
        // given
        $topic = Topic::factory()->create();
        $host = auth()->user();
        $room = Room::create(['name' => fake()->sentence(), 'topic_id' => $topic->id, 'host_id' => $host->id]);
        $roomCountBefore = Room::count();

        // when
        $response = $this->delete(route('rooms.destroy', ['room' => $room->id]));

        // then
        $response->assertRedirect(route('home'));
        $this->assertEquals(1, $roomCountBefore);
        $this->assertEquals(0, Room::count());
    }
}
