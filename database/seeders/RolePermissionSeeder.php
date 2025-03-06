<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view tickets',
            'create tickets',
            'edit tickets',
            'delete tickets',
            'manage tickets',

            'view reports',
            'generate reports',

            'view users',
            'manage users',
            'manage roles',

            'view settings',
            'manage categories',
            'manage departments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $staff = Role::firstOrCreate(['name' => 'staff']);
        $client = Role::firstOrCreate(['name' => 'client']);

        $admin->syncPermissions($permissions);
        $staff->syncPermissions(['view tickets', 'create tickets', 'manage tickets']);
        $client->syncPermissions(['view tickets', 'create tickets','edit tickets','manage tickets','delete tickets']);

        $this->command->info('✅ الأدوار والصلاحيات تمت إضافتها بنجاح!');
    }
}
