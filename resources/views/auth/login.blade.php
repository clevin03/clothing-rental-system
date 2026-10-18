<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - Clothing Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-50 px-4 text-gray-800">
    <main class="w-full max-w-md rounded-xl bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-gray-900">Staff Login</h1>
        <p class="mt-1 text-gray-600">Sign in to access rental bookings.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="username" class="mb-1 block font-medium">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus class="w-full rounded-lg border px-3 py-2">
            </div>
            <div>
                <label for="password" class="mb-1 block font-medium">Password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-lg border px-3 py-2">
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input name="remember" type="checkbox" value="1">
                Remember me
            </label>
            <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-3 font-semibold text-white hover:bg-indigo-700">
                Sign in
            </button>
        </form>
    </main>
</body>
</html>
