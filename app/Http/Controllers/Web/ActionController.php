<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActionRequest;
use App\Services\ActionService;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    private $actionService;
    private $permissionService;

    public function __construct(ActionService $actionService, PermissionService $permissionService) {
        $this->actionService = $actionService;
        $this->permissionService = $permissionService;
    }

    public function index() {
        $actions = $this->actionService->all();
        return view('pages.action.index', compact('actions'));
    }

    public function create() {
        $permissions = $this->permissionService->all();
        return view('pages.action.create', compact('permissions'));
    }

    public function store(ActionRequest $request) {
        return $this->actionService->create($request);
    }

    public function show($id) {
        $action = $this->actionService->findById($id);

        if (!$action) {
            abort(404);
        }

        $permissions = $this->permissionService->all();
        return view('pages.action.update', compact('action', 'permissions'));
    }

    public function update(ActionRequest $request, $id) {
        return $this->actionService->update($request, $id);
    }

    public function delete($id) {
        return $this->actionService->delete($id);
    }
}
