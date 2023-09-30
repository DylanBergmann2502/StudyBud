<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TopicSeeder;
use Database\Seeders\MessageSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'dylan',
            'email' => 'dylanbergmann001@gmail.com',
            'password' => bcrypt('hoanhyeuen1'),
            'bio' => fake()->text()
        ]);

        try {
            $this->call([
                UserSeeder::class,
                TopicSeeder::class,
                RoomSeeder::class,
            ]);
        } catch (\Exception $e) {
            $this->call([
                MessageSeeder::class
            ]);
        }

    }
}
