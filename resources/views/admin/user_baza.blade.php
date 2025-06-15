@extends('admin.layouts.user')

@section('title', 'Kirish surovlari')

@section('content')
    <div class="content">
        <div class="job_request" id="job_request">
        </div>
        @if (isset($users))
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
        @endif
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
                                <a href="requests/3/${userid}">Menejer</a>
                                <a href="requests/2/${userid}">Tibbiy vakil</a>
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
                            <a href="requests/0/${userid}">Xa</a>
                        </div>
                        `);
                    $("#jobc").slideDown("fast");
                }
            });
        });
    </script>
@endsection