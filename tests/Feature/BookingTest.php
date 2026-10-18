<?php

use App\Enums\BookingStatus;
use App\Enums\ItemStatus;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Item;
use App\Models\User;

function bookingPayload(Customer $customer, Item $item, string $start = '2026-11-10', string $return = '2026-11-12'): array
{
    return [
        'customer_id' => $customer->id,
        'item_id' => $item->id,
        'start_date' => $start,
        'expected_return_date' => $return,
    ];
}

it('creates a booking with an inclusive rental cost and reference', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $item = Item::factory()->create(['daily_price' => 1250]);

    $response = $this->actingAs($user)->post(route('bookings.store'), bookingPayload($customer, $item));

    $booking = Booking::first();
    $response->assertRedirect(route('bookings.show', $booking));
    $response->assertSessionHas('success');
    expect($booking->booking_reference)->toStartWith('RNT-')
        ->and($booking->total_amount)->toBe('3750.00');
    $this->assertDatabaseHas('booking_items', [
        'booking_id' => $booking->id,
        'item_id' => $item->id,
        'daily_price_at_booking' => '1250.00',
    ]);
});

it('rejects missing or invalid customer and item values', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('bookings.store'), [
        'customer_id' => 99999,
        'item_id' => 99999,
        'start_date' => '2026-11-10',
        'expected_return_date' => '2026-11-12',
    ])->assertSessionHasErrors(['customer_id', 'item_id']);
});

it('rejects missing dates and invalid date order', function (string $return, array $errors) {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();

    $this->actingAs($user)->post(route('bookings.store'), bookingPayload($customer, $item, '2026-11-10', $return))
        ->assertSessionHasErrors($errors);
})->with([
    ['', ['expected_return_date']],
    ['2026-11-10', ['expected_return_date']],
    ['2026-11-09', ['expected_return_date']],
]);

it('rejects missing required fields', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('bookings.store'), [])
        ->assertSessionHasErrors(['customer_id', 'item_id', 'start_date', 'expected_return_date']);
});

it('rejects an overlapping booking but permits a non-overlapping period', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();
    $existing = Booking::factory()->create([
        'start_date' => '2026-11-10',
        'expected_return_date' => '2026-11-12',
    ]);
    $existing->bookingItems()->create(['item_id' => $item->id, 'daily_price_at_booking' => $item->daily_price]);

    $this->actingAs($user)->post(route('bookings.store'), bookingPayload($customer, $item, '2026-11-12', '2026-11-14'))
        ->assertSessionHasErrors('item_id');

    $this->actingAs($user)->post(route('bookings.store'), bookingPayload($customer, $item, '2026-11-13', '2026-11-14'))
        ->assertRedirect();
});

it('allows the same dates for a different item', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $first = Item::factory()->create();
    $second = Item::factory()->create();
    $existing = Booking::factory()->create();
    $existing->bookingItems()->create(['item_id' => $first->id, 'daily_price_at_booking' => $first->daily_price]);

    $this->actingAs($user)->post(route('bookings.store'), bookingPayload($customer, $second))
        ->assertRedirect();
});

it('allows a cancelled booking period to be booked again', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $item = Item::factory()->create();
    $existing = Booking::factory()->create(['status' => BookingStatus::Cancelled]);
    $existing->bookingItems()->create(['item_id' => $item->id, 'daily_price_at_booking' => $item->daily_price]);

    $this->actingAs($user)->post(route('bookings.store'), bookingPayload($customer, $item))
        ->assertRedirect();
});

it('rejects items that are not eligible for rental', function () {
    $user = User::factory()->create();
    $customer = Customer::factory()->create();
    $item = Item::factory()->create(['status' => ItemStatus::UnderMaintenance]);

    $this->actingAs($user)->post(route('bookings.store'), bookingPayload($customer, $item))
        ->assertSessionHasErrors('item_id');
});

it('blocks inactive and unauthenticated staff', function () {
    $payload = bookingPayload(Customer::factory()->create(), Item::factory()->create());

    $this->post(route('bookings.store'), $payload)->assertRedirect();
    $this->actingAs(User::factory()->create(['is_active' => false]))
        ->post(route('bookings.store'), $payload)
        ->assertForbidden();
});
