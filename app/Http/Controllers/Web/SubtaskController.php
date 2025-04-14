<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubtaskRequest;
use Illuminate\Http\Request;
use App\Services\SubtaskService;
use App\Services\UserService;
use App\Services\TaskService;

class SubtaskController extends Controller
{
    private $subtaskService;
    private $userService;
    private $taskService;

    public function __construct(SubtaskService $subtaskService, UserService $userService, TaskService $taskService) {
        $this->subtaskService = $subtaskService;
        $this->taskService = $taskService;
        $this->userService = $userService;
    }

    public function index() {
        $subtasks = $this->subtaskService->all();

        return view('pages.subtask.index', compact('subtasks'));
    }

    public function create() {
        $users = $this->userService->getAllUser();
        $tasks = $this->taskService->all();
        return view('pages.subtask.create', compact('users', 'tasks'));
    }

    public function store(SubtaskRequest $request) {
        return $this->subtaskService->create($request);
    }

    public function delete($id) {
        return $this->subtaskService->delete($id);
    }
}
