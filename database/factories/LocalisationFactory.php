<?php

namespace Database\Factories;

use App\Models\Localisation;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocalisationFactory extends Factory
{
    protected $model = Localisation::class;

    public function definition(): array
    {
        $sites = ['Siège', 'Agence Paris', 'Agence Lyon', 'Agence Marseille', 'Entrepôt'];
        $batiments = ['A', 'B', 'C', 'D', 'Principal'];
        
        return [
            'site' => $this->faker->randomElement($sites),
            'batiment' => $this->faker->optional()->randomElement($batiments),
            'etage' => $this->faker->optional()->numberBetween(1, 10),
            'bureau' => $this->faker->optional()->bothify('Bureau ###'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function siege(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'site' => 'Siège',
                'batiment' => 'Principal',
                'etage' => $this->faker->numberBetween(1, 5),
                'bureau' => $this->faker->bothify('Bureau ###'),
            ];
        });
    }
}