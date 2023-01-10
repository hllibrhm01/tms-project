<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cityList = [

            ['id' => 1, 'country_id' => '1', 'name' => 'ADANA'],
            ['id' => 2, 'country_id' => '1', 'name' => 'ADIYAMAN'],
            ['id' => 3, 'country_id' => '1', 'name' => 'AFYONKARAHİSAR'],
            ['id' => 4, 'country_id' => '1', 'name' => 'AĞRI'],
            ['id' => 5, 'country_id' => '1', 'name' => 'AKSARAY'],
            ['id' => 6, 'country_id' => '1', 'name' => 'AMASYA'],
            ['id' => 7, 'country_id' => '1', 'name' => 'ANKARA'],
            ['id' => 8, 'country_id' => '1', 'name' => 'ANTALYA'],
            ['id' => 9, 'country_id' => '1', 'name' => 'ARDAHAN'],
            ['id' => 10, 'country_id' => '1', 'name' => 'ARTVİN'],
            ['id' => 11, 'country_id' => '1', 'name' => 'AYDIN'],
            ['id' => 12, 'country_id' => '1', 'name' => 'BALIKESİR'],
            ['id' => 13, 'country_id' => '1', 'name' => 'BARTIN'],
            ['id' => 14, 'country_id' => '1', 'name' => 'BATMAN'],
            ['id' => 15, 'country_id' => '1', 'name' => 'BAYBURT'],
            ['id' => 16, 'country_id' => '1', 'name' => 'BİLECİK'],
            ['id' => 17, 'country_id' => '1', 'name' => 'BİNGÖL'],
            ['id' => 18, 'country_id' => '1', 'name' => 'BİTLİS'],
            ['id' => 19, 'country_id' => '1', 'name' => 'BOLU'],
            ['id' => 20, 'country_id' => '1', 'name' => 'BURDUR'],
            ['id' => 21, 'country_id' => '1', 'name' => 'BURSA'],
            ['id' => 22, 'country_id' => '1', 'name' => 'ÇANAKKALE'],
            ['id' => 23, 'country_id' => '1', 'name' => 'ÇANKIRI'],
            ['id' => 24, 'country_id' => '1', 'name' => 'ÇORUM'],
            ['id' => 25, 'country_id' => '1', 'name' => 'DENİZLİ'],
            ['id' => 26, 'country_id' => '1', 'name' => 'DİYARBAKIR'],
            ['id' => 27, 'country_id' => '1', 'name' => 'DÜZCE'],
            ['id' => 28, 'country_id' => '1', 'name' => 'EDİRNE'],
            ['id' => 29, 'country_id' => '1', 'name' => 'ELAZIĞ'],
            ['id' => 30, 'country_id' => '1', 'name' => 'ERZİNCAN'],
            ['id' => 31, 'country_id' => '1', 'name' => 'ERZURUM'],
            ['id' => 32, 'country_id' => '1', 'name' => 'ESKİŞEHİR'],
            ['id' => 33, 'country_id' => '1', 'name' => 'GAZİANTEP'],
            ['id' => 34, 'country_id' => '1', 'name' => 'GİRESUN'],
            ['id' => 35, 'country_id' => '1', 'name' => 'GÜMÜŞHANE'],
            ['id' => 36, 'country_id' => '1', 'name' => 'HAKKARİ'],
            ['id' => 37, 'country_id' => '1', 'name' => 'HATAY'],
            ['id' => 38, 'country_id' => '1', 'name' => 'IĞDIR'],
            ['id' => 39, 'country_id' => '1', 'name' => 'ISPARTA'],
            ['id' => 40, 'country_id' => '1', 'name' => 'İSTANBUL'],
            ['id' => 41, 'country_id' => '1', 'name' => 'İZMİR'],
            ['id' => 42, 'country_id' => '1', 'name' => 'KAHRAMANMARAŞ'],
            ['id' => 43, 'country_id' => '1', 'name' => 'KARABÜK'],
            ['id' => 44, 'country_id' => '1', 'name' => 'KARAMAN'],
            ['id' => 45, 'country_id' => '1', 'name' => 'KARS'],
            ['id' => 46, 'country_id' => '1', 'name' => 'KASTAMONU'],
            ['id' => 47, 'country_id' => '1', 'name' => 'KAYSERİ'],
            ['id' => 48, 'country_id' => '1', 'name' => 'KIRIKKALE'],
            ['id' => 49, 'country_id' => '1', 'name' => 'KIRKLARELİ'],
            ['id' => 50, 'country_id' => '1', 'name' => 'KIRŞEHİR'],
            ['id' => 51, 'country_id' => '1', 'name' => 'KİLİS'],
            ['id' => 52, 'country_id' => '1', 'name' => 'KOCAELİ'],
            ['id' => 53, 'country_id' => '1', 'name' => 'KONYA'],
            ['id' => 54, 'country_id' => '1', 'name' => 'KÜTAHYA'],
            ['id' => 55, 'country_id' => '1', 'name' => 'MALATYA'],
            ['id' => 56, 'country_id' => '1', 'name' => 'MANİSA'],
            ['id' => 57, 'country_id' => '1', 'name' => 'MARDİN'],
            ['id' => 58, 'country_id' => '1', 'name' => 'MERSİN'],
            ['id' => 59, 'country_id' => '1', 'name' => 'MUĞLA'],
            ['id' => 60, 'country_id' => '1', 'name' => 'MUŞ'],
            ['id' => 61, 'country_id' => '1', 'name' => 'NEVŞEHİR'],
            ['id' => 62, 'country_id' => '1', 'name' => 'NİĞDE'],
            ['id' => 63, 'country_id' => '1', 'name' => 'ORDU'],
            ['id' => 64, 'country_id' => '1', 'name' => 'OSMANİYE'],
            ['id' => 65, 'country_id' => '1', 'name' => 'RİZE'],
            ['id' => 66, 'country_id' => '1', 'name' => 'SAKARYA'],
            ['id' => 67, 'country_id' => '1', 'name' => 'SAMSUN'],
            ['id' => 68, 'country_id' => '1', 'name' => 'SİİRT'],
            ['id' => 69, 'country_id' => '1', 'name' => 'SİNOP'],
            ['id' => 70, 'country_id' => '1', 'name' => 'SİVAS'],
            ['id' => 71, 'country_id' => '1', 'name' => 'ŞANLIURFA'],
            ['id' => 72, 'country_id' => '1', 'name' => 'ŞIRNAK'],
            ['id' => 73, 'country_id' => '1', 'name' => 'TEKİRDAĞ'],
            ['id' => 74, 'country_id' => '1', 'name' => 'TOKAT'],
            ['id' => 75, 'country_id' => '1', 'name' => 'TRABZON'],
            ['id' => 76, 'country_id' => '1', 'name' => 'TUNCELİ'],
            ['id' => 77, 'country_id' => '1', 'name' => 'UŞAK'],
            ['id' => 78, 'country_id' => '1', 'name' => 'VAN'],
            ['id' => 79, 'country_id' => '1', 'name' => 'YALOVA'],
            ['id' => 80, 'country_id' => '1', 'name' => 'YOZGAT'],
            ['id' => 81, 'country_id' => '1', 'name' => 'ZONGULDAK']
        ];
        City::insert($cityList);
    }
}
