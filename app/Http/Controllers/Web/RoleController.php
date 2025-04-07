<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\PermissionService;
use App\Services\ActionService;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    private $roleService;
    private $permissionService;
    private $actionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService, ActionService $actionService)
    {
        $this->permissionService = $permissionService;
        $this->actionService = $actionService;
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->all();
        return view('pages.role.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionService->all();
        $actions = $this->actionService->all();
        return view('pages.role.create', compact('permissions', 'actions'));
    }

    public function store(RoleRequest $request) {
        return $this->roleService->create($request);
    }

    public function show($id) {
        $response = $this->roleService->findById($id);

        if (!$response) {
            abort(404);
        }

        $permissions = $response->permissions;
        $role = [
            'id' => $response->id,
            'name' => $response->name,
            'description' => $response?->description,
            'permissions' => $permissions->map(function ($permission) use ($response) {
                $filteredActions = $permission->actions->filter(function ($action) use ($response, $permission) {
                    return $action->pivot->role_id == $response->id && $action->pivot->permission_id == $permission->id;
                })->values();
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'description' => $permission->description,
                    'actions' => $filteredActions->map(function ($action) {
                        return [
                            'id' => $action->id,
                            'name' => $action->name,
                            'value' => $action->value, 
                        ];
                    })
                ];
            })
        ];
        $permissions = $this->permissionService->all();
        $actions = $this->actionService->all();

        return view('pages.role.update', compact('role', 'permissions', 'actions'));
    }

    public function update(RoleRequest $request, $id) {
        return $this->roleService->update($request, $id);
    }

    public function delete($id) {
        return $this->roleService->delete($id);
    }
}
