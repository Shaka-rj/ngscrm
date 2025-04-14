<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
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

    <!-- tumanlar -->
    <div class="list">
        <div class="item2">
            @foreach($user->districts ?? [] as $district)
                <div class="elm">{{ $district->name }}</div>
            @endforeach
        </div>
        <button class="listbtn add" id="add">Tuman qo'shish</button>
        <div class="item" id="additem">
            <form method="post" action="{{ route('user.baza.district_add') }}" autocomplete="off">
                @csrf
                <input type="text" name="name" placeholder="Tuman nomi">
                <input type="submit" value="Qo'shish" class="add">
            </form>
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
        <hr>
        <button class="listbtn add" id="addo">Obyekt qo'shish</button>
        <div class="item" id="addoitem">
            <form method="post" action="{{ route('user.baza.object_add') }}" autocomplete="off">
                @csrf
                <select name="district">
                    <option value="0">Tumanni tanlang</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="name" placeholder="Obyekt nomi">
                <input type="submit" value="Qo'shish" class="add">
            </form>
        </div>
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

        <hr>
        <button class="listbtn add" id="addt">Shifokor qo'shish</button>
        <div class="item" id="addtitem">
            <form method="post" action="{{ route('user.baza.doctor_add') }}" autocomplete="off">
                @csrf
                <select name="district" id="district">
                    <option value="0">Tumanni tanlang</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
                
                <select id="objects" name="object">
                    <option value="0">Obyektni tanlang</option>>
                </select>
                <input type="text" name="firstname" placeholder="Shifokor ismi" required>
                <input type="text" name="lastname" placeholder="Shifokor familiyasi" required>
                <input type="submit" value="Qo'shish" class="add">
            </form>
        </div>
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
        <hr>
        <button class="listbtn add" id="addo">Dorixona qo'shish</button>
        <div class="item" id="addoitem">
            <form method="post" action="{{ route('user.baza.pharmacy_add') }}" autocomplete="off">
                @csrf
                <select name="district">
                    <option value="0">Tumanni tanlang</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="name" placeholder="Dorixona nomi">
                <input type="submit" value="Qo'shish" class="add">
            </form>
        </div>
    </div>

    @endif
    
    <script>
        $('button').click(function(){
            let btnId = $(this).attr('id');
            $('#'+btnId+'item').slideToggle(200); 
        });
        
        @if ($page == 'doctor')
            {!! $userobjects !!}

            $('#district').change(function(){
                let district = $(this).val();
                let objectselm = $('#objects');
                
                objectselm.empty().append('<option value="">Obyektni tanlang</option>');
                
                if (district in objects){
                    $.each(objects[district],
                          function(index, objects){
                        objectselm.append('<option value="' + objects['id'] + '">' + objects['name'] + '</option>');
                    });
                }
            });
        @endif

        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.show();
        tg.onEvent('backButtonClicked', () => {
            window.location.href = "{{ route('user.main.index') }}";
        });


          const input = document.querySelector('input');
          input.addEventListener('focus', () => {
            setTimeout(() => {
              input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300); // klaviatura ochilishi uchun vaqt beriladi
          });
    </script>
</body>
</html>