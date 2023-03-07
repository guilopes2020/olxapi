<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\State;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertise>
 */
class AdvertiseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create()->pluck('id');
        $state = State::factory()->create()->pluck('id');
        $category = Category::factory()->create()->pluck('id');

        return [
            'user_id' => fake()->randomElement($user),
            'state_id' => fake()->randomElement($state),
            'category_id' => fake()->randomElement($category),
            'title' => fake()->sentence(),
            'price' => random_int(50, 10000),
            'is_negotiable' => fake()->boolean(),
            'description' => fake()->text(),
            'views' => random_int(1, 500),
        ];
    }
}
