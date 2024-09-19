<?php

namespace Database\Factories;

use App\Models\Enums\CartStatus;
use App\Models\Goods;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id'      => 1,
            'establishment_id' => 1,
            'good_id'  => 1,
            'quantity' => fake()->randomNumber(2),
            'status'   => CartStatus::IN_PROCESS->value,
        ];
    }
}
