<?php 
namespace App\Services;

use App\Models\Permission;
use App\Models\PermissionAction;

class PermissionService {
    public function all() {
        try {
            return Permission::with('permissionActions')->orderByDesc('id')->get();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();

            $actions = $request->input('actions', []);
            $permission = Permission::create($data);

            foreach ($actions as $item) {
                PermissionAction::create([
                    'action_id' => $item,
                    'permission_id' => $permission->id
                ]);
            }

            toastr()->success('Quyền đã được tạo thành công!');

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            return Permission::find($id);
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function update($request, $id) {
        try {
            $data = $request->validated();

            $actions = $request->input('actions', []);
            $permission = Permission::find($id);

            if (!$permission) {
                toastr()->error('Quyền không tồn tại!');
                return redirect()->back();
            }

            $permission->update($data);

            PermissionAction::where('permission_id', $id)->delete();

            foreach ($actions as $item) {
                PermissionAction::create([
                    'action_id' => $item,
                    'permission_id' => $id
                ]);
            }

            toastr()->success('Quyền đã được cập nhật thành công!');

            return redirect()->route('permissions.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id) {
        try {
            $permission = Permission::find($id);

            if (!$permission) {
                toastr()->error('Quyền không tồn tại!');
                return redirect()->back();
            }

            $permission->delete();

            toastr()->success('Quyền đã được xóa thành công!');

            return redirect()->route('permissions.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}