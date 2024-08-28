<?php

namespace Tests\Feature\Controllers\CommentController;

use App\Models\Project;
use App\Models\Task;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommentControllerStoreTest extends TestCase
{
    public function test_can_create_comments_for_tasks(): void
    {
        $task = Task::factory()->create();
        Sanctum::actingAs($task->creator);

        $route = route('tasks.comments.store', $task);

        $response = $this->postJson($route, [
            'content' => 'test task comment',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('comments', [
            'content' => 'test task comment',
            'user_id' => $task->creator->id,
            'commentable_id' => $task->id,
            'commentable_type' => Task::class,
        ]);
    }

    public function test_can_create_comments_for_projects(): void
    {
        $project = Project::factory()->create();
        Sanctum::actingAs($project->creator);

        $route = route('projects.comments.store', $project);

        $response = $this->postJson($route, [
            'content' => 'test project comment',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('comments', [
            'content' => 'test project comment',
            'user_id' => $project->creator->id,
            'commentable_id' => $project->id,
            'commentable_type' => Project::class,
        ]);
    }
}
