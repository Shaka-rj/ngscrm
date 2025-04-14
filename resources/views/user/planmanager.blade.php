<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/main.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/plan.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('css/baza.css?v=1.0.0') }}">

    <script src="https://telegram.org/js/telegram-web-app.js?56"></script>
</head>
<body>
    <div class="header">
        <h3>{{ $pagename }}</h3>
    </div>
    @if (isset($user))
    <div class="header">
        <h3>{{ $user->name.' '.$user->lastname }}</h3>
    </div>
    @endif
    <br>

    @if (isset($users))
    <div class="list">
        @foreach ($users as $region)
            <div class="item2">
                <div class="elm name">{{ $region->name }}</div> 
                @foreach ($region->users as $user)
                <a href="{{ route('user.plan.user', ['id' => $user->id]) }}" class="listbtn lista" id="addt">{{ $user->name }} {{ $user->lastname }}</a>
                @endforeach
            </div>
        @endforeach
    </div>
    @else

    <div class="content">
        {!! $content !!}
    </div>
    <div class="planlist">
    @if (!isset($show))
        <h4>Avvalgi rejalar</h4>
        @foreach ($plans as $plan)
            <a href="{{ route('user.plan.user', ['id' => $id, 'date' => $plan->date_for]) }}">{{ $plan->date_for }}</a>
        @endforeach
    @endif
    </div>
    @endif
    
    <script>
        //telegram backbutton
        let tg = window.Telegram.WebApp;
        tg.BackButton.show();
        tg.onEvent('backButtonClicked', () => {
            window.location.href = "{{ $back_route }}";
        });
    </script>
</body>
</html>