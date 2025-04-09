<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Services\UserService;
use App\Services\ProjectService;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    private $taskService;
    private $userService;
    private $projectService;

    public function __construct(TaskService $taskService, UserService $userService, ProjectService $projectService)
    {
        $this->userService = $userService;
        $this->projectService = $projectService;
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->all();
        return view('pages.task.index', compact('tasks'));
    }

    public function create()
    {
        $users = $this->userService->getAllUser();
        $projects = $this->projectService->all();
        return view('pages.task.create', compact('users', 'projects'));
    }

    public function store(TaskRequest $request) {
        return $this->taskService->create($request);
    }
}
