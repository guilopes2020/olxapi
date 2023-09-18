<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $a = [
            'brinquedos',
            'smartphones',
            'casa',
            'moda',
            'eletrodomesticos',
        ];

        return [
            'name'  => fake()->randomElement($a),
            'slug'  => fake()->slug(),
            'image' => fake()->imageUrl(),
        ];
    }
}
