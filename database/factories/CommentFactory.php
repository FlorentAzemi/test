<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;
use App\Models\Issue;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'issue_id' => Issue::factory(),   
            'author_name' => $this->faker->name(),
            'body' => $this->faker->sentences(2, true),
        ];
    }
}
