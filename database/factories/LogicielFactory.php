<?php

namespace Database\Factories;

use App\Models\Logiciel;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogicielFactory extends Factory
{
    protected $model = Logiciel::class;

    public function definition(): array
    {
        $types = ['os', 'bureau', 'serveur', 'web', 'mobile'];
        $editeurs = ['Microsoft', 'Adobe', 'Oracle', 'Google', 'Mozilla', 'JetBrains'];
        
        return [
            'nom' => $this->faker->word . ' ' . $this->faker->word,
            'editeur' => $this->faker->randomElement($editeurs),
            'version' => $this->faker->numerify('#.#.#'),
            'type' => $this->faker->randomElement($types),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function os(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'os',
                'nom' => $this->faker->randomElement(['Windows', 'Linux', 'macOS']),
                'editeur' => $this->faker->randomElement(['Microsoft', 'Canonical', 'Apple']),
            ];
        });
    }

    public function bureau(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'bureau',
                'nom' => $this->faker->randomElement(['Office', 'Photoshop', 'AutoCAD']),
                'editeur' => $this->faker->randomElement(['Microsoft', 'Adobe', 'Autodesk']),
            ];
        });
    }
}