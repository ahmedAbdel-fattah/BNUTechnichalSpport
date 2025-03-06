<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::insert([
            ['name' => 'مشكلة شبكات'],
            ['name' => 'مشكلة صيانة'],
            ['name' => 'مشكلة تعريفات'],
            ['name' => 'مشاكل أخرى'],
        ]);
    }
}