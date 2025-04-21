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

    public function all() {
        $tasks = $this->taskService->all(null, true);
        return view('pages.task.index', compact('tasks'));
    }

    public function index()
    {
        $tasks = $this->taskService->all();
        return view('pages.task.index', compact('tasks'));
    }

    public function list()
    {
        $tasks = $this->taskService->all('created_by');
        return view('pages.task.list', compact('tasks'));
    }

    public function create()
    {
        $users = $this->userService->all();
        $projects = $this->projectService->all(null, true);
        return view('pages.task.create', compact('users', 'projects'));
    }

    public function store(TaskRequest $request) {
        return $this->taskService->create($request);
    }

    public function show($id) {
        $task = $this->taskService->findById($id);
        $users = $this->userService->all();
        $projects = $this->projectService->all(null, true);


        if (!$task) {
            abort(404);
        }

        return view('pages.task.show', compact('task', 'users', 'projects'));
    }

    public function edit($id) {
        $task = $this->taskService->findById($id);
        $users = $this->userService->all();
        $projects = $this->projectService->all(null, true);


        if (!$task) {
            abort(404);
        }

        return view('pages.task.update', compact('task', 'users', 'projects'));
    }

    public function update(TaskRequest $request, $id) {
        return $this->taskService->update($request, $id);
    }

    public function delete($id) {
        return $this->taskService->delete($id);
    }
}
