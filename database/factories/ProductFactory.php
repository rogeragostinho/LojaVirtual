<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'name' => $name,
            'description' => $this->faker->paragraph(),
            'slug' => \Str::slug($name),
            'price' => $this->faker->randomFloat(2, 5, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement([ProductStatus::ACTIVE, ProductStatus::INACTIVE]),
            // Pega um ID aleatório do que já existe no banco:
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
        ];
    }
}
