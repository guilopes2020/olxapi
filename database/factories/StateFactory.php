<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $state = [
            'Acre',
            'Alagoas',
            'Amapa',
            'Amazonas',
            'Bahia',
            'Ceara',
            'Distrito Federal',
            'Espirito Santo',
            'Goias',
            'Maranhao',
            'Mato Grosso',
            'Mato Grosso do Sul',
            'Minas Gerais',
            'Para',
            'Paraiba',
            'Parana',
            'Pernambuco',
            'Piaui',
            'Rio de Janeiro',
            'Rio Grande do Norte',
            'Rio Grande do Sul',
            'Rondonia',
            'Roraima',
            'Santa Catarina',
            'Sao Paulo',
            'Sergipe',
            'Tocantins',
        ];

        return [
            'name' => fake()->randomElement($state),
            'slug' => fake()->slug(),
        ];
    }
}
