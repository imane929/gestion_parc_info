<?php

namespace Database\Factories;

use App\Models\ActifInformatique;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActifInformatiqueFactory extends Factory
{
    protected $model = ActifInformatique::class;

    public function definition(): array
    {
        $types = ['pc', 'imprimante', 'serveur', 'reseau', 'peripherique', 'mobile'];
        $marques = ['Dell', 'HP', 'Lenovo', 'Apple', 'Cisco', 'Brother', 'Epson'];
        $etats = ['neuf', 'bon', 'moyen', 'mauvais', 'hors_service'];
        
        return [
            'code_inventaire' => 'INV-' . $this->faker->unique()->numerify('#####'),
            'type' => $this->faker->randomElement($types),
            'marque' => $this->faker->randomElement($marques),
            'modele' => $this->faker->word . ' ' . $this->faker->numberBetween(1000, 9999),
            'numero_serie' => $this->faker->unique()->bothify('SN-########'),
            'etat' => $this->faker->randomElement($etats),
            'date_achat' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'garantie_fin' => $this->faker->optional()->dateTimeBetween('now', '+2 years'),
            'localisation_id' => null, // À définir dans le seeder
            'utilisateur_affecte_id' => null, // À définir dans le seeder
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function pc(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'pc',
                'marque' => $this->faker->randomElement(['Dell', 'HP', 'Lenovo']),
                'modele' => 'OptiPlex ' . $this->faker->numberBetween(3000, 9000),
            ];
        });
    }

    public function serveur(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'serveur',
                'marque' => $this->faker->randomElement(['Dell', 'HP', 'IBM']),
                'modele' => 'PowerEdge ' . $this->faker->numberBetween(100, 900),
            ];
        });
    }

    public function imprimante(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'imprimante',
                'marque' => $this->faker->randomElement(['HP', 'Epson', 'Brother']),
                'modele' => 'LaserJet ' . $this->faker->numberBetween(100, 900),
            ];
        });
    }
}