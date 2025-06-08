<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Client;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['income', 'expense']);
        
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'payment_method_id' => fake()->optional()->randomElement([PaymentMethod::factory()]),
            'client_id' => fake()->optional()->randomElement([Client::factory()]),
            'client_name' => fake()->optional()->company(),
            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'amount' => fake()->numberBetween(1000, 1000000),
            'type' => $type,
            'memo' => fake()->optional()->sentence(),
        ];
    }
}
