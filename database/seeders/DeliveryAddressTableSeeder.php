<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            ['id'=>1,'user_id'=>1,'name'=>'Sekou Diarra',
            'address'=>'123-a','city'=>'bamako','state'=>'bamako',
            'country'=>'Mali','pincode'=>'0101','mobile'=>'0635756774','status'=>1],

            ['id'=>2,'user_id'=>1,'name'=>'sekou diarra',
            'address'=>'12345-a','city'=>'bamako','state'=>'bamako',
            'country'=>'Mali','pincode'=>'0202','mobile'=>'0635756773','status'=>1],
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
