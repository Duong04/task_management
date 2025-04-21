<?php
namespace App\Services;

use App\Models\User;
use App\Models\UserDetail;
use Auth;
use App\Services\CloundinaryService;

class AuthService {
    private $cloundinaryService;
    public function __construct(CloundinaryService $cloundinaryService) {
        $this->cloundinaryService = $cloundinaryService;
    }
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

    public function updateProfile($request) {
        try {
            $data = $request->validated();
            $user = Auth::user();

            if ($request->hasFile('avatar')) {
                $data['avatar'] = $this->cloundinaryService->upload($request->file('avatar'), 'avatar');
            }

            $user->update($data);

            if (isset($data['userDetail'])) {
                if (!$user?->userDetail) {
                    $data['userDetail']['employee_code'] = $this->generateCodeFromName();

                    $user->userDetail()->create($data['userDetail']);
                }else {
                    $user->userDetail->update($data['userDetail']);
                }
            } 

            toastr()->success('Cập nhật thông tin thành công');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    private function generateCodeFromName()
    {
        $max_code = UserDetail::max('employee_code');
        if ($max_code) {
            $lastNumber = (int) substr($max_code, 3);
            return 'MNV' . sprintf('%03d', $lastNumber + 1);
        }

        return 'MNV001';
    }
}