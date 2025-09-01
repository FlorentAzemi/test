<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Comment;
use App\Models\Tag;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::factory()->count(8)->create();

        Project::factory()->count(3)->create()->each(function ($project) use ($tags) {
            
            Issue::factory()->count(10)->create([
                'project_id' => $project->id
            ])->each(function ($issue) use ($tags) {
                
                $issue->tags()->attach(
                    $tags->random(rand(0, 3))->pluck('id')->toArray()
                );

                Comment::factory()->count(rand(0, 4))->create([
                    'issue_id' => $issue->id
                ]);
            });
        });
    }
}
