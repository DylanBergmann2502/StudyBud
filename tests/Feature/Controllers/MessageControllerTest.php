<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_store_with_preexisting_participant(): void
    {
        // given
        $host = User::factory()->create();
        $topic = Topic::factory()->create();
        $room = Room::create(['name' => fake()->sentence(), 'host_id' => $host->id, 'topic_id' => $topic->id]);
        $room->participants()->attach(auth()->user());
        $participantsCountBefore = $room->participants()->count();

        $request = new StoreMessageRequest();
        $request->merge([
            'body' => 'Test Room',
        ]);

        // when
        $response = $this->post(route('rooms.messages.store', ['room' => $room->id]), $request->input());

        $participantsCountAfter = $room->participants()->count();

        // then
        $response->assertRedirect(route('rooms.show', ['room' => $room->id]));
        $this->assertEquals(1, Message::count());
        $this->assertEquals(1, $participantsCountBefore);
        $this->assertEquals(1, $participantsCountAfter);
    }

    public function test_store_nonexisting_participant(): void
    {
        // given
        $host = User::factory()->create();
        $topic = Topic::factory()->create();
        $room = Room::create(['name' => fake()->sentence(), 'host_id' => $host->id, 'topic_id' => $topic->id]);
        $participantsCountBefore = $room->participants()->count();

        $request = new StoreMessageRequest();
        $request->merge([
            'body' => 'Test Room',
        ]);

        // when
        $response = $this->post(route('rooms.messages.store', ['room' => $room->id]), $request->input());

        $participantsCountAfter = $room->participants()->count();

        // then
        $response->assertRedirect(route('rooms.show', ['room' => $room->id]));
        $this->assertEquals(1, Message::count());
        $this->assertEquals(0, $participantsCountBefore);
        $this->assertEquals(1, $participantsCountAfter);
    }
}
