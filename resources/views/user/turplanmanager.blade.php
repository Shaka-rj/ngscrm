<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/turplan.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/baza.css?v=1.0.0') }}">
    
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="header">
        <h3>{{ $pagename }}</h3>
        @if (isset($month_name))
        <p>{{ $month_name }} oyi uchun</p>
        @endif
    </div>
    <br>

    @if (isset($users))
    <div class="list">
        @foreach ($users as $region)
            <div class="item2">
                <div class="elm name">{{ $region->name }}</div> 
                @foreach ($region->users as $user)
                <a href="{{ route('user.turplan.user', ['id' => $user->id]) }}" class="listbtn lista" id="addt">{{ $user->name }} {{ $user->lastname }}</a>
                @endforeach
            </div>
        @endforeach
    </div>
    @else
    
    <div class="list">
        @foreach ($list as $district)
            <div class="item2">
                <div class="elm2 name">{{ $district['name'] }}</div>
                @empty($district['pharmacies'] )

                @else
                    <div class="elm">{{ number_format($district['amount']) }}</div>
                    <hr>
                    <div class="elm"><h5>Dorixona</h5><h5>Oylik summa</h5></div>
                    @foreach ($district['pharmacies'] as $pharmacy)
                        <div class="elm"><span>{{ $pharmacy['name'] }}</span><input type="text" class="format" value="{{ number_format($pharmacy['amount']) }}" readonly></div> 
                    @endforeach
                @endempty
            </div>
        @endforeach
    </div>
    @endif
    <script>
        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.show();
        tg.onEvent('backButtonClicked', () => {
            window.location.href = "{{ route('user.main.index') }}";
        });
    </script>
</body>
</html>
