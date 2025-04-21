<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login() {
        return view('pages/auth.login');
    }

    public function handleLogin(LoginRequest $request) {
        return $this->authService->login($request);
    }

    public function profile() {
        return view('pages.auth.profile');
    }

    public function updateProfile(ProfileRequest $request) {
        return $this->authService->updateProfile($request);
    }

    public function logout(Request $request) {
        return $this->authService->logout($request);
    }

}
