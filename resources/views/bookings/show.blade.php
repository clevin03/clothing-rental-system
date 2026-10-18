<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $booking->booking_reference }} - Clothing Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <main class="mx-auto max-w-3xl px-4 py-8">
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800" role="status">{{ session('success') }}</div>
        @endif
        <div class="mb-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-indigo-600">Booking confirmation</p>
                <h1 class="text-3xl font-bold text-gray-900">{{ $booking->booking_reference }}</h1>
            </div>
            <a href="{{ route('bookings.index') }}" class="text-indigo-600 hover:text-indigo-800">All bookings</a>
        </div>
        <div class="grid gap-4 rounded-xl bg-white p-6 shadow-sm sm:grid-cols-2">
            <div><p class="text-sm text-gray-500">Customer</p><p class="font-semibold">{{ $booking->customer->name }}</p></div>
            <div><p class="text-sm text-gray-500">Clothing item</p><p class="font-semibold">{{ $booking->bookingItems->first()?->item?->name }}</p></div>
            <div><p class="text-sm text-gray-500">Rental period</p><p class="font-semibold">{{ $booking->start_date->format('d M Y') }} - {{ $booking->expected_return_date->format('d M Y') }}</p></div>
            <div><p class="text-sm text-gray-500">Status</p><p class="font-semibold capitalize">{{ $booking->status->value }}</p></div>
            <div><p class="text-sm text-gray-500">Total rental cost</p><p class="font-semibold">LKR {{ number_format((float) $booking->total_amount, 2) }}</p></div>
            <div><p class="text-sm text-gray-500">Created by</p><p class="font-semibold">{{ $booking->user->name }}</p></div>
        </div>
    </main>
</body>
</html>
