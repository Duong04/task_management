<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use App\Services\ActionService;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    private $permissionService;
    private $actionService;
    public function __construct(PermissionService $permissionService, ActionService $actionService)
    {
        $this->permissionService = $permissionService;
        $this->actionService = $actionService;
    }
    public function index(Request $request)
    {
        $permissions = $this->permissionService->all();
        return view('pages.permission.index', compact('permissions'));
    }

    public function create()
    {
        $actions = $this->actionService->all();
        return view('pages.permission.create', compact('actions'));
    }

    public function store(PermissionRequest $request)
    {
        return $this->permissionService->create($request);
    }

    public function show($id)
    {
        $permission = $this->permissionService->findById($id);

        if (!$permission) {
            abort(404);
        }
        $actions = $this->actionService->all();
        return view('pages.permission.update', compact('permission', 'actions'));
    }

    public function update(PermissionRequest $request, $id)
    {
        return $this->permissionService->update($request, $id);
    }

    public function delete($id)
    {
        return $this->permissionService->delete($id);
    }
}
