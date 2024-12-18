<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CuveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom' => 'Cuve ' . $this->faker->randomElement([
            'Émeraude', 'Saphir', 'Rubis', 'Topaze', 'Ambre', 'Azur', 'Onyx', 'Opale', 
            'Cristal', 'Perle', 'Jade', 'Céleste', 'Soleil', 'Lune', 'Aurore', 'Flamme', 
            'Brume', 'Étoile', 'Vortex', 'Nébuleuse', 'Cascade', 'Forêt', 'Mer', 'Rivière', 
            'Volcan', 'Glacier', 'Mistral', 'Cyclone', 'Horizon', 'Crépuscule', 'Polaris', 
            'Orchidée', 'Lavande', 'Corail', 'Granit', 'Marbre', 'Quartz', 'Sable', 'Tourmaline'
        ]) . ' ' . $this->faker->numberBetween(1, 100),
            'volume_max' => $this->faker->numberBetween(30, 50) * 100,
        ];
    }
}