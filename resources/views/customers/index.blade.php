<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Directory - Clothing Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Customer Management</h1>
                <p class="text-sm text-gray-600">Search directory, manage profiles, and view rental histories.</p>
            </div>
            <a href="{{ route('customers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2.5 rounded-lg shadow transition">
                + Register New Customer
            </a>
        </div>

        <!-- Success Message Alert -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
            <form method="GET" action="{{ route('customers.index') }}" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by name, phone number, or NIC/Passport..." class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border px-4 py-2.5 text-sm">
                <div class="flex gap-2">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium px-5 py-2.5 rounded-lg text-sm transition">Search</button>
                    @if(!empty($search))
                        <a href="{{ route('customers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2.5 rounded-lg text-sm transition flex items-center justify-center">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Customer Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Phone Number</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIC / Passport</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Address</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('customers.show', $customer->id) }}" class="text-indigo-600 hover:underline">{{ $customer->name }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $customer->nic }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 truncate max-w-xs">{{ $customer->address ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('customers.show', $customer->id) }}" class="text-blue-600 hover:text-blue-900">History</a>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="text-amber-600 hover:text-amber-900">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this customer record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No customer records found. Get started by registering a new customer.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $customers->links() }}
            </div>
        </div>

    </div>
</body>
</html>