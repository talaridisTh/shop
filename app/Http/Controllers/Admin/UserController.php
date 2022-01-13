<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller {

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
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
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("Admin/User/UserCreate");
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = $request->store();

        return redirect()->back()->with("success", "$user->name created");
    }

    /**
     * @param User $user
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(User $user): \Inertia\Response|\Inertia\ResponseFactory
    {

        return inertia("Admin/User/UserEdit", ["user" => UserResource::make($user)]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
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
        if ($request->password) {
            $user->update(["password" => $request->password]);
        }

        return redirect()->back()->with("success", "$user->name updated");
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->delete();
        $user->changeStatus(type: User::STATUS[2]);

        return redirect()->back()->with('success', "$user->name deleted.");
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->restore();
        $user->changeStatus(type: User::STATUS[0]);

        return redirect()->back()->with('success', "$user->name restored.");
    }

}