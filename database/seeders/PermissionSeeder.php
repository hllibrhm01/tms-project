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
        Permission::addPermission('CMS', 'web');
        Permission::addPermission('TMS', 'web');
        Permission::addPermission('WMS', 'web');
    }
}
