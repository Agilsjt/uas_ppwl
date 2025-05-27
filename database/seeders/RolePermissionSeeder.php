<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissions
        Permission::create(['name' => 'manage all']);
        Permission::create(['name' => 'read all']);


        // Roles
        $admin = Role::create(['name' => 'admin']);
        $staff = Role::create(['name' => 'staff']);

        // Assign permissions
        $admin->givePermissionTo(Permission::all());

        $staff->givePermissionTo([
            'read all',
        ]);

    }
}
