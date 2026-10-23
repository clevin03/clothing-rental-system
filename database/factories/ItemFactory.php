<?php

namespace Database\Factories;

use App\Enums\ItemStatus;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Classic Black Tuxedo', 'Navy Blazer', 'Evening Gown', 'Party Dress', 'Casual Linen Shirt', 'Wedding Saree', 'Formal Suit']),
            'category' => fake()->randomElement(['formal', 'casual', 'party']),
            'size' => fake()->randomElement(['S', 'M', 'L', 'XL']),
            'color' => fake()->safeColorName(),
            'daily_price' => fake()->randomElement([1500, 2500, 3500, 5000]),
            'condition' => fake()->randomElement(['new', 'good', 'fair']),
            'image_path' => null,
            'status' => fake()->randomElement(ItemStatus::cases())->value,
        ];
    }
}
