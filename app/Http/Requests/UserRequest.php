<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\HasSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserRequest extends FormRequest {

    use HasSlug;

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => 'required| min:4|confirmed',
            "role" => "required",
        ];
    }

    /**
     * @return mixed
     */
    public function store(): mixed
    {

        return User::create([
            'name' => Str::lower($this->name),
            'slug' => $this->createSlug($this->name),
            'email' => $this->email,
            'status' => User::STATUS[$this->status],
            'password' => $this->password,
        ]);
    }

    /**
     * @param $user
     * @return mixed
     */
    public function update($user): mixed
    {

        $user = User::update([
            'name' => Str::ucfirst($this->name),
            'email' => $this->email,
            'status' => User::STATUS[$this->status],
        ]);
        if ($this->password) {
            User::update(["password" => $this->password]);
        }

        return $user;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

}