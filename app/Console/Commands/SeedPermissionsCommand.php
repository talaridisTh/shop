<?php

namespace App\Console\Commands;

use App\Http\Repositories\Role\RoleRepositories;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedPermissionsCommand extends Command {

    protected $signature = 'permission:seed';

    protected $description = 'Update permission';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        (new RoleRepositories)->seedPermissions();
    }

}
