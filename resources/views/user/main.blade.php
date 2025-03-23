<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.2') }}">
</head>
<body>
    <div class="header">
        <h3>BIONYX</h3>
        <p></p>
    </div>
    <div class="b">
        <!--
        <div class="b1">
            <div class="b2">
                <div class="b3">
                    <div class="b4">
                        <a href="#">
                            <div class="image">
                                <img src="{{ asset('img/icon/city.png') }}">
                            </div>
                            <div class="name">
                                Tuman
                            </div>
                        </a>
                    </div>
                    
                    <div class="b4">
                        <a href="#">
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
                        <a href="#">
                            <div class="image">
                                <img src="{{ asset('img/icon/doctor.png') }}">
                            </div>
                            <div class="name">
                                Shifokor
                            </div>
                        </a>
                    </div>
                    
                    <div class="b4">
                        <a href="#">
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
                <a href="#">
                    <div class="image">
                        <img src="{{ asset('img/icon/location.png')}}">
                    </div>
                    <div class="name">
                        Lokatsiya
                    </div>
                </a>
            </div>
        </div>
        -->
        
        <div class="b1">
            <div class="b2">
            
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
</body>
</html>