<?php
namespace App\Services;

use App\Models\Role;

class RoleService {
    public function all() {
        try {
            return Role::with('users')->withCount('users')->get();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}