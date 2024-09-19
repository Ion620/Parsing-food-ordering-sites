<?php

namespace Database\Factories;

use App\Models\Enums\GoodsStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goods>
 */
class GoodsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = GoodsStatus::cases();
        return [
            'name'        => fake()->text(15),
            'description' => fake()->text(30),
            'price'       => fake()->randomNumber(5),
            'status'      => fake()->randomElement($status),
            'category'    => fake()->text(10),
            'image'       => fake()->imageUrl(),
            'data'        => fake()->text(5),
        ];
    }
}
