<?php

namespace Database\Seeders;

use App\Models\District;
use Aws\Api\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
            EquipmentSeeder::class,
            TaxDepartmentSeeder::class,
            DriverSeeder::class,
            ServiceSeeder::class,
            GeneralSettingsSeeder::class,
        ]);
    }
}
