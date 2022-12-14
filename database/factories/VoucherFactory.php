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

        return [
            'code' => strtoupper($this->faker->unique()->bothify('##?#?##')),
            'customer_id' => null,
            'status' => 'available',
            'locked_down_expired_at' => null,
        ];
    }
}
