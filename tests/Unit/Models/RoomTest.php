<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_one_topic()
    {
        // Given
        $topic = Topic::factory()->create();
        $room = Room::create(['name' => fake()->sentence(), 'topic_id' => $topic->id]);

        // When
        $retrievedTopic = $room->topic;

        // Then
        $this->assertInstanceOf(Topic::class, $retrievedTopic);
        $this->assertEquals($topic->id, $retrievedTopic->id);
    }

    public function test_it_belongs_to_one_host()
    {
        // Given
        $host = User::factory()->create();
        $room = Room::create(['name' => fake()->sentence(), 'host_id' => $host->id]);

        // When
        $retrievedHost = $room->host;

        // Then
        $this->assertInstanceOf(User::class, $retrievedHost);
        $this->assertEquals($host->id, $retrievedHost->id);
    }

    public function test_it_has_and_belongs_to_many_participants()
    {
        // Given
        $room = Room::create(['name' => fake()->sentence()]);
        $p1 = User::factory()->create();
        $p2 = User::factory()->create();

        $room->participants()->attach([$p1->id, $p2->id]);

        // When
        $participants = $room->participants;

        // Then
        $this->assertCount(2, $participants);
        $this->assertTrue($participants->contains($p1));
        $this->assertTrue($participants->contains($p2));
    }

    public function test_it_has_many_messages()
    {
        // given
        $user = User::factory()->create();
        $room = Room::create(['name' => fake()->sentence()]);
        $message1 = Message::factory()->create();
        $message2 = Message::factory()->create();

        // when
        $messages = $room->messages;

        // then
        $this->assertCount(2, $messages);
        $this->assertTrue($messages->contains($message1));
        $this->assertTrue($messages->contains($message2));
    }
}
