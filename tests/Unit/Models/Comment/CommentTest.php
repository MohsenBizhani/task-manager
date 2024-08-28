<?php

namespace Tests\Unit\Models\Comment;

use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_tasks_can_have_comments(): void
    {
        $task = Task::factory()->create();
        $comment = $task->comments()->make([
            'content' => 'Test Task comment',
        ]);

        $comment->user()->associate($task->creator);

        $comment->save();

        $this->assertModelExists($comment);
    }

    public function test_projects_can_have_comments(): void
    {
        $project = Project::factory()->create();
        $comment = $project->comments()->make([
            'content' => 'Test Project comment',
        ]);

        $comment->user()->associate($project->creator);

        $comment->save();

        $this->assertModelExists($comment);
    }
}
