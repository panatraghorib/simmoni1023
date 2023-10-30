<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cabor>
 */
class CaborFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cabor_name' => fake()->company(),
            'initial' => fake()->company(),
            'logo' => fake()->image(),
            'date_founded' => fake()->date(),
            'description' => fake()->paragraph(),
        ];
    }
}
