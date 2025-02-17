<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Produk')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>My Shop</h1>
    </header>
    
    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} My Shop</p>
    </footer>
</body>
</html>
