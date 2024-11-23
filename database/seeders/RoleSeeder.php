<?php

namespace Database\Seeders;

use App\HelpersClasses\Permissions;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permissions::addRolesAndUsersInSeeder();
    }
}
