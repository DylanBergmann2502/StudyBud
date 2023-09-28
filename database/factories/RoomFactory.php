<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $host = User::first();
        $topic = Topic::first();
        $participants = User::factory()->count(5)->create();

        $room = Room::create([
            'name' => 'Backend Development',
            'description' => fake()->text(),
            'topic_id' => $topic->id,
            'host_id' => $host->id
        ]);

        $room->participants()->attach($participants);

        return $room->toArray();
    }
}
