<?php 
namespace App\Services;

use App\Models\Department;

class DepartmentService {
    public function all() {
        try {
            return Department::with('users')->withCount('users')->orderByDesc('id')->get();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();
            
            Department::create($data);

            toastr()->success('Phòng ban đã được tạo thành công!');

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            $department = Department::find($id);

            return $department;
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function update($request, $id) {
        try {
            $data = $request->validated();
            
            $department = Department::find($id);
            
            if (!$department) {
                toastr()->error('Phòng ban không tồn tại!');
                return redirect()->back();
            }

            $department->update($data);

            toastr()->success('Phòng ban đã được cập nhật thành công!');

            return redirect()->route('departments.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id) {
        try {
            $department = Department::with('users')->find($id);
            
            if (!$department) {
                toastr()->error('Phòng ban không tồn tại!');
                return redirect()->back();
            }

            if ($department->users_count > 0) {
                toastr()->info('Phòng ban này đang được sử dụng bởi người dùng khác!');
                return redirect()->back();
            }

            $department->delete();

            toastr()->success('Phòng ban đã được xóa thành công!');

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}