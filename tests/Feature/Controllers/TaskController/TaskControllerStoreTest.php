<?php

namespace Tests\Feature\Controllers\TaskController;

use App\Models\Project;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskControllerStoreTest extends TestCase
{
    public function test_can_create_task(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $route = route('tasks.store');
        $response = $this->postJson($route, [
            'title' => 'Test Task',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'creator_id' => $user->id,
        ]);
    }

    public function test_title_is_required(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $route = route('tasks.store');
        $response = $this->postJson($route, []);

        $response->assertJsonValidationErrors([
            'title' => 'required',
        ]);
    }

    public function test_cannot_create_tasks_for_unknown_projects(): void
    {
        $projct = Project::factory()->create();
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $route = route('tasks.store');
        $response = $this->postJson($route, [
            'title' => 'Test Task',
            'project_id' => $projct->id,
        ]);

        $response->assertJsonValidationErrors([
            'project_id' => 'in',
        ]);
    }
}
