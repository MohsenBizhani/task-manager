<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CommentController extends Controller
{
    public function __construct()
    {
        Route::bind('task', function ($value) {
            return Task::findOrFail($value);
        });

        Route::bind('project', function ($value) {
            return Project::findOrFail($value);
        });
    }

    public function store(StoreCommentRequest $request, Project $project = null, Task $task = null)
    {
        $validated = $request->validated();
        $model = $project ?? $task;

        $comment = $model->comments()->make($validated);

        $comment->user()->associate(Auth::user());

        $comment->save();

        return new CommentResource($comment);
    }
}
