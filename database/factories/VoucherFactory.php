<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = ['available', 'locked', 'redeemed'];

        return [
            'code' => strtoupper($this->faker->unique()->bothify('##?#?##')),
            'customer_id' => $this->faker->numberBetween($min = 1, $max = 20),
            'status' => $status[rand(0, 2)],
            'locked_down_expired_at' => $this->faker->dateTimeBetween($startDate = '-10 minutes', $endDate = 'now', $timezone = null),
        ];
    }
}
