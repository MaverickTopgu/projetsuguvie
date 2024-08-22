<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,'vendor_id'=>1,'shop_name'=>'john Electronics',
            'shop_address'=>'24323-ACI','shop_city'=>'Bamako',
            'shop_state'=>'Bamako','shop_country'=>'Mali',
            'shop_pincode'=>'1100','shop_mobile'=>'92792888',
            'shop_website'=>'sitemakers.in',
            'address_proof_image'=>'test.jpg',
            'business_license_number'=>'B2342352',
            'gst_number'=>'Bama43653456','pan_number'=>'25245',
            'address_proof'=>'passport',
            'shop_email'=>'john@gmail.com'],
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}
