<?php

namespace Database\Factories;

use App\Models\Prestataire;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrestataireFactory extends Factory
{
    protected $model = Prestataire::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->company,
            'telephone' => $this->faker->phoneNumber,
            'email' => $this->faker->companyEmail,
            'adresse_id' => null, // À définir dans le seeder
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}