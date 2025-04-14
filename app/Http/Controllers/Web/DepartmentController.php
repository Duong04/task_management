<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DepartmentService;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    private $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $departments = $this->departmentService->all();
        return view('pages.department.index', compact('departments'));
    }

    public function create()
    {
        return view('pages.department.create');
    }

    public function store(DepartmentRequest $request) {
        return $this->departmentService->create($request);
    }

    public function show($id) {
        $department = $this->departmentService->findById($id);

        if (!$department) {
            abort(404);
        }

        return view('pages.department.update', compact('department'));
    }

    public function update(DepartmentRequest $request, $id) {
        return $this->departmentService->update($request, $id);
    }
    public function delete($id) {
        return $this->departmentService->delete($id);
    }
}
