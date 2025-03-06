<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $seeders = [
            RolePermissionSeeder::class,
            DepartmentSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            TicketSeeder::class,
            CommentSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            $this->call($seeder);
            $this->command->info("✅ $seeder has been successfully executed.");

        }
    }
}
