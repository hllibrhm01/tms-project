<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countryList = [
            [
                "name" => "Türkiye",
                "iso_code" => "1"
            ],
        ];

        Country::insert($countryList);
    }
}
