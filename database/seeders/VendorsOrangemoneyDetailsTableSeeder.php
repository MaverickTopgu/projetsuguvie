<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsOrangemoneyDetail;

class VendorsOrangemoneyDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'account_holder_name'=>'john Cena',
            'account_number'=>'92792888'
            ],
        ];
        VendorsOrangemoneyDetail::insert($vendorRecords);
    }
}
