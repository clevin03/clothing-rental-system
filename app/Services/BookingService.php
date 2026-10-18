<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\ItemStatus;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function create(
        User $user,
        Customer $customer,
        Item $item,
        Carbon $startDate,
        Carbon $returnDate,
    ): Booking {
        return DB::transaction(function () use ($user, $customer, $item, $startDate, $returnDate): Booking {
            $item = Item::query()->lockForUpdate()->findOrFail($item->id);

            if ($item->status !== ItemStatus::Available) {
                throw ValidationException::withMessages([
                    'item_id' => 'This clothing item is not currently eligible for rental.',
                ]);
            }

            $hasConflict = Booking::query()
                ->whereHas('bookingItems', fn ($query) => $query->where('item_id', $item->id))
                ->whereIn('status', [BookingStatus::Reserved, BookingStatus::Active])
                ->whereDate('start_date', '<=', $returnDate)
                ->whereDate('expected_return_date', '>=', $startDate)
                ->exists();

            if ($hasConflict) {
                throw ValidationException::withMessages([
                    'item_id' => 'This clothing item is already booked for part of the selected rental period.',
                ]);
            }

            $rentalDays = $startDate->diffInDays($returnDate) + 1;
            $dailyPrice = (float) $item->daily_price;

            if ($rentalDays < 1 || $dailyPrice <= 0) {
                throw ValidationException::withMessages([
                    'item_id' => 'This clothing item does not have a valid rental price.',
                ]);
            }

            $booking = Booking::query()->create([
                'booking_reference' => $this->reference(),
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'start_date' => $startDate,
                'expected_return_date' => $returnDate,
                'status' => BookingStatus::Reserved,
                'total_amount' => round($dailyPrice * $rentalDays, 2),
            ]);

            $booking->bookingItems()->create([
                'item_id' => $item->id,
                'daily_price_at_booking' => $dailyPrice,
            ]);

            return $booking->load(['customer', 'bookingItems.item', 'user']);
        });
    }

    private function reference(): string
    {
        do {
            $reference = 'RNT-'.Str::upper(Str::random(10));
        } while (Booking::query()->where('booking_reference', $reference)->exists());

        return $reference;
    }
}
