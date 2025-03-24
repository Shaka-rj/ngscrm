<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/admin_users.css') }}">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="top-nav">
        <a href="#">Hodimlar</a>
        <a href="#">Mahsulotlar</a>
        <a href="#">Chiqish</a>
    </div>
    <div class="container">
        <div class="navigation">
            <a href="#">Ro'yxat</a>
            <a href="#" class="active">Kirish so'rovlari</a>
        </div>
        <div class="content">
            <div class="job_request" id="job_request">
            </div>
            @foreach ($users as $user)
                <div class="requests">
                    <div class="name" id="{{ $user->id }}">
                        {{ $user->name }} - {{ $user->lastname }}
                    </div>
                    <div class="region">
                        {{ $user->region->name }}
                    </div>
                    <div class="action">
                        <button data-userid="{{ $user->id }}" data-type="1"  class="blue"><img src="{{ asset('img/icon/check.svg') }}"></button>
                        <button data-userid="{{ $user->id }}" data-type="0" class="red"><img src="{{ asset('img/icon/delete.svg') }}"></button>
                    </div>
                </div>
            @endforeach
            <div class="requests">
                <div class="name" id="1">
                    Rajabov Shamshod
                </div>
                <div class="region">
                    Qashqadaryo
                </div>
                <div class="action">
                    <button data-userid="1" data-type="1"  class="blue"><img src="{{ asset('img/icon/check.svg') }}"></button>
                    <button data-userid="1" data-type="0" class="red"><img src="{{ asset('img/icon/delete.svg') }}"></button>
                </div>
            </div>
            
            <div class="requests">
                <div class="name" id="2">
                    Turayev Shoxrux
                </div>
                <div class="region">
                    Qashqadaryo
                </div>
                <div class="action">
                    <button data-userid="2" data-type="1"  class="blue"><img src="icons/check.svg"></button>
                    <button data-userid="2" data-type="0" class="red"><img src="icons/delete.svg"></button>
                </div>
            </div>
            
            <div class="selectregion">
                <form method="post">
                    <div class="checkbox">
                        <input type="checkbox" name="1" value="1" id="ch1">
                        <label for="ch1">Toshkent</label>
                    </div>
                    
                    <div class="checkbox">
                        <input type="checkbox" name="1" value="1" id="ch1">
                        <label for="ch1">Andijon</label>
                    </div>
                    
                    <div class="checkbox">
                        <input type="checkbox" name="1" value="1" id="ch1">
                        <label for="ch1">Farg'ona</label>
                    </div>
                    
                    <div class="checkbox">
                        <input type="checkbox" name="1" value="1" id="ch1">
                        <label for="ch1">Buxoro</label>
                    </div>
                    
                    <input type="submit" name="submit" value="Saqlash">
                </form>
            </div>
        </div>
    </div>
    <script>
        function hide(){
            $("#job").slideUp("fast", function() {$(this).remove();});
            
            $("#jobc").slideUp("fast", function() {$(this).remove();});
        }
        
        $(document).ready(function(){
            $(".action button").click(function(){
                let userid = $(this).data('userid');
                let name = $('#' + userid).text();
                
                if ($(this).data('type') == 1){
                    let jobElement = $("#job");
                    
                    if (jobElement.length != 0){
                        jobElement.slideUp("fast", function() {
                            $(this).remove();
                        });
                    }

                    $("#job_request").append(`
                            <div class="type" id="job">
                                <button onclick="hide()">x</button><br>
                                <b>${name}</b>ni qaysi kasbga kiritmoqchisiz?<br>
                                <a href="#">Menejer</a>
                                <a href="#">Tibbiy vakil</a>
                            </div>
                        `);
                    $("#job").slideDown("fast");
                } else {
                    let jobElement2 = $("#jobc");
                    
                    if (jobElement2.length != 0){
                        jobElement2.slideUp("fast", function() {
                            $(this).remove();
                        });
                    }

                    $("#job_request").append(`
                        <div class="cancel" id="jobc">
                            <button onclick="hide()">x</button><br>
                            <b>${name}</b>ni rostan bekor qilmoqchimisiz?<br>
                            <a href="#">Xa</a>
                        </div>
                        `);
                    $("#jobc").slideDown("fast");
                }
            });
        });
    </script>
</body>
</html>s