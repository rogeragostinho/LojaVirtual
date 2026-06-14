<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Pega um usuário aleatório do banco ou cria um se não houver
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            
            // Gera um valor total aleatório para o pedido (ex: entre 50 e 2000)
            'total' => $this->faker->numberBetween(50, 2000),
            
            // Escolhe um dos status definidos no ENUM da sua tabela do DER
            'status' => $this->faker->randomElement(['pending', 'paid', 'shipped', 'cancelled']),
            'phone' => $this->faker->phoneNumber(),
            'province' => $this->faker->randomElement(['Luanda', 'Benguela', 'Huíla', 'Cabinda', 'Huambo']),
            'address' => $this->faker->streetAddress(),
        ];
    }
}
