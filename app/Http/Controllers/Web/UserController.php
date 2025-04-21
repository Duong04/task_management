<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RoleService;
use App\Services\PositionService;
use App\Services\DepartmentService;
use App\Services\TaskService;

class UserController extends Controller
{
    private $userService;
    private $roleService;
    private $positionService;
    private $departmentService;
    private $taskService;

    public function __construct(UserService $userService, RoleService $roleService, PositionService $positionService, DepartmentService $departmentService, TaskService $taskService) {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->positionService = $positionService;
        $this->departmentService = $departmentService;
        $this->taskService = $taskService;
    }

    public function index() {
        $users = $this->userService->all();
        return view('pages.user.index', compact('users'));
    }

    public function create() {
        $roles = $this->roleService->all();
        $positions = $this->positionService->all();
        $departments = $this->departmentService->all();
        return view('pages.user.create', compact('roles', 'positions', 'departments'));
    }

    public function store(UserRequest $request) {
        return $this->userService->create($request);
    }

    public function edit($id) {
        $user = $this->userService->findById($id);
        $roles = $this->roleService->all();
        $positions = $this->positionService->all();
        $departments = $this->departmentService->all();

        return view('pages.user.update', compact('user', 'roles', 'positions', 'departments'));
    }

    public function show($id) {
        $user = $this->userService->findById($id);
        $task_status_completed = $this->taskService->statsByStatus('completed', false, $id);
        $task_status_not_started = $this->taskService->statsByStatus('not_started', false, $id);
        $task_status_in_progress = $this->taskService->statsByStatus('in_progress', false, $id);
        $task_overdue = $this->taskService->statsByStatus(null, true, $id);

        return view('pages.user.show', compact('user', 'task_status_completed', 'task_status_not_started', 'task_status_in_progress', 'task_overdue'));
    }

    public function update(UserRequest $request, $id) {
        return $this->userService->update($request, $id);
    }
}
