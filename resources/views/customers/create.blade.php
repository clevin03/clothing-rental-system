<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Customer - Clothing Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
        
        <!-- Back Link -->
        <div class="mb-6">
            <a href="{{ route('customers.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center gap-1">
                &larr; Back to Customer Directory
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Register New Customer</h1>
                <p class="text-sm text-gray-600">Enter the customer's personal and contact details below.</p>
            </div>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                    <p class="font-semibold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Registration Form -->
            <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border px-4 py-2.5 text-sm">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="e.g., 0771234567" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border px-4 py-2.5 text-sm">
                    </div>

                    <div>
                        <label for="nic" class="block text-sm font-medium text-gray-700 mb-1">NIC / Passport Number *</label>
                        <input type="text" name="nic" id="nic" value="{{ old('nic') }}" required placeholder="National ID or Passport" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border px-4 py-2.5 text-sm">
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Residential Address</label>
                    <textarea name="address" id="address" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 border px-4 py-2.5 text-sm" placeholder="Street address, city...">{{ old('address') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('customers.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-5 py-2.5 rounded-lg text-sm transition">Cancel</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm transition shadow">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>