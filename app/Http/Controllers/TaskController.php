<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Task::class);

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters('is_done')
            ->defaultSort('-created_at')
            ->allowedSorts(['title', 'is_done', 'created_at'])
            ->paginate();



        return new TaskCollection($tasks);
    }


    public function show(Request $request, Task $task)
    {
        Gate::authorize('view', $task);
        return new TaskResource($task);
    }


    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('create', Task::class);
        $validated = $request->validated();

        $task = Auth::user()->tasks()->create($validated);

        return new TaskResource($task);
    }


    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update', $task);

        $validated = $request->validated();

        $task->update($validated);

        return new TaskResource($task);
    }


    public function destroy(Request $request, Task $task)
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return response()->noContent();
    }
}
