<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/location.css?v=1.0.0') }}">
</head>
<body>
    <div class="header">
        <h3>Lokatsiya junatish</h3>
        <p>Turini tanlang</p>
    </div>
    <div class="b">
        <div class="b1">
            <div class="b2">
                <a href="{{ route('user.location.district') }}">
                    <div class="image">
                        <img src="{{ asset('img/icon/city.png') }}">
                    </div>
                    <div class="name">
                        Tumanga kelganlik
                    </div>
                </a>
            </div>
            
            <div class="b2">
                <a href="{{ route('user.location.object') }}">
                    <div class="image">
                        <img src="{{ asset('img/icon/hospital.png') }}">
                    </div>
                    <div class="name">
                        Obyektga kelganlik
                    </div>
                </a>
            </div>
        </div>
        
        <div class="b1">
            <div class="b2">
                <a href="{{ route('user.location.doctor') }}">
                    <div class="image">
                        <img src="{{ asset('img/icon/doctor.png') }}">
                    </div>
                    <div class="name">
                        Shifokorga kelganlik
                    </div>
                </a>
            </div>
            
            <div class="b2">
                <a href="{{ route('user.location.pharmacy') }}">
                    <div class="image">
                        <img src="{{ asset('img/icon/pharmacy.png') }}">
                    </div>
                    <div class="name">
                        Dorixonaga kelganlik
                    </div>
                </a>
            </div>            
        </div>
    </div>
    <div class="list"> 
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
    </div>
</body>
</html>