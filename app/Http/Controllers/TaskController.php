<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Requests\StoreTaskRequet;
use App\Http\Requests\UpdateTaskRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }
    
    public function index(Request $request)
    {

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters('is_done')
            ->defaultSort('-created_at')
            ->allowedSorts(['title', 'is_done', 'created_at'])
            ->paginate();



        return new TaskCollection($tasks);
    }


    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }


    public function store(StoreTaskRequet $request)
    {
        $validated = $request->validated(); 

        $task = Auth::user()->tasks()->create($validated);

        return new TaskResource($task);
    }


    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated(); 

        $task->update($validated);

        return new TaskResource($task);
    }


    public function destroy(Request $request, Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}
