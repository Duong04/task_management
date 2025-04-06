<?php
namespace App\Services;

use App\Models\User;
use Auth;

class AuthService {
    public function login($request) {
        try {
            $user = $request->validated();

            if (Auth::attempt($user)) {
                $userData = Auth::user();

                if (!$userData->is_active) {
                    toastr()->warning("Tài khoản của bạn chưa được kích hoạt!");
                    Auth::logout();
                    return redirect()->back(); 
                }

                $request->session()->regenerate();
                toastr()->success('Đăng nhập thành công');

                return redirect()->route('dashboard');

            }

            toastr()->error('Thông tin xác thực được cung cấp không khớp với hồ sơ của chúng tôi.');
            return redirect()->back()->withInput();

        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function logout($request) {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            toastr()->info('Đăng xuất thành công');
            return redirect()->route('login');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}