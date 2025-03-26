<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.1') }}">
    <link rel="stylesheet" href="{{ asset('css/baza.css?v=1.0.2') }}">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>
    <div class="header">
        <h3>{{ $pagename }}</h3>
    </div>
    @if (isset($user))
    <div class="header">
        <h3>{{ $user->name.' '.$user->lastname }}</h3>
    </div>
    @endif
    <br>

    @if ($page == "selectuser")
    <div class="list">
        @foreach ($users as $region)
            <div class="item2">
                <div class="elm name">{{ $region->name }}</div> 
                @foreach ($region->users as $user)
                <a href="{{ route('user.baza.'.$type, ['id' => $user->id]) }}" class="listbtn lista" id="addt">{{ $user->name }} {{ $user->lastname }}</a>
                @endforeach
            </div>
        @endforeach
    </div>

    @elseif ($page == "district")
    <!-- tumanlar -->
    <div class="list">
        <div class="item2">
            @foreach($user->districts ?? [] as $district)
                <div class="elm">{{ $district->name }}</div>
            @endforeach
        </div>
    </div>

    @elseif ($page == "object")

    <div class="list">
        @foreach($districts as $district)
            <div class="item2">
                <div class="elm name">{{ $district->name }}</div> 
                <hr>
                @if ($district->userobjects->isNotEmpty())
                @foreach ($district->userobjects as $object)
                    <div class="elm">{{ $object->name }}</div> 
                @endforeach
                @else
                <div class="elm">Bu tumanda obyekt yo'q</div>
                @endif
            </div>
        @endforeach
    </div>

    @elseif ($page == 'doctor')

    <div class="list">
        @foreach ($districts as $district)
        <div class="item2">
            <div class="elm name">{{ $district->name }}</div> 
            <hr>
            @foreach ($district->userobjects as $object)
                <div class="item2">
                    <div class="elm name2">{{ $object->name }}</div> 
                    <hr>
                    @foreach ($object->doctors as $doctor)
                        <div class="elm">{{ $doctor->firstname }} {{ $doctor->lastname }}</div>
                    @endforeach
                </div>
            @endforeach
        </div>
        @endforeach
    </div>
    @elseif ($page == 'pharmacy')

    <div class="list">
        @foreach($districts as $district)
            <div class="item2">
                <div class="elm name">{{ $district->name }}</div> 
                <hr>
                @if ($district->pharmacies->isNotEmpty())
                @foreach ($district->pharmacies as $pharmacy)
                    <div class="elm">{{ $pharmacy->name }}</div> 
                @endforeach
                @else
                <div class="elm">Bu tumanda dorixona yo'q</div>
                @endif
            </div>
        @endforeach
    </div>

    @endif
    
    <script>
        $('button').click(function(){
            let btnId = $(this).attr('id');
            $('#'+btnId+'item').slideToggle(200); 
        });


        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.show();
        tg.onEvent('backButtonClicked', () => {
            @if(isset($users))
                window.location.href = "{{ route('user.main.index') }}";
            @else
                window.location.href = "{{ route('user.baza.'.$page) }}";
            @endif
        });
    </script>
</body>
</html>