<?php

namespace Database\Seeders;

use App\Http\Repositories\Role\RoleRepositories;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {

    public function run()
    {
        //
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'writer']);
        (new RoleRepositories)->seedPermissions();
    }

}
