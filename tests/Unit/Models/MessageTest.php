<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_one_user()
    {
        // Given
        $user = User::factory()->create();
        $room = Room::create(['name' => fake()->sentence()]);
        $message = Message::factory()->create();

        // When
        $retrievedUser = $message->user;

        // Then
        $this->assertInstanceOf(User::class, $retrievedUser);
        $this->assertEquals($user->id, $retrievedUser->id);
    }

    public function test_it_belongs_to_one_room()
    {
        // Given
        $user = User::factory()->create();
        $room = Room::create(['name' => fake()->sentence()]);
        $message = Message::factory()->create();

        // When
        $retrievedRoom = $message->room;

        // Then
        $this->assertInstanceOf(Room::class, $retrievedRoom);
        $this->assertEquals($room->id, $retrievedRoom->id);
    }
}
