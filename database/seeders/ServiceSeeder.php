<?php

namespace Database\Seeders;

use App\Models\tms\TMSVehicleService;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $serviceList = [
            ['id' => 1, 'author' => 'author', 'name' => 'Service auther name', 'phone' => '05xx xxx xxxx', 'email' => 'email address', 'address' => 'address info'],
        ];
        TMSVehicleService::insert($serviceList);
    }
}
