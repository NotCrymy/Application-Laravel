<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Création des rôles
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $cuviste = Role::create(['name' => 'cuviste']);
        $manager = Role::create(['name' => 'manager']);

        // Création des permissions
        Permission::create(['name' => 'manage everything']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view cuves']);
        Permission::create(['name' => 'edit cuves']);

        // Assignation des permissions
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage users', 'view cuves', 'edit cuves']);
        $cuviste->givePermissionTo(['edit cuves']);
        $manager->givePermissionTo(['view cuves']);
    }
}