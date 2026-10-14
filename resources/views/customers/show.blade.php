<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile & History - Clothing Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
        
        <!-- Back Link -->
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('customers.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center gap-1">
                &larr; Back to Customer Directory
            </a>
            <a href="{{ route('customers.edit', $customer->id) }}" class="bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow transition">
                Edit Profile
            </a>
        </div>

        <!-- Customer Profile Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <div class="border-b border-gray-200 pb-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h1>
                <p class="text-sm text-gray-500">Customer Identity & Contact Overview</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Phone Number</span>
                    <span class="text-base font-medium text-gray-900">{{ $customer->phone }}</span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">NIC / Passport</span>
                    <span class="text-base font-medium text-gray-900">{{ $customer->nic }}</span>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Registered On</span>
                    <span class="text-base font-medium text-gray-900">{{ $customer->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Residential Address</span>
                <p class="text-sm text-gray-700">{{ $customer->address ?? 'No address provided.' }}</p>
            </div>
        </div>

        <!-- Component 4: Historical Rental Transactions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-bold text-gray-900">Rental Transaction History</h2>
                <p class="text-xs text-gray-500">Ongoing rentals, return statuses, and past bookings for this customer.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Booking ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rental Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Return Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($customer->bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">#{{ $booking->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $booking->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                        {{ isset($booking->status) && $booking->status === 'returned' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-850' }}">
                                        {{ ucfirst($booking->status ?? 'Active / Pending') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">${{ number_format($booking->total_amount ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No rental transactions recorded for this customer yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>