<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $itDepartment = Department::where('name', 'إدارة تكنولوجيا المعلومات')->first();

        $admin = User::create([
            'name' => 'المسؤول',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'department_id' => $itDepartment->id,
        ]);
        $admin->assignRole('admin');

        $agents = [
            ['name' => 'دعم فني 1', 'email' => 'support1@example.com'],
            ['name' => 'دعم فني 2', 'email' => 'support2@example.com'],
        ];

        foreach ($agents as $agentData) {
            $agent = User::create([
                'name' => $agentData['name'],
                'email' => $agentData['email'],
                'password' => Hash::make('password'),
                'department_id' => $itDepartment->id,
            ]);
            $agent->assignRole('staff');
        }

        $departments = [
            'إدارة العلاقات العامة' => ['name' => 'مدير العلاقات العامة', 'email' => 'pr_manager'],
            'إدارة شئون الطلاب' => ['name' => 'مدير شئون الطلاب', 'email' => 'student_affairs_manager'],
            'إدارة الشئون القانونية' => ['name' => 'مدير الشئون القانونية', 'email' => 'legal_manager'],
            'إدارة الحسابات' => ['name' => 'مدير الحسابات', 'email' => 'finance_manager'],
            'إدارة الأمن' => ['name' => 'مدير الأمن', 'email' => 'security_manager'],
            'إدارة المخازن' => ['name' => 'مدير المخازن', 'email' => 'warehouse_manager'],
        ];

        foreach ($departments as $departmentName => $userData) {
            $department = Department::where('name', $departmentName)->first();

            if ($department) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'] . '@example.com',
                    'password' => Hash::make('password'),
                    'department_id' => $department->id,
                ]);
                $user->assignRole('client');
            }
        }
    }
}
