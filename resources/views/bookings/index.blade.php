<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Clothing Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <main class="mx-auto max-w-6xl px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Rental Bookings</h1>
                <p class="mt-1 text-gray-600">View and manage clothing reservations.</p>
            </div>
            <a href="{{ route('bookings.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-700">New booking</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-600 hover:text-gray-900">Log out</button>
            </form>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800" role="status">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-xl bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3">Reference</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Item</th>
                            <th class="px-4 py-3">Rental period</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr class="border-t">
                                <td class="px-4 py-3"><a class="font-semibold text-indigo-600" href="{{ route('bookings.show', $booking) }}">{{ $booking->booking_reference }}</a></td>
                                <td class="px-4 py-3">{{ $booking->customer->name }}</td>
                                <td class="px-4 py-3">{{ $booking->bookingItems->first()?->item?->name ?? '—' }}</td>
                                <td class="px-4 py-3">{{ $booking->start_date->format('d M Y') }} - {{ $booking->expected_return_date->format('d M Y') }}</td>
                                <td class="px-4 py-3 capitalize">{{ $booking->status->value }}</td>
                                <td class="px-4 py-3">LKR {{ number_format((float) $booking->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No bookings have been created.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">{{ $bookings->links() }}</div>
        </div>
    </main>
</body>
</html>
