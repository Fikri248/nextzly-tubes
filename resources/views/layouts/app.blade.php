<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Premium Digital Catalog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS custom -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <a class="navbar-brand" href="/">Premium Catalog</a>
    <div>
      <a href="/">Home</a>
      <a href="/apps">Apps</a>
    </div>
</nav>
<div class="container">
    @yield('content')
</div>
<footer>
    <div>
        <b>Kontak:</b> WhatsApp | Shopee | Email
    </div>
    <div>
        &copy; {{ date('Y') }} Nextzly Digital Premium
    </div>
</footer>
</body>
</html>
