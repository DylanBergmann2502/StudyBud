<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_many_hosted_rooms()
    {
        // given
        $user = User::factory()->create();

        $room1 = Room::create(['name' => fake()->sentence(), 'host_id' => $user->id]);
        $room2 = Room::create(['name' => fake()->sentence(), 'host_id' => $user->id]);

        // when
        $hostedRooms = $user->hosted_rooms;

        // then
        $this->assertCount(2, $hostedRooms);
        $this->assertTrue($hostedRooms->contains($room1));
        $this->assertTrue($hostedRooms->contains($room2));
    }

    public function test_it_has_and_belongs_to_many_participated_rooms()
    {
        // Given
        $user = User::factory()->create();
        $room1 = Room::create(['name' => fake()->sentence(), 'host_id' => $user->id]);
        $room2 = Room::create(['name' => fake()->sentence(), 'host_id' => $user->id]);

        $user->participated_rooms()->attach([$room1->id, $room2->id]);

        // When
        $participatedRooms = $user->participated_rooms;

        // Then
        $this->assertCount(2, $participatedRooms);
        $this->assertTrue($participatedRooms->contains($room1));
        $this->assertTrue($participatedRooms->contains($room2));
    }

    public function test_it_has_many_messages()
    {
        // given
        $user = User::factory()->create();
        $room = Room::create(['name' => fake()->sentence()]);
        $message1 = Message::factory()->create();
        $message2 = Message::factory()->create();

        // when
        $messages = $user->messages;

        // then
        $this->assertCount(2, $messages);
        $this->assertTrue($messages->contains($message1));
        $this->assertTrue($messages->contains($message2));
    }
}
