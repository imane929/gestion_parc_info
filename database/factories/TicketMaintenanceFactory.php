<?php

namespace Database\Factories;

use App\Models\TicketMaintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketMaintenanceFactory extends Factory
{
    protected $model = TicketMaintenance::class;

    public function definition(): array
    {
        $priorites = ['basse', 'moyenne', 'haute', 'urgente'];
        $statuts = ['ouvert', 'en_cours', 'en_attente', 'resolu', 'ferme'];
        
        return [
            'numero' => 'TICK-' . $this->faker->unique()->numerify('#####'),
            'actif_informatique_id' => null, // À définir dans le seeder
            'sujet' => $this->faker->sentence(6),
            'description' => $this->faker->paragraphs(3, true),
            'priorite' => $this->faker->randomElement($priorites),
            'statut' => $this->faker->randomElement($statuts),
            'assigne_a' => null, // À définir dans le seeder
            'created_by' => null, // À définir dans le seeder
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'updated_at' => now(),
        ];
    }

    public function ouvert(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'ouvert',
                'assigne_a' => null,
            ];
        });
    }

    public function enCours(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'statut' => 'en_cours',
            ];
        });
    }

    public function urgent(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'priorite' => 'urgente',
            ];
        });
    }
}