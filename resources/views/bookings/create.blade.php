<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking - Clothing Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <main class="mx-auto max-w-3xl px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create Rental Booking</h1>
                <p class="mt-1 text-gray-600">Reserve an available clothing item for a registered customer.</p>
            </div>
            <a href="{{ route('bookings.index') }}" class="text-indigo-600 hover:text-indigo-800">All bookings</a>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800" role="alert">
                <p class="font-semibold">Please correct the following errors:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6 rounded-xl bg-white p-6 shadow-sm">
            @csrf
            <div>
                <label for="customer_id" class="mb-1 block font-medium">Customer</label>
                <select id="customer_id" name="customer_id" required class="w-full rounded-lg border px-3 py-2">
                    <option value="">Select a customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                            {{ $customer->name }} ({{ $customer->nic }})
                        </option>
                    @endforeach
                </select>
                @error('customer_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="item_id" class="mb-1 block font-medium">Clothing item</label>
                <select id="item_id" name="item_id" required class="w-full rounded-lg border px-3 py-2">
                    <option value="">Select an available item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-price="{{ $item->daily_price }}" @selected(old('item_id') == $item->id)>
                            {{ $item->name }} - {{ $item->category }} / {{ $item->size }} (LKR {{ number_format($item->daily_price, 2) }}/day)
                        </option>
                    @endforeach
                </select>
                @error('item_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="start_date" class="mb-1 block font-medium">Rental start date</label>
                    <input id="start_date" name="start_date" type="date" value="{{ old('start_date') }}" required class="w-full rounded-lg border px-3 py-2">
                    @error('start_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="expected_return_date" class="mb-1 block font-medium">Expected return date</label>
                    <input id="expected_return_date" name="expected_return_date" type="date" value="{{ old('expected_return_date') }}" required class="w-full rounded-lg border px-3 py-2">
                    @error('expected_return_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="rounded-lg bg-indigo-50 p-4 text-indigo-900">
                <p>Estimated rental days: <strong id="rental-days">-</strong></p>
                <p>Estimated total: <strong id="rental-total">LKR 0.00</strong></p>
                <p class="mt-1 text-sm">The final amount is recalculated securely when the booking is saved.</p>
            </div>

            <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-3 font-semibold text-white hover:bg-indigo-700">
                Create booking
            </button>
        </form>
    </main>
    <script>
        const item = document.getElementById('item_id');
        const start = document.getElementById('start_date');
        const end = document.getElementById('expected_return_date');
        const days = document.getElementById('rental-days');
        const total = document.getElementById('rental-total');

        function updateEstimate() {
            const price = Number(item.selectedOptions[0]?.dataset.price || 0);
            const startDate = start.value ? new Date(`${start.value}T00:00:00`) : null;
            const endDate = end.value ? new Date(`${end.value}T00:00:00`) : null;
            const rentalDays = startDate && endDate ? Math.floor((endDate - startDate) / 86400000) + 1 : 0;
            days.textContent = rentalDays > 0 ? rentalDays : '-';
            total.textContent = rentalDays > 0 ? `LKR ${(price * rentalDays).toFixed(2)}` : 'LKR 0.00';
        }

        [item, start, end].forEach((field) => field.addEventListener('change', updateEstimate));
        updateEstimate();
    </script>
</body>
</html>
