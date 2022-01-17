<?php

namespace App\Http\Repositories\Role;
interface RoleInterface {

    /**
     * @param $request
     * @param $role
     * @return mixed
     */
    public function assignPermissions($request, $role);

}