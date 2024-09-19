<?php

namespace Database\Factories;

use App\Models\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition()
    {
        return [
            'manager_id'       => 1,
            'establishment_id' => 1,
            'number' => fake()->year.(int)fake()->dayOfWeek.fake()->randomNumber(8),
            'status' => OrderStatus::OPEN,
        ];
    }
}
