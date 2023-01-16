<?php

namespace Database\Seeders;

use App\Models\tms\TMSVehicle;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $vehicleList = [
            ['id' => 1, 'driver_id' => 2, 'dedicated_customer_id' => null, 'relations_name_surname' => 'relation_name', 'relations_phone' => '05xx xxx xxxx', 'degree_of_proximity' => 'proximity', 'trademark' => 1,
            'model' => 'DALY', 'licence_plate' => '34XXX100', 'model_date' => 2021, 'fixed_address' => 'ANKARA' , 'kilometer' => 94541, 'ownership' => 1, 'care_kilometer' => 113580, 'inspection_date' => '2023-2-10',
            'average_fuel_consumption' => 0.00, 'capacity' => 1.5, 'width' => 205, 'size' => 420, 'height' => 260, 'vehicle_tracking_system' => true, 'vehicle_recognition' => true,
            'maintenance_agreement_signature' => false, 'embezzlement_form' => true, 'service_description' => true, 'service_id' => 2, 'supplier_id' => null],
        ];
        TMSVehicle::insert($vehicleList);
    }
}
