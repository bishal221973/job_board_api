<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\District;
use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country=Country::create([
            'country_code'=>'+977',
            'name'=>'Nepal'
        ]);

        $province=Province::create([
            'country_id'=> $country->id,
            'name'=>'Gandaki Province',
        ]);

        $district=District::create([
            'province_id'=>$province->id,
            'name'=>'Kaski',
        ]);

        Municipality::create([
            'district_id'=>$district->id,
            'name'=>'Pokhara Metropolitan'
        ]);
    }
}
