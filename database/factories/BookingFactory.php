<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_reference' => 'RNT-'.fake()->unique()->bothify('##########'),
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'start_date' => now()->addDays(1)->toDateString(),
            'expected_return_date' => now()->addDays(3)->toDateString(),
            'status' => BookingStatus::Reserved,
            'total_amount' => 3000,
        ];
    }
}
