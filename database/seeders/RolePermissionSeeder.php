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
        $manager = Role::create(['name' => 'manager']);
        $caviste = Role::create(['name' => 'caviste']);

        // Création des permissions
        Permission::create(['name' => 'manage everything']); // Super Admin exclusif
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view cuves']);
        Permission::create(['name' => 'edit cuves']);

        // Assignation des permissions
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage users', 'view cuves', 'edit cuves']);
        $manager->givePermissionTo(['view cuves']);
        $caviste->givePermissionTo(['edit cuves']);
    }
}