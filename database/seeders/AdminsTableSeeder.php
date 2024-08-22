<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
           ['id'=>2,'name'=>'john','type'=>'vendor','vendor_id'=>1,'mobile'=>'92792888','email'=>'john@gmail.com',
           'password'=>'$2a$12$PFGaVbnWnCiAPPUO3h7YVOMM/Y7oDjio26ay0.mOCKp7r9/dbFYeC','image'=>'','status'=>0], 
        ];
        Admin::insert($adminRecords);
    }
}
