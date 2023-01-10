<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addTestServices();
        $this->addTestSuppliers();
        $this->addTestVehicles();
        $this->addTestCustomers();
    }

    private function addTestVehicles()
    {
        DB::table('tms_vehicles')->insert(
            [
                "driver_id" => 1,
                "relations_name_surname" => "Vehicle 1 Yakını",
                "relations_phone" => "0123456789",
                "degree_of_proximity" => "Vehicle 1 Yakını",
                "trademark" => 0,
                "model" => "A1",
                "licence_plate" => "V3H1CL3 1",
                "model_date" => "1990",
                "kilometer" => "52255",
                "ownership" => 1,
                "care_kilometer" => 5000,
                "inspection_date" => "2022-10-01",
                "average_fuel_consumption" => 7.5,
                "capacity" => 5000,
                "width" => 50,
                "size" => 100,
                "height" => 150,
                "vehicle_tracking_system" => 1,
                "vehicle_recognition" => 1,
                "maintenance_agreement_signature" => 1,
                "vehicle_tracking_system" => 1,
                "embezzlement_form" => 1,
                "service_description" => 1,
                "service_id" => 1,
                "supplier_id" => 1,
            ]
        );

        DB::table('tms_vehicles')->insert(
            [
                "driver_id" => 2,
                "relations_name_surname" => "Vehicle 2 Yakını",
                "relations_phone" => "0123456789",
                "degree_of_proximity" => "Vehicle 2 Yakını",
                "trademark" => 1,
                "model" => "A2",
                "licence_plate" => "V3H1CL3 2",
                "model_date" => "1990",
                "kilometer" => "52255",
                "ownership" => 1,
                "care_kilometer" => 5003,
                "inspection_date" => "2022-10-01",
                "average_fuel_consumption" => 7.5,
                "capacity" => 5003,
                "width" => 53,
                "size" => 103,
                "height" => 153,
                "vehicle_tracking_system" => 1,
                "vehicle_recognition" => 1,
                "maintenance_agreement_signature" => 1,
                "vehicle_tracking_system" => 1,
                "embezzlement_form" => 1,
                "service_description" => 1,
                "service_id" => 2,
                "supplier_id" => 2,
            ]
        );
    }

    private function addTestServices()
    {
        DB::table('tms_vehicle_services')->insert(
            [
                "author" => "Service 1 Yetkili",
                "name" => "Service 1",
                "phone" => "0123 456 789",
                "email" => "service1@1k2a.net",
                "address" => "Service 1 Address",
            ]
        );

        DB::table('tms_vehicle_services')->insert(
            [
                "author" => "Service 2 Yetkili",
                "name" => "Service 2",
                "phone" => "2123 456 789",
                "email" => "service2@1k2a.net",
                "address" => "Service 2 Address",
            ]
        );

        DB::table('tms_vehicle_services')->insert(
            [
                "author" => "Service 3 Yetkili",
                "name" => "Service 3",
                "phone" => "3123 456 789",
                "email" => "service3@1k2a.net",
                "address" => "Service 3 Address",
            ]
        );
    }

    private function addTestSuppliers()
    {
        DB::table('tms_vehicle_suppliers')->insert(
            [
                "author" => "Supplier 1 Yetkili",
                "name" => "Supplier 1",
                "phone" => "0123 456 789",
                "email" => "supplier1@1k2a.net",
                "address" => "Supplier 1 Address",
            ]
        );

        DB::table('tms_vehicle_suppliers')->insert(
            [
                "author" => "Supplier 2 Yetkili",
                "name" => "Supplier 2",
                "phone" => "2123 456 789",
                "email" => "supplier2@1k2a.net",
                "address" => "Supplier 2 Address",
            ]
        );

        DB::table('tms_vehicle_suppliers')->insert(
            [
                "author" => "Supplier 3 Yetkili",
                "name" => "Supplier 3",
                "phone" => "3123 456 789",
                "email" => "supplier3@1k2a.net",
                "address" => "Supplier 3 Address",
            ]
        );
    }

    private function addTestCustomers()
    {
        $customer1 = DB::table('tms_customers')->insertGetId([
            "billing_period" => 1,
            "company_name" => "Customer1 Company Oran",
            "group_type" => 1,
            "iban" => "TR90 CU5T0M3R 1",
            "note" => "Customer 1 Note",
            "payment_type" => 1,
            "progress_payment_rate" => 10,
            "progress_payment_type" => 1,
            "tax_department_city_id" => 1,
            "tax_department_district_id" => 1,
            "tax_department_id" => 16,
            "tax_number" => 111,
            "work_type" => 1,
        ]);

        $customer2 = DB::table('tms_customers')->insertGetId([
            "billing_period" => 1,
            "company_name" => "Customer2 Company Oran",
            "group_type" => 2,
            "iban" => "TR90 CU5T0M3R 2",
            "note" => "Customer 2 Note",
            "payment_type" => 2,
            "progress_payment_rate" => 5000,
            "progress_payment_type" => 2,
            "tax_department_city_id" => 1,
            "tax_department_district_id" => 1,
            "tax_department_id" => 16,
            "tax_number" => 111,
            "work_type" => 1,
        ]);

        $customer3 = DB::table('tms_customers')->insertGetId([
            "billing_period" => 1,
            "company_name" => "Customer3 Company Oran",
            "group_type" => 3,
            "iban" => "TR90 CU5T0M3R 3",
            "note" => "Customer 2 Note",
            "payment_type" => 2,
            "progress_payment_rate" => 0,
            "progress_payment_type" => 3,
            "tax_department_city_id" => 1,
            "tax_department_district_id" => 1,
            "tax_department_id" => 16,
            "tax_number" => 111,
            "work_type" => 1,
        ]);

        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer1,
                "name" => "Customer 1 Dolap",
                "price" => 1500,
            ]
        );


        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer1,
                "name" => "Customer 1 Zigon",
                "price" => 750,
            ]
        );


        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer1,
                "name" => "Customer 1 Berjer",
                "price" => 500,
            ]
        );


        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer2,
                "name" => "Customer 2 Dolap",
                "price" => 1600,
            ]
        );

        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer2,
                "name" => "Customer 2 Zigon",
                "price" => 650,
            ]
        );
        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer2,
                "name" => "Customer 2 Berjer",
                "price" => 450,
            ]
        );

        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer3,
                "name" => "Customer 3 Dolap",
                "price" => 1611,
            ]
        );
        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer3,
                "name" => "Customer 3 Zigon",
                "price" => 658,
            ]
        );
        DB::table('tms_customer_products')->insert(
            [
                "customer_id" => $customer3,
                "name" => "Customer 3 Berjer",
                "price" => 222,
            ]
        );
    }
}
