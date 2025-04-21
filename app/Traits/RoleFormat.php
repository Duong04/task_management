<?php

namespace App\Traits;

trait RoleFormat
{
    public function formatRole($data) {
        $permissions = $data->permissions;

        $role = [
            'id' => $data->id,
            'name' => $data->name,
            'description' => $data?->description,
            'permissions' => $permissions->map(function ($permission) use ($data) {
                $filteredActions = $permission->actions->filter(function ($action) use ($data, $permission) {
                    return $action->pivot->role_id == $data->id && $action->pivot->permission_id == $permission->id;
                })->values();
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'description' => $permission->description,
                    'actions' => $filteredActions->map(function ($action) {
                        return [
                            'id' => $action->id,
                            'name' => $action->name,
                            'value' => $action->value, 
                        ];
                    })
                ];
            })
        ];
    
        return $role;
    }
}
