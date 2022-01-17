<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Response;
use Inertia\ResponseFactory;
use Spatie\Permission\Models\Role;

class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('permission:read users')->only("index");
        $this->middleware('permission:create users')->only("create", "store");
        $this->middleware('permission:update users')->only("update");
        $this->middleware('permission:delete users')->only("delete", "restore");
    }

    /**
     * @return Response|ResponseFactory
     */
    public function index(): Response|ResponseFactory
    {

        return inertia("Admin/User/UserIndex", [
            "users" => UserResource::collection(User::query()
                ->filter(request()->only("search", "status"))
                ->orderBy(request('sort') ?? 'name', request("order") ?? "asc")
                ->paginate(request("limit") ?? 10)->withQueryString()),
            'filters' => request()->all('search', 'role', "status", "limit", "sort", "order"),
        ]);
    }

    /**
     * @return Response|ResponseFactory
     */
    public function create(): Response|ResponseFactory
    {
        return inertia("Admin/User/UserCreate", [
            "roles" => Role::pluck("name"),
        ]);
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $user = $request->store();

        return redirect()->back()->with("success", "$user->name created");
    }

    /**
     * @param User $user
     * @return Response|ResponseFactory
     */
    public function edit(User $user): Response|ResponseFactory
    {

        return inertia("Admin/User/UserEdit", [
            "user" => UserResource::make($user),
            "roles" => Role::pluck("name"),
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {

        $this->validate($request, [
            "name" => "required",
            "email" => "required", Rule::unique('users')->ignore($user->id),
        ]);
        $user->update([
            'name' => Str::lower($request->name),
            'email' => $request->email,
            'status' => User::STATUS[$request->status],
        ]);
        $user->syncRoles($request->role);
        if ($request->password) {
            $user->update(["password" => $request->password]);
        }

        return redirect()->back()->with("success", "$user->name updated");
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        $user->changeStatus(type: User::STATUS[2]);

        return redirect()->back()->with('success', "$user->name deleted.");
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function restore(User $user): RedirectResponse
    {
        $user->restore();
        $user->changeStatus(type: User::STATUS[0]);

        return redirect()->back()->with('success', "$user->name restored.");
    }

}