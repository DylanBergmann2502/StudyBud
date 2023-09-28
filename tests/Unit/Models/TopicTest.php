<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Room;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_many_rooms()
    {
        // Given
        $topic = Topic::factory()->create();
        $room1 = Room::create(['name' => fake()->sentence(), 'topic_id' => $topic->id]);
        $room2 = Room::create(['name' => fake()->sentence(), 'topic_id' => $topic->id]);

        // When
        $rooms = $topic->rooms;

        // Then
        $this->assertCount(2, $rooms);
        $this->assertTrue($rooms->contains($room1));
        $this->assertTrue($rooms->contains($room2));
    }
}
