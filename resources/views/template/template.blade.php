<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/{{ $css }}">
    <link rel="stylesheet" href="/css/template.css">
    <title>{{ $title }}</title>
</head>
<body>
    @include('template.navbar')
    <div class="container">
        @yield('content')
    </div>
    @include('template.footer')
    
    
    @if (session()->has('fail'))
    <div class="popup-message">
        <div class="message-text">{{ session('fail') }}</div>
    </div>
    @else
    <div class="popup-message" style="background-color: rgb(19, 156, 19);">
        <div class="message-text">{{ session('success') }}</div>
    </div>
    @endif



<script>
    function showMessage(){
        $('.popup-message').addClass('down')
        setTimeout(() => {
            $('.popup-message').removeClass('down')
        }, 5000);
    }
</script>
@if(session()->has('fail'))
    <script>
        $(document).ready(function(){
            showMessage()
        })
    </script>
@endif

<script src="js/{{ $js }}"></script>
</body>
</html>