<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Services\DepartmentService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Services\TaskService;
use App\Models\Department;

class ProjectController extends Controller
{
    private $projectService;
    private $userService;
    private $departmentService;

    public function __construct(ProjectService $projectService, UserService $userService, DepartmentService $departmentService)
    {
        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $type = 'user';
        $projects = $this->projectService->all($type);
        return view('pages.project.index', compact('projects', 'type'));
    }

    public function list()
    {
        $type = 'department';
        $projects = $this->projectService->all('department');
        return view('pages.project.index', compact('projects', 'type'));
    }

    public function create()
    {
        $users = $this->userService->all();
        $departments = $this->departmentService->all();

        return view('pages.project.create', compact('users', 'departments'));
    }

    public function store(ProjectRequest $request)
    {
        return $this->projectService->create($request);
    }

    public function show($id)
    {
        $project = $this->projectService->findById($id);
        $users = $this->userService->all();
        $departments = $this->departmentService->all();
        if (!$project) {
            abort(404);
        }
        return view('pages.project.show', compact('project', 'users', 'departments'));
    }

    public function edit($id)
    {
        $project = $this->projectService->findById($id);
        $users = $this->userService->all();
        $departments = $this->departmentService->all();
        if (!$project) {
            abort(404);
        }
        return view('pages.project.update', compact('project', 'users', 'departments'));
    }

    public function update(ProjectRequest $request, $id)
    {
        return $this->projectService->update($request, $id);
    }

    public function delete($id)
    {
        return $this->projectService->delete($id);
    }
}
