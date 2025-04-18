<html>
<head>
    <title>@yield('title', 'Users')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/admin_users.css') }}">
</head>

<body>
    @include('admin.layouts.topnav')
    <div class="container">
        @include('admin.layouts.navigation')
        @yield('content')
    </div>
</body>
</html>