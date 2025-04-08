<?php 
namespace App\Services;

use App\Models\User;
use App\Models\UserDetail;

class UserService {
    public function all() {
        try {
            $user = User::orderByDesc('id')->get();

            return $user;
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function getAllUser() {
        try {
            return User::orderByDesc('id')->whereHas('role', function ($query) {
                $query->where('name', '!=', 'Supper Admin');
            })->get();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();
            $user = User::create($data);

            if ($user) {
                $data['user_detail']['user_id'] = $user->id;
                $data['user_detail']['employee_code'] = $this->generateCodeFromName();
                UserDetail::create($data['user_detail']);
            }
            toastr()->success('Người dùng đã được tạo thành công!');
            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            return User::find($id);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function update($request, $id) {
        try {
            $data = $request->validated();

            if (!$data['password']) {
                unset($data['password']);
            }
            $user = User::find($id);

            if (!$user) {
                toastr()->error('Người dùng không tồn tại!');
                return redirect()->back();
            }

            $user->update($data);

            if ($user) {
                $data['user_detail']['user_id'] = $user->id;
                UserDetail::updateOrCreate(['user_id' => $user->id], $data['user_detail']);
            }

            toastr()->success('Người dùng đã được cập nhật thành công!');
            return redirect()->route('users.index');
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