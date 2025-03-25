<html>
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="nav">
        <a href="{{ route('admin.user.list') }}">
            <div class="item">
                <img src="{{ asset('img/icon/users.svg') }}" class="svg-color"><br>
                <span>Hodimlar</span>
            </div>
        </a>
        
        <a href="{{ route('admin.products.index') }}">
            <div class="item">
                <img src="{{ asset('img/icon/medicine.svg') }}" class="svg-color"><br>
                <span>Mahsulotlar</span>
            </div>
        </a>
    </div>
</body>
</html>