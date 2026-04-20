<?php

namespace Database\Factories;

use App\Models\LicenceLogiciel;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenceLogicielFactory extends Factory
{
    protected $model = LicenceLogiciel::class;

    public function definition(): array
    {
        return [
            'logiciel_id' => null, // À définir dans le seeder
            'cle_licence' => $this->faker->unique()->bothify('LIC-########-########-########'),
            'date_achat' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'date_expiration' => $this->faker->dateTimeBetween('now', '+2 years'),
            'nb_postes' => $this->faker->numberBetween(1, 50),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}