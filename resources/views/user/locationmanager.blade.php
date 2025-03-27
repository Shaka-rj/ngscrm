<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.1') }}">
    <link rel="stylesheet" href="{{ asset('css/location.css?v=1.0.2') }}">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>
    <div class="header">
        <h3>Junatilgan lokatsiyalar</h3>
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
                <a href="{{ route('user.location', ['id' => $user->id]) }}" class="listbtn lista" id="addt">{{ $user->name }} {{ $user->lastname }}</a>
                @endforeach
            </div>
        @endforeach
    </div>
    @else
    <div class="list2"> 
        <h4>Yaqinda junatilganlar</h4>
        @foreach ($locations as $location)
            <div class="item">
                <p class="type">{{ $location['created_at'] }} <b>{{ $types[$location['type']] }}</b></p>

                @if ($location['type'] == 'district')
                <div class="items">
                    <p>Tuman: {{ $location['district'] }}</p>
                </div>
                @elseif ($location['type'] == 'object')
                <div class="items">
                    <p>Tuman: {{ $location['district'] }}</p>
                    <div class="item2">
                        <p>Obyekt: {{ $location['object'] }}</p>
                    </div>
                </div>
                @elseif ($location['type'] == 'doctor')
                    <div class="items">
                        <p>Tuman: {{ $location['district'] }}</p>
                        <div class="item2">
                            <p>Obyekt: {{ $location['object'] }}</p>
                            <div class="item2">
                                <p>Shifokor: {{ $location['doctor'] }}</p>
                            </div>
                        </div>
                    </div>
                @elseif ($location['type'] == 'pharmacy')
                <div class="items">
                    <p>Tuman: {{ $location['district'] }}</p>
                    <div class="item2">
                        <p>Dorixona: {{ $location['pharmacy'] }}</p>
                    </div>
                </div>
                @endif
            </div>
        @endforeach
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
                window.location.href = "{{ route('user.location') }}";
            @endif
        });
    </script>
</body>
</html>