<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Topic::factory()->create([
            'name' => 'Django'
        ]);
        Topic::factory()->create([
            'name' => 'Ruby On Rails'
        ]);
        Topic::factory()->create([
            'name' => 'Laravel'
        ]);
        Topic::factory()->create([
            'name' => 'ExpressJS'
        ]);
        Topic::factory()->create([
            'name' => 'Spring Boot'
        ]);
        Topic::factory()->create([
            'name' => 'ASP.NET'
        ]);
    }
}
