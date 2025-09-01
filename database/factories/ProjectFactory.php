<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

return new class extends Factory {
    protected $model = Project::class;

    public function definition() {
        return [
            'name' => ucfirst(fake()->words(3, true)),
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('-2 months','-1 week'),
            'deadline' => fake()->dateTimeBetween('+1 week','+2 months'),
        ];
    }
};

