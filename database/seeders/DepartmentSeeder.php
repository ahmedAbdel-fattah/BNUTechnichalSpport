<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::insert([
            ['name' => 'إدارة تكنولوجيا المعلومات'],
            ['name' => 'إدارة العلاقات العامة'],
            ['name' => 'إدارة شئون الطلاب'],
            ['name' => 'إدارة الشئون القانونية'],
            ['name' => 'إدارة الحسابات'],
            ['name' => 'إدارة الأمن'],
            ['name' => 'إدارة المخازن'],
        ]);
    }
}
