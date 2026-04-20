<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->word,
            'libelle' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph,
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Administrateur',
                'code' => 'admin',
                'libelle' => 'Administrateur système',
                'description' => 'Accès complet à toutes les fonctionnalités',
            ];
        });
    }

    public function responsableIT(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Responsable IT',
                'code' => 'responsable_it',
                'libelle' => 'Responsable informatique',
                'description' => 'Gestion du parc informatique et des tickets',
            ];
        });
    }

    public function technicien(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Technicien',
                'code' => 'technicien',
                'libelle' => 'Technicien informatique',
                'description' => 'Intervention sur les équipements et tickets',
            ];
        });
    }

    public function utilisateur(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Utilisateur',
                'code' => 'utilisateur',
                'libelle' => 'Utilisateur standard',
                'description' => 'Accès aux fonctionnalités de base',
            ];
        });
    }
}