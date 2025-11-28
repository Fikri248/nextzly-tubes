<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nextzly Tubes</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar">
        <a class="navbar-brand" href="{{ route('home') }}">Nextzly</a>
        <div class="navbar-menu">
            <a href="{{ route('home') }}">Home</a>
            <a href="#">Contact</a>
        </div>
    </nav>

    @yield('content')

</body>
</html>
