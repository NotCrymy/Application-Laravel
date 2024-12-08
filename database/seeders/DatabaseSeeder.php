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
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Crée le premier utilisateur en tant que super admin
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@domain.com',
            'password' => bcrypt('password'),
        ]);

        $superAdmin->assignRole($superAdminRole);

        // Ajoutez les autres utilisateurs ici
        User::factory(10)->create();

        // Crée 10 cuves
        Cuve::factory(10)->create();

        // Crée 50 moûts, assignés aléatoirement aux cuves
        Mout::factory(50)->create();
    }
}