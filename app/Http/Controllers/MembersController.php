<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;
use App\Models\Project;

class MembersController extends Controller
{
    public function index(Request $request, Project $project)
    {
        $members = $project->members;

        return new UserCollection($members);
    }
}
