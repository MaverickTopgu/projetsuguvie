<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords=
        [
            ['id'=>1,'name'=>'john','addresse'=>'ACI-2000',
            'city'=>'Bamako','state'=>'Bamako','country'=>'Mali',
            'pincode'=>'1100','mobile'=>'92792888','email'=>'john@gmail.com','status'=>0],
        ];
        Vendor::insert($vendorRecords);
    }
}
