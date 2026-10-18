<?php

namespace Database\Factories;

use App\Models\BookingItem;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BookingItem>
 */
class BookingItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'item_id' => Item::factory(),
            'daily_price_at_booking' => 1000,
        ];
    }
}
