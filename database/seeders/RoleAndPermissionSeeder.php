<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos
        $permissions = ['manage_categories', 'manage_providers', 'manage_products', 'manage_sales'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $cajeroRole = Role::firstOrCreate(['name' => 'Cajero']);

        // Asignar permisos a roles
        $adminRole->syncPermissions($permissions); // Admin tiene todos los permisos
        $cajeroRole->syncPermissions(['manage_sales']); // Cajero solo puede gestionar ventas
    }
}
