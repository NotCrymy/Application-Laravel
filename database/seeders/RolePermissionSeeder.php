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
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $caviste = Role::firstOrCreate(['name' => 'caviste']);

        // Création des permissions
        $permissions = [
            'manage users',
            'view cuves',
            'edit cuves',
            'view logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assignation des permissions aux rôles
        $admin->givePermissionTo(['manage users', 'view cuves', 'edit cuves', 'view logs']);
        $manager->givePermissionTo(['view cuves']);
        $caviste->givePermissionTo(['edit cuves']);
    }
}