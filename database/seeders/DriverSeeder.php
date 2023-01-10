<?php

namespace Database\Seeders;

use App\Models\tms\TMSVehicle;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run()
    {
        $vehicleList = [
            ['id' => 1, 'driver_id' => 2, 'dedicated_customer_id' => null, 'relations_name_surname' => 'YEŞİM DEVECİ', 'relations_phone' => '05550460205', 'degree_of_proximity' => 'EŞİ', 'trademark' => 1,
            'model' => 'DALY', 'licence_plate' => '34DYZ505', 'model_date' => 2021, 'fixed_address' => 'ETİMESGUT/ANKARA' , 'kilometer' => 94541, 'ownership' => 1, 'care_kilometer' => 113580, 'inspection_date' => '2023-2-10',
            'average_fuel_consumption' => 0.00, 'capacity' => 1.5, 'width' => 205, 'size' => 420, 'height' => 260, 'vehicle_tracking_system' => true, 'vehicle_recognition' => true,
            'maintenance_agreement_signature' => false, 'embezzlement_form' => true, 'service_description' => true, 'service_id' => 2, 'supplier_id' => null],

            ['id' => 2, 'driver_id' => 3, 'dedicated_customer_id' => null, 'relations_name_surname' => 'MERVE KARATAŞ', 'relations_phone' => '05538120197', 'degree_of_proximity' => 'EŞİ', 'trademark' => 1,
            'model' => 'DALY', 'licence_plate' => '34DRN773', 'model_date' => 2021, 'fixed_address' => 'SİTELER/ANKARA' , 'kilometer' => 97993, 'ownership' => 1, 'care_kilometer' => 112890, 'inspection_date' => '2023-6-10',
            'average_fuel_consumption' => 0.00, 'capacity' => 1.5, 'width' => 205, 'size' => 420, 'height' => 260, 'vehicle_tracking_system' => true, 'vehicle_recognition' => true,
            'maintenance_agreement_signature' => false, 'embezzlement_form' => true, 'service_description' => true, 'service_id' => 2, 'supplier_id' => null],

            ['id' => 3, 'driver_id' => 4, 'dedicated_customer_id' => null, 'relations_name_surname' => 'MELAHAT SARIDAĞ', 'relations_phone' => '05541243612', 'degree_of_proximity' => 'EŞİ', 'trademark' => 0,
            'model' => 'NEXT', 'licence_plate' => '34EHY886', 'model_date' => 2021, 'fixed_address' => 'KUMSMALL/KAYSERİ' , 'kilometer' => 73481, 'ownership' => 1, 'care_kilometer' => 74538, 'inspection_date' => '2023-9-17',
            'average_fuel_consumption' => 0.00, 'capacity' => 1.5, 'width' => 205, 'size' => 420, 'height' => 260, 'vehicle_tracking_system' => true, 'vehicle_recognition' => true,
            'maintenance_agreement_signature' => false, 'embezzlement_form' => true, 'service_description' => true, 'service_id' => 2, 'supplier_id' => null],

            ['id' => 4, 'driver_id' => 5, 'dedicated_customer_id' => null, 'relations_name_surname' => 'MEDİNE YILMAZ', 'relations_phone' => '05529352521', 'degree_of_proximity' => 'EŞİ', 'trademark' => 0,
            'model' => 'NEXT', 'licence_plate' => '34EHZ070 ', 'model_date' => 2021, 'fixed_address' => 'KUMARLI/KAYSERİ' , 'kilometer' => 76022, 'ownership' => 1, 'care_kilometer' => 88835, 'inspection_date' => '2023-1-1',
            'average_fuel_consumption' => 0.00, 'capacity' => 1.5, 'width' => 205, 'size' => 420, 'height' => 260, 'vehicle_tracking_system' => true, 'vehicle_recognition' => true,
            'maintenance_agreement_signature' => false, 'embezzlement_form' => true, 'service_description' => true, 'service_id' => 2, 'supplier_id' => null],

            ['id' => 5, 'driver_id' => 6, 'dedicated_customer_id' => null, 'relations_name_surname' => 'ABDURRAHİM UZUN', 'relations_phone' => '05354988163', 'degree_of_proximity' => 'BABASI', 'trademark' => 0,
            'model' => 'NEXT', 'licence_plate' => '34EHD915 ', 'model_date' => 2021, 'fixed_address' => 'ÇİĞLİ/İZMİR' , 'kilometer' => 62324, 'ownership' => 1, 'care_kilometer' => 72324, 'inspection_date' => '2023-4-11',
            'average_fuel_consumption' => 0.00, 'capacity' => 1.5, 'width' => 205, 'size' => 420, 'height' => 260, 'vehicle_tracking_system' => true, 'vehicle_recognition' => true,
            'maintenance_agreement_signature' => false, 'embezzlement_form' => true, 'service_description' => true, 'service_id' => 2, 'supplier_id' => null],
        ];
        TMSVehicle::insert($vehicleList);
    }
}
