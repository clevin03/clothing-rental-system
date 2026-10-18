<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Item;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->with(['customer', 'bookingItems.item'])
            ->latest()
            ->paginate(15);

        return view('bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $customers = Customer::query()->orderBy('name')->get(['id', 'name', 'nic']);
        $items = Item::query()
            ->where('status', ItemStatus::Available)
            ->orderBy('name')
            ->get(['id', 'name', 'category', 'size', 'daily_price']);

        return view('bookings.create', compact('customers', 'items'));
    }

    public function store(Request $request, BookingService $bookingService): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'item_id' => ['required', 'integer', 'exists:items,id'],
            'start_date' => ['required', 'date'],
            'expected_return_date' => ['required', 'date', 'after:start_date'],
        ]);

        $booking = $bookingService->create(
            $request->user(),
            Customer::query()->findOrFail($validated['customer_id']),
            Item::query()->findOrFail($validated['item_id']),
            Carbon::parse($validated['start_date'])->startOfDay(),
            Carbon::parse($validated['expected_return_date'])->startOfDay(),
        );

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', "Booking {$booking->booking_reference} was created successfully.");
    }

    public function show(Booking $booking): View
    {
        $booking->load(['customer', 'user', 'bookingItems.item']);

        return view('bookings.show', compact('booking'));
    }
}
