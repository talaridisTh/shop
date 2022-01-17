<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

    use HasRoles, HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public const STATUS = [
        'inactive',
        'active',
        'trash',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ownRole()
    {
        return $this->getRoleNames()[0] ?? null;
    }

    /**
     * @return Collection
     */
    public function getPermissionArray(): Collection
    {
        return $this->getPermissionsViaRoles()->map(fn($pr) => $pr['name']);

    }

    public function password(): Attribute
    {
        return Attribute::set(fn($value) => bcrypt($value));
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'slug', $value)->withTrashed()->firstOrFail();
    }

    /**
     * @param $query
     * @param $type
     * @return void
     */
    public function changeStatus(string $type)
    {
        $this->update([
            "status" => $type,
        ]);
    }

    public function isAdmin()
    {
        return $this->ownRole() === "admin";
    }

    /**
     * @param $query
     * @param array $filters
     * @return mixed
     */
    public function scopeFilter($query, array $filters)
    {

        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        })->when($filters["status"] ?? null, function ($query, $search) {
            if ($search === Str::ucfirst(User::STATUS[2])) {
                $query->where('status', Str::lower($search))->withTrashed();
            }
            $query->where('status', Str::lower($search));
        });
    }

}
