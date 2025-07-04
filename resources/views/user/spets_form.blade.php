<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/spets.css?v=1.0.3') }}">

    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>
    <div class="spets-container">
        <div class="special-price">
            <a href="{{ route('user.spets.create2') }}">Maxsus narx buyicha hisoblash</a>
        </div>
        <br>
        <form id="form" method="POST" action="{{ route('user.spets.store') }}">
            @csrf
            <input type="hidden" name="type_price" value="0">
            @foreach ($products as $product)
                <div class="item m">
                    <div class="info">
                        <div class="name">
                            {{ $product->name }}
                        </div>
                        <div class="price">
                            {{ number_format($product->price_after_vat, 2, '.', ' ') }}
                        </div>
                    </div>
                    <div class="result">
                        <div class="input">
                            <input type="number" class="user-input" name="s{{ $loop->iteration }}">
                            <input type="hidden" name="id{{ $loop->iteration }}" value="{{ $product->id }}">
                            <p id="n{{ $loop->iteration }}" hidden>{{ $product->price_after_vat }}</p>
                        </div>
                        <div class="summ">
                            <span id="m{{ $loop->iteration }}">0.00</span>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            
            <div class="all-summ">
                <span id="jami">0.00</span>
            </div>

            <div class="after_pay">
                <h4>Oldindan to'lov</h4>
                <input type="radio" id="100p" name="after_pay" value="100" checked>
                <label for="100p">100%</label><br>
                <input type="radio" id="50p" name="after_pay" value="50">
                <label for="50p">50%</label><br>
            </div>
            
            
            <div class="company">
                <select name="company">
                    <option value="2">{{ config('companies.2.name') }}</option>
                    <option value="1">{{ config('companies.1.name') }}</option>
                    <option value="3">{{ config('companies.3.name') }}</option>
                </select> 
            </div>
            
            
            <div class="customer">
                <h4>Haridor</h4>
                <input type="text" name="customer">
            </div>
            
            <div class="submit">
                <input type="submit" value="Yaratish">
            </div>
        </form>
    </div>
    
    <script>
        let form = document.getElementById('form');
        let m_count = form.getElementsByClassName('m').length;
        const inputs = document.getElementsByClassName('user-input');
        const after_pay = document.getElementById('50p');
        
        let MaxsulotNarx = {};
        function maxsulothisob(){
            for (let i=1; i<=m_count; i++){
                let narx = parseFloat(document.getElementById('n' + i).innerHTML);
                MaxsulotNarx[i] = narx;
                inputs[i-1].addEventListener('input', hisoblash);
            }
        }
        
        maxsulothisob();
        
        
        function hisoblash(){
            let summa = 0;
            for (let i=1; i<=m_count; i++){
                let soni = parseFloat(inputs[i-1].value);
                if (isNaN(soni))
                    soni = 0;
                let narxi = soni * MaxsulotNarx[i];
                
                
                summa = summa + narxi;
                narxi = narxi.toFixed(2);
                
                document.getElementById('m' + i).innerHTML = narxi.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
            }   

            document.getElementById('jami').innerHTML = summa.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');         
        }

        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.show();
        tg.onEvent('backButtonClicked', () => {
            window.location.href = "{{ route('user.main.index') }}";
        });
    </script>
</body>
</html>