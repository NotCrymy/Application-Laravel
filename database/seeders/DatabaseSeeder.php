<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Crée le rôle "admin"
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Crée un utilisateur admin
        $admin = User::factory()->admin()->create();
        $admin->assignRole($adminRole);

        // Crée d'autres utilisateurs random
        User::factory(10)->create();
    }
}