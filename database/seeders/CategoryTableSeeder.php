<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [

            ['id'=>1,'parent_id'=>0,'section_id'=>1,'category_name'=>'Hommes','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'men','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>2,'parent_id'=>0,'section_id'=>1,'category_name'=>'Femmes','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'women','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id'=>3,'parent_id'=>0,'section_id'=>1,'category_name'=>'Enfants','category_image'=>'',
            'category_discount'=>0,'description'=>'','url'=>'kids','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'','status'=>1],
        ];
        Category::insert($categoryRecords);
    }
}
