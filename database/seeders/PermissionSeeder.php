<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = require app_path("Roles_Permissions_Config/permissions.php");
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
