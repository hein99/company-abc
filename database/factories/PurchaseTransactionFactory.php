<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseTransaction>
 */
class PurchaseTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' => rand(1, 20),
            'total_spent' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999),
            'total_saving' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 99),
            'transaction_at' => $this->faker->dateTimeBetween($startDate = '-1 months', $endDate = 'now', $timezone = null),
        ];
    }
}
