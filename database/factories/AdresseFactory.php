<?php

namespace Database\Factories;

use App\Models\Adresse;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdresseFactory extends Factory
{
    protected $model = Adresse::class;

    public function definition(): array
    {
        return [
            'pays' => 'France',
            'ville' => $this->faker->city,
            'quartier' => $this->faker->optional()->streetName,
            'rue' => $this->faker->streetAddress,
            'code_postal' => $this->faker->postcode,
            'latitude' => $this->faker->latitude(48.8, 49.0),
            'longitude' => $this->faker->longitude(2.2, 2.4),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function paris(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'ville' => 'Paris',
                'code_postal' => $this->faker->randomElement(['75001', '75002', '75003', '75004', '75005']),
                'latitude' => $this->faker->latitude(48.85, 48.87),
                'longitude' => $this->faker->longitude(2.34, 2.37),
            ];
        });
    }

    public function lyon(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'ville' => 'Lyon',
                'code_postal' => $this->faker->randomElement(['69001', '69002', '69003', '69004', '69005']),
                'latitude' => $this->faker->latitude(45.75, 45.77),
                'longitude' => $this->faker->longitude(4.83, 4.85),
            ];
        });
    }
}