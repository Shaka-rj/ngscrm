<html>
<head>
    <title>@yield('title', 'Products')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="top-nav">
        <a href="#">Hodimlar</a>
        <a href="#">Mahsulotlar</a>
        <a href="#">Chiqish</a>
    </div>
    <div class="main">
        @yield('content')
    </div>
</body>
</html>