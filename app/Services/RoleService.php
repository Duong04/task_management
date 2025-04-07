<?php
namespace App\Services;

use App\Models\Role;
use App\Models\RolePermission;

class RoleService {
    public function all() {
        try {
            return Role::with('users')->withCount('users')->orderByDesc('id')->get();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();
            
            $data = $request->input(); 
            
            $role = Role::create($data);
    
            $actions = $request->input('actions') ? $request->input('actions') : '';
    
            if (!empty($actions)) {
                foreach ($actions as $permission_id => $action) {
                    foreach ($action as $action_id) {
                        RolePermission::create([
                            'permission_id' => $permission_id,
                            'role_id' => $role->id,
                            'action_id' => $action_id
                        ]);
                    }
                }
            }

            toastr()->success('Vai trò đã được tạo thành công!');

            return redirect()->back();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            $role = Role::with('permissions.actions')->find($id);

            return $role;
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function update($request, $id) {
        try {
            $data = $request->validated();
            
            $data = $request->input(); 
            
            $role = Role::find($id);
    
            if (!$role) {
                toastr()->error('Vai trò không tồn tại!');
                return redirect()->back();
            }
    
            $role->update($data);
    
            RolePermission::where('role_id', $id)->delete();
    
            $actions = $request->input('actions') ? $request->input('actions') : '';
    
            if (!empty($actions)) {
                foreach ($actions as $permission_id => $action) {
                    foreach ($action as $action_id) {
                        RolePermission::create([
                            'permission_id' => $permission_id,
                            'role_id' => $role->id,
                            'action_id' => $action_id
                        ]);
                    }
                }
            }

            toastr()->success('Vai trò đã được cập nhật thành công!');

            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id) {
        try {
            $role = Role::withCount('users')->find($id);
    
            if (!$role) {
                toastr()->error('Vai trò không tồn tại!');
                return redirect()->back();
            }

            if ($role->users_count > 0) {
                toastr()->info('Vai trò này đang được sử dụng bởi người dùng khác!');
                return redirect()->back();
            }
    
            $role->delete();
    
            toastr()->success('Vai trò đã được xóa thành công!');
    
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
}