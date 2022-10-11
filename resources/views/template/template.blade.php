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

<script>
    window.addEventListener("scroll", (event) => {
        scroll = this.scrollY;
        if (scroll > 200){
            $('#navbar').css({
            'position' : 'fixed',
            'top' : '0',
            'left': '0',
            'right': '0',
            'z-index': '9999',
            'background-color': 'white',
            'height': '60px',
            'box-shadow': '0 1px 1px #eee'
            })
            $('#logo-img').css({
             'width': '120px',
             'height': '40px'
            });
        }
        if(scroll < 200){
            $('#navbar').css({
             'position' : '',
             'top' : '',
             'left': '',
             'right': '',
             'z-index': '',
             'background-color': 'none',
             'box-shadow': '0 3px 5px #eee'
            })  
        }
    })

</script>
<script src="js/{{ $js }}"></script>
</body>
</html>