<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Catalogue - Clothing Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-900">Clothing Catalogue</h1>
            <p class="text-gray-600 mt-1">Explore and rent top quality clothing items for any occasion.</p>
        </div>

        <!-- Search and Filter Bar -->
        <form method="GET" action="{{ route('catalog') }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search clothing..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <!-- Category Filter -->
                <div>
                    <select name="category" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Size Filter -->
                <div>
                    <select name="size" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Sizes</option>
                        <option value="S" @selected(request('size') === 'S')>Small (S)</option>
                        <option value="M" @selected(request('size') === 'M')>Medium (M)</option>
                        <option value="L" @selected(request('size') === 'L')>Large (L)</option>
                        <option value="XL" @selected(request('size') === 'XL')>Extra Large (XL)</option>
                    </select>
                </div>
                <!-- Availability Filter -->
                <div>
                    <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">All Availability</option>
                        <option value="available" @selected(request('status') === 'available')>Available</option>
                        <option value="rented" @selected(request('status') === 'rented')>Rented</option>
                        <option value="under_maintenance" @selected(request('status') === 'under_maintenance')>Under Maintenance</option>
                    </select>
                </div>
                <!-- Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">Filter</button>
                    <a href="{{ route('catalog') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50">Reset</a>
                </div>
            </div>
        </form>

        <!-- Clothing Grid Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($items ?? [] as $item)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition duration-200 border border-gray-100 overflow-hidden flex flex-col">
                    <!-- Image with Badge -->
                    <div class="relative h-64 bg-gray-100">
                        <img src="{{ $item->image_path ? asset('storage/'.$item->image_path) : 'https://placehold.co/300x400?text=No+Image' }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        <span class="absolute top-3 right-3 text-xs font-semibold px-2.5 py-1 rounded-full {{ $item->status === \App\Enums\ItemStatus::Available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $item->status->value)) }}
                        </span>
                    </div>

                    <!-- Item Details -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600">{{ $item->category }}</span>
                                <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600 font-medium">Size: {{ $item->size }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-indigo-600 transition">{{ $item->name }}</h3>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-gray-500">Rental Price</span>
                                <p class="text-lg font-extrabold text-indigo-600">LKR {{ number_format($item->daily_price, 2) }} <span class="text-xs text-gray-500 font-normal">/ day</span></p>
                            </div>
                            <a href="#" class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Demo Card (In case DB items are empty) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="relative h-64 bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1594938298603-c8148c4dae35?q=80&w=500" alt="Men Blazer" class="w-full h-full object-cover">
                        <span class="absolute top-3 right-3 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-800">Available</span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Formal</span>
                                <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600 font-medium">Size: L</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Classic Black Tuxedo</h3>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-gray-500">Rental Price</span>
                                <p class="text-lg font-extrabold text-indigo-600">LKR 3,500 <span class="text-xs text-gray-500 font-normal">/ day</span></p>
                            </div>
                            <button class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition">View Details</button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>