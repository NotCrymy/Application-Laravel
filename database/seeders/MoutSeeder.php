<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cuve;
use App\Models\Mout;

class MoutSeeder extends Seeder
{
    public function run()
    {
        Cuve::factory(10)
            ->has(Mout::factory()->count(5)) // Chaque cuve contient 5 moûts
            ->create();
    }
}