<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
                    ->withPivot('role_id', 'permission_id')
                    ->with('actions');
    }

    public function actions()
    {
        return $this->belongsToMany(Action::class, 'role_permissions')
        ->withPivot('role_id', 'permission_id');;
    }
}
