<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Role\RoleRepositories;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role as SpatieRole;

class RoleController extends Controller {

    private $roleRepository;

    public function __construct()
    {
        $this->middleware('permission:read users')->only("index");
        $this->middleware('permission:create users')->only("create", "store");
        $this->middleware('permission:update users')->only("update");
        $this->middleware('permission:delete users')->only("delete", "restore");
        $this->roleRepository = new RoleRepositories();
    }

    public function index()
    {
        return inertia("Admin/Role/RoleIndex", [
            "roles" => Role::query()
                ->filter(request()->only("search"))
                ->orderBy(request('sort') ?? 'name', request("order") ?? "asc")
                ->paginate(request("limit") ?? 10)->withQueryString(),
            'filters' => request()->all('search', "limit", "sort", "order"),
        ]);
    }

    public function edit(Role $role)
    {

        return inertia("Admin/Role/RoleEdit", [
            "role" => $role,
            "models" => getAllModels(),
            "permissions" => $role->permissions->pluck("name"),
        ]);

    }

    public function perm(Request $request, Role $role)
    {

        $message = $this->roleRepository->assignPermissions($request, $role);

        return redirect()->back()->with("success", $message);
    }

}