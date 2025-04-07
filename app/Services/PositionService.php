<?php
namespace App\Services;

use App\Models\Position;

class PositionService {
    public function all() {
        try {
            return Position::with('users')->withCount('users')->orderByDesc('id')->get();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();
            
            Position::create($data);

            toastr()->success('Chức vụ đã được tạo thành công!');

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            $position = Position::find($id);

            return $position;
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function update($request, $id) {
        try {
            $data = $request->validated();
            
            $postion = Position::find($id);
            
            if (!$postion) {
                toastr()->error('Chức vụ không tồn tại!');
                return redirect()->back();
            }

            $postion->update($data);

            toastr()->success('Chức vụ đã được cập nhật thành công!');

            return redirect()->route('positions.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id) {
        try {
            $position = Position::with('users')->find($id);
            
            if (!$position) {
                toastr()->error('Chức vụ không tồn tại!');
                return redirect()->back();
            }

            if ($position->users_count > 0) {
                toastr()->info('Chức vụ này đang được sử dụng bởi người dùng khác!');
                return redirect()->back();
            }

            $position->delete();

            toastr()->success('Chức vụ đã được xóa thành công!');

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}