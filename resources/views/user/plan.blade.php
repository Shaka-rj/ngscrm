<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/plan.css?v=1.0.0') }}">

    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>
    <div class="header">
        <h3>Kunlik rejalar</h3>
        <p>{{ $date }} uchun</p>
    </div>    
    <div class="content">
        {!! $content !!}
    </div>
    <div class="planlist">
        @if (!isset($noedit))
        <a href="{{ route('user.plan.edit', ['date' => $date]) }}">O'zgartirish</a>
        @endif
    @if (!isset($show))
        @if ($date != $yesterday)
        <a href="{{ route('user.plan.edit', ['date' => $yesterday]) }}">{{ $yesterday }} uchun reja</a>
        @endif

        <h4>Avvalgi rejalar</h4>
        @foreach ($plans as $plan)
            <a href="{{ route('user.plan.show', ['date' => $plan->date_for]) }}">{{ $plan->date_for }}</a>
        @endforeach
    @endif
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