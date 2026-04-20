<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'code' => $this->faker->unique()->slug(2),
            'libelle' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph,
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}