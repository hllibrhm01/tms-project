<?php

namespace Database\Seeders;

use App\Models\Role;
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

        $roleList = [
            [
                "name" => "Super Admin",
                "guard_name" => "web"
            ],
            [
                "name" => "Admin",
                "guard_name" => "web"
            ],
            [
                "name" => "Driver",
                "guard_name" => "web"
            ],
            [
                "name" => "Planner",
                "guard_name" => "web"
            ],
            [
                "name" => "Dealer",
                "guard_name" => "web"
            ],
        ];

        Role::insert($roleList);
    }
}
