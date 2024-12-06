<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cuve;
use App\Models\Mout;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Appel du RolePermissionSeeder pour créer les rôles et permissions
        $this->call(RolePermissionSeeder::class);

        // Crée le premier utilisateur admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory()->admin()->create(); // Utilise le state admin de la factory
        $admin->assignRole($adminRole);

        // Crée 10 utilisateurs aléatoires
        User::factory(10)->create();

        // Crée 10 cuves
        Cuve::factory(10)->create();

        // Crée 50 moûts, assignés aléatoirement aux cuves
        Mout::factory(50)->create();
    }
}