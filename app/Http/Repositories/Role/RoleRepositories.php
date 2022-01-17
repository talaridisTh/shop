<?php

namespace App\Http\Repositories\Role;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepositories implements RoleInterface {

    protected $status = ["create", "read", "update", "delete", "edit",];

    public function assignPermissions($request, $role)
    {

        $perm = $request->perm;
        if (!$role->hasPermissionTo($perm)) {
            $role->givePermissionTo($perm);

            return $perm . " permission has been added";
        } else {
            $role->revokePermissionTo($perm);

            return $perm . " permission has been removed ";
        }
    }

    public function seedPermissions()
    {
        foreach (getAllModels() as $model) {
            foreach ($this->status as $perm) {
                $value = $perm . ' ' . $model;
                if (!Permission::where('name', $value)->exists()) {
                    Permission::create(["name" => $value]);
                }
            }
            $role = Role::findByName('admin');
            $role->givePermissionTo(Permission::all());
        }
    }

}