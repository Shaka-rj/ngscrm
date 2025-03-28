<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/baza.css?v=1.0.0') }}">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>
    <div class="header">
        <h3>{{ $pagename }}</h3>
    </div>
    <br>
    @if ($page == "district")

    <div class="list">
        <div class="item2">
            @foreach($user->districts ?? [] as $district)
                <button class="listbtn" data-id="{{ $district->id }}">{{ $district->name }}</button>
            @endforeach
        </div>
    </div>

    @elseif ($page == "object")

    <div class="list">
        @foreach($districts as $district)
            @if ($district->userobjects->isNotEmpty())
            <div class="item2">
                <div class="elm name">{{ $district->name }}</div> 
                <hr>
                @foreach ($district->userobjects as $object)
                    <button class="listbtn" data-id="{{ $object->id }}">{{ $object->name }}</button>
                @endforeach
            </div>
            @endif
        @endforeach
    </div>

    @elseif ($page == 'doctor')

    <div class="list">
        @foreach ($districts as $district)
            @if ($district->userobjects->isNotEmpty())
            <div class="item2">
                <div class="elm name">{{ $district->name }}</div> 
                <hr>
                @foreach ($district->userobjects as $object)
                    @if ($object->doctors->isNotEmpty())
                    <div class="item2">
                        <div class="elm name2">{{ $object->name }}</div> 
                        <hr>
                        @foreach ($object->doctors as $doctor)
                            <button class="listbtn" data-id="{{ $doctor->id }}">{{ $doctor->firstname }} {{ $doctor->lastname }}</button>
                        @endforeach
                    </div>
                    @endif
                @endforeach
            </div>
            @endif
        @endforeach
    </div>
    @elseif ($page == 'pharmacy')

    <div class="list">
        @foreach($districts as $district)
            @if ($district->pharmacies->isNotEmpty())
            <div class="item2">
                <div class="elm name">{{ $district->name }}</div> 
                <hr>
                @foreach ($district->pharmacies as $pharmacy)
                    <button class="listbtn" data-id="{{ $pharmacy->id }}">{{ $pharmacy->name }}</button>
                @endforeach
            </div>
            @endif
        @endforeach
    </div>

    @endif
    
    <script>
        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.show();
        tg.onEvent('backButtonClicked', () => {
            window.location.href = "{{ route('user.location') }}";
        });


        $('button').click(function(){
            tg.showPopup({
                message: "⏳ Yuborilmoqda...",
                buttons: [
                    { text: "Bekor qilish", type: 'close' }
                ]
            });

            let type_id = $(this).data('id');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    $.ajax({
                        url: '{{ route('user.location.store') }}',
                        type: 'POST',
                        data: {
                            user_id: {{ $user->id }},
                            type: '{{ $page }}',
                            type_id: type_id,
                            latitude: latitude,
                            longitude: longitude
                        },
                        headers: {
                            'Authorization': 'Bearer {{ $api_token }}'
                        },
                        success: function(response) {
                            tg.closePopup();
                            tg.showPopup({
                                message: "Saqlandi.",
                                buttons: [
                                    { text: "Ilovani yopish", type: 'close' }
                                ]
                            });
                        },
                        error: function(xhr, status, error) {
                            alert('Xatolik: ' + xhr.responseText);
                        }
                    });

                }, function(error) {
                    alert('Geolokatsiyani olishda xatolik: ' + error.message);
                });
            } else {
                alert('Brauzeringiz Geolocation API ni qo‘llab-quvvatlamaydi.');
            }
        });
    </script>
</body>
</html>