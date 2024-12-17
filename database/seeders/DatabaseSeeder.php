<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cuve;
use App\Models\Mout;
use App\Models\Proprietaire;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Appelle le seeder des rôles et permissions
        $this->call(RolePermissionSeeder::class);

        // Récupère les rôles
        $superAdminRole = Role::firstWhere('name', 'super-admin');
        $adminRole = Role::firstWhere('name', 'admin');
        $cuvisteRole = Role::firstWhere('name', 'cuviste');
        $managerRole = Role::firstWhere('name', 'manager');

        // Crée des utilisateurs spécifiques avec rôles
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@domain.com',
        ]);
        $superAdmin->assignRole($superAdminRole);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@domain.com',
        ]);
        $admin->assignRole($adminRole);

        $cuviste = User::factory()->create([
            'name' => 'Cuviste User',
            'email' => 'cuviste@domain.com',
        ]);
        $cuviste->assignRole($cuvisteRole);

        $manager = User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@domain.com',
        ]);
        $manager->assignRole($managerRole);

        // Crée une liste de propriétaires
        $proprietaires = Proprietaire::factory(10)->create();

        // Crée 20 cuves
        Cuve::factory(20)->create()->each(function ($cuve) use ($proprietaires) {
            // Pour chaque cuve, crée 2 à 5 moûts avec un propriétaire aléatoire
            Mout::factory(rand(2, 5))->create([
                'cuve_id' => $cuve->id,
                'proprietaire_id' => $proprietaires->random()->id,
            ]);
        });
    }
}
