<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Rental System</title>
</head>
<body>
    <h1>Welcome to the Clothing Rental System</h1>
    <p>Browse our clothing collection.</p>

    <a href="{{ url('/catalog') }}">View Catalog</a>
    <a href="{{ route('bookings.index') }}">View Bookings</a>
</body>
</html>
