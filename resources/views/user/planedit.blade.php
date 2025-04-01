<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/plan.css?v=1.0.0') }}"> 

    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>
    <div class="header">
        <h3>Kunlik rejani tahrirlash</h3>
        <p>{{ $date }} uchun</p>
    </div>  
    
    <div class="plan">
        <form method="post" action="{{ route('user.plan.update', ['date' => $date]) }}">
            @csrf
            @method('POST')
            <textarea spellcheck="false" id="textarea" name="content">{{ $content }}</textarea>
            <input type="submit" value="Saqlash">
        </form>
    </div>

    <script>
        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.show();
        tg.onEvent('backButtonClicked', () => {
            window.location.href = "{{ route($back_route) }}";
        });
    </script>
</body>
</html>