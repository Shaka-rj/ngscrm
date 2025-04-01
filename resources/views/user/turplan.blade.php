<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/turplan.css?v=1.0.0') }}">
    
    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="header">
        <h3>Tur plan</h3>
        <p>{{ $month_name }} oyi uchun</p>
    </div>
    <br>
    
    <div class="list">
        <a href="{{ route('user.turplan.edit', ['month_id' => $month]) }}" class="aedit">Tahrirlash</a>

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
    
    <script>
        $(document).ready(function() {
            $('.format').on('input', function() {
                var $this = $(this);
                var value = $this.val().replace(/,/g, '');

                if (!isNaN(value) && value !== '') {
                    var formattedValue = Number(value).toLocaleString('en-US');
                    $this.val(formattedValue);
                }
            });

            $('.format').on('keydown', function(e) {
                if (e.key.length === 1 && !/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });

        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.show();
        tg.onEvent('backButtonClicked', () => {
            window.location.href = "{{ route('user.main.index') }}";
        });
    </script>
</body>
</html>