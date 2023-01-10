<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurkeyAddressCreator extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = DB::table('geozone_countries')->get();
        foreach ($countries as $country) {
            DB::table('countries')->insert(["iso_code" => $country->iso_code, "name" => $country->name]);
            $cities = DB::table('geozone_cities')->where('country_id', $country->id)->get();

            foreach ($cities as $city) {
                DB::table('cities')->insert(["name" => $city->name, "country_id" => $country->id]);
               /*
                $districtData = DB::table('geozone_city_districts')->where('city_id', $city->id)->get()->groupBy('ilce');

                $districts = [];
                foreach ($districtData as $key => $value)
                    $districts[] = $key;

                foreach ($districts as $district) {
                    $id = DB::table('districts')->insertGetId(["name" => $district, "city_id" => $city->id]);
                    $neighborhoods = DB::table('geozone_city_districts')->where('city_id', $city->id)->where('ilce', $district)->get();
                    foreach($neighborhoods as $neighborhood) {
                        DB::table('neighborhoods')->insert(["post_code" => $neighborhood->posta_kodu ,"name" => $neighborhood->mahalle, "district_id" => $id]);
                    }
                }
                */
            }
        }
    }
}
