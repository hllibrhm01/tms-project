<?php

namespace Database\Seeders;

use App\Models\tms\TMSVehicleService;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $serviceList = [
            ['id' => 1, 'author' => 'GÖKHAN GÜÇLÜ', 'name' => 'GÜRÜN GLOBAL', 'phone' => '05464641858', 'email' => 'gokhan.guclu@yesilgurunglobal.com', 'address' => 'Sabit bir adres bulunmuyor'],
            ['id' => 2, 'author' => 'MURAT BİLİM', 'name' => '1K2A LOJİSTİK HİZMETLERİ', 'phone' => '05421380202', 'email' => 'murat.bilim@1k2a.net', 'address' => 'Sabit bir adres bulunmuyor'],
        ];
        TMSVehicleService::insert($serviceList);
    }
}
