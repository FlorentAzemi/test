<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Issue;

/**
 * @extends Factory<Issue>
 */
class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(), 
            'title' => ucfirst($this->faker->sentence(4)),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['open','in_progress','closed']),
            'priority' => $this->faker->randomElement(['low','medium','high']),
            'due_date' => $this->faker->optional()->dateTimeBetween('now','+2 months'),
        ];
    }
}
