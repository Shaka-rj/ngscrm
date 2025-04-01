<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.4') }}">
    
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>
    <div class="header">
        <h3>BIONYX</h3>
        <p></p>
    </div>
    <br>
    <div class="b">
        <div class="b1">
            <div class="b2">
                <div class="b3 b6" style="margin-bottom: 10px;">
                    <a href="{{ route('user.plan.index') }}" class="b5">
                        <div class="image">
                            <img src="{{ asset('img/icon/checklist.png') }}">
                        </div>
                        <div class="name">
                            Reja
                        </div>
                    </a>
                </div>
                <div class="b3 b6">
                    <a href="{{ route('user.turplan.index') }}" class="b5">
                        <div class="image">
                            <img src="{{ asset('img/icon/calendar.png') }}">
                        </div>
                        <div class="name">
                            Tur plan
                        </div>
                    </a>
                </div>
                
            </div>

            <div class="b2">
                <a href="{{ route('user.location') }}">
                    <div class="image">
                        <img src="{{ asset('img/icon/location.png')}}">
                    </div>
                    <div class="name">
                        Lokatsiya
                    </div>
                </a>
            </div>
        </div>
        <div class="b1">
            <div class="b2">
                <div class="b3">
                    <div class="b4">
                        <a href="{{ route('user.baza.district') }}">
                            <div class="image">
                                <img src="{{ asset('img/icon/city.png') }}">
                            </div>
                            <div class="name">
                                Tuman
                            </div>
                        </a>
                    </div>
                    
                    <div class="b4">
                        <a href="{{ route('user.baza.object') }}">
                            <div class="image">
                                <img src="{{ asset('img/icon/hospital.png') }}">
                            </div>
                            <div class="name">
                                Obyekt
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="b3">
                    <div class="b4">
                        <a href="{{ route('user.baza.doctor') }}">
                            <div class="image">
                                <img src="{{ asset('img/icon/doctor.png') }}">
                            </div>
                            <div class="name">
                                Shifokor
                            </div>
                        </a>
                    </div>
                    
                    <div class="b4">
                        <a href="{{ route('user.baza.pharmacy') }}">
                            <div class="image">
                                <img src="{{ asset('img/icon/pharmacy.png') }}">
                            </div>
                            <div class="name">
                                Dorixona
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="b2">
                <a href="{{ route('user.spets.create') }}">
                    <div class="image">
                        <img src="{{ asset('img/icon/spets.png') }}">
                    </div>
                    <div class="name">
                        Spetsfikatsiya
                    </div>
                </a>
            </div>

        </div>
    </div>

    <script>
        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.hide();
    </script>
</body>
</html>