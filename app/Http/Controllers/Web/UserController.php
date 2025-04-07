<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RoleService;
use App\Services\PositionService;

class UserController extends Controller
{
    private $userService;
    private $roleService;
    private $positionService;

    public function __construct(UserService $userService, RoleService $roleService, PositionService $positionService) {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->positionService = $positionService;
    }

    public function index() {
        $users = $this->userService->all();
        return view('pages.user.index', compact('users'));
    }

    public function create() {
        $roles = $this->roleService->all();
        $positions = $this->positionService->all();
        return view('pages.user.create', compact('roles', 'positions'));
    }

    public function store(UserRequest $request) {
        return $this->userService->create($request);
    }

    public function show($id) {
        $user = $this->userService->findById($id);
        $roles = $this->roleService->all();
        $positions = $this->positionService->all();
        return view('pages.user.update', compact('user', 'roles', 'positions'));
    }

    public function update(UserRequest $request, $id) {
        return $this->userService->update($request, $id);
    }
}
