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
    <title>{{ $title }}</title>
    <style>
        body {
            margin: 0px;
            padding: 0px;
        }
        h1, h2, h3, h4, h5, p {
            margin: 0px;
            padding: 0px;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* border-bottom: 1px solid #999; */
            padding: 5px;
            padding-left: 8px;
            padding-right: 8px;
            box-sizing: border-box;
            box-shadow: 0 3px 5px #eee;
        }
        .navbar .logo-img {
             width: 120px;
             height: 40px;
            padding-top: 17px;
        }
        .navbar-kategori {
            font-family: Roboto;
            font-size: 14px;
            color: #777
        }
        .navbar-search {
            width: 690px;
            height: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
            color: #555;
            padding-left: 8px;
            background-color: #eee; 
        }
        .navbar-search:focus {
            /* border: 1px solid green; */
            box-shadow: 0 0 5px 1px rgba(0, 191, 0, 0.432);
        }
        .navbar-search-box {
            display: flex;
            align-items: center;
            position: relative;
        }
        .navbar-search-button{
            border: 1px solid #ddd;
            border-radius: 5px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            box-sizing: border-box;
            display: flex;
            position: absolute;
            right: 0;
            align-items: center;
            padding-left: 10px;
            padding-right: 10px;
            background-color: #ccc;
            cursor: pointer;
            transition: 0.3s;
            z-index: 1;
        }
        .navbar-search-button:active {
            background-color: #aaa;
        }
        .navbar-search-button img{
            width: 15px;
            height: 32px;
        }
        .cart-shop{
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
        .wrapper-buat-toko {
            display: inline-block;
            position: relative;
        }
        .buat-toko {
            display: flex;
            align-items: center;
            padding: 5px;
            cursor: pointer; 
            position: relative;
            border-radius: 10px;
        }
        .buat-toko img {
            width: 15px;
            height: 15px;
        }
        .buat-toko p {
            padding-left: 2px;
            font-family: Roboto;
            font-size: 14px;
            color: #555;
        }
        .dropdown-buat-toko {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0 1px 5px 1px #aaa;
            padding: 10px;
            box-sizing: 5px;
            width: 180px;
            z-index: 1;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            border-radius: 5px;
            transition: 0.3s;
        }
        .dropdown-buat-toko p {
            font-family: roboto;
            font-size: 13px;
            color: #aaa;
        }
        .btn-buat-toko {
            outline: none;
            background-color: #03a10e;
            padding: 8px;
            box-sizing: border-box;
            color: white;
            border: none;
            border-radius: 5px;
            width: 100%;
            margin-top: 20px;
            font-size: 12px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-buat-toko:hover {
            transition: 0.3s;
            background-color: #00c40d;
        }
        .wrapper-buat-toko:hover .buat-toko {
            background-color: #ddd;
        }
        .wrapper-buat-toko:hover .dropdown-buat-toko {
            display: block;
            transition: 0.3s;
        }
        .dropdown-buat-toko:hover .wrapper-buat-toko {
            background-color: #ddd;
        }
        .wrapper-navbar-profil{
            position: relative;
        }
        .dropdown-navbar-profil{
            display: none;
            position: absolute;
            box-shadow: 0 0 5px #ccc;
            border-radius: 5px;
            background-color: white;
            padding: 10px;
            z-index: 1;
            right: 0;
        }
        .wrapper-navbar-profil:hover .dropdown-navbar-profil{
            display: block;
        }
        .navbar-profil {
            display: flex;
            align-items: center;
            padding: 5px; 
            cursor: pointer;
            transition: 0.3s;
            border-radius: 10px
        }
        .dropdown-profil-data {
            display: flex;
            align-items: center;
            width: 200px;
            border: 1px solid #eee;
            border-radius: 5px;
            padding: 8px;
            transition: 0.2s;
            text-decoration: none;
            color: #555;
        }
        .dropdown-profil-data:hover {
            border: 1px solid #ddd;
            background-color: rgba(237, 237, 237, 0.381);
            cursor: pointer;
        }
        .dropdown-profil-logout{
            text-decoration:none;
            font-family:Roboto;
            font-size:14px;
            text-align: end;
            margin-top: 15px;
        }
        .dropdown-profil-logout a{
            text-align: end;
            margin-top: 5px;
            border-radius: 5px;
            color: #777;
            text-decoration: none;
        }
        .dropdown-profil-username::first-letter, .navbar-profil-name::first-letter{
            text-transform: capitalize;
        }
        .navbar-profil:hover{
            background-color: #ddd;
        }
        .navbar-profil p {
            font-family: Roboto;
            font-size: 14px;
            margin-left: 10px;
            color: #555;
        }
        .navbar-profil img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
        .auth {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding-right: 18px;
        }
        .auth div {
            font-size: 12px;
            font-family: Roboto;
            font-weight: bold;
            padding: 7px 11px 7px 11px;
            box-sizing: border-box;
            border-radius: 5px;
            cursor: pointer;
        }
        .button-login {
            margin-right: 10px;
            color: #03a10e;
            border: 1px solid #03a10e;
        }
        .line-ver {
            border-left: 1px solid #999;
            height: 30px;
        }
        .button-register {
            color: white;
            background-color: #03a10e;
            border: 1px solid #03a10e;
            transition: 0.3s;
        }
        .button-register:hover{
            background-color: #00980a;
            transition: 0.3s;
        }
        .container {
            padding-right: 15px;
            padding-left: 15px;
            padding-top: 8px;
        }
        .footer{
            height: auto;
            margin-top: 500px;
    }
    .footer-top{
        height: 50px;
        background-color: rgb(0, 127, 0);
        /* background-color: #555; */
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 25px;
    }
    .footer-top p {
        font-family: sans-serif;
        font-size: 13px;
        color: white;
    }
    .social-media-link {
        display: flex;
        align-items: center;
    }
    .social-media-link img{
        width: 15px;
        height: 15px;
        margin-left: 30px;
    }
    .footer-middle {
        height: 200px;
        display: flex;
        padding:  30px 25px 0px 25px;
    }
    .footer-middle-name{
        width: 250px;
        margin-right: 40px;
    }
    .footer-header-bottom-line{
        height: 5px;
        width: 100%;
        border-radius: 20px;
        background-color: rgb(0, 158, 0);
        margin-top: 10px;
    }
    .footer-middle-name header{
        font-family: Roboto;
        font-weight: 500;
        margin-bottom: 20px;
        /* border-bottom: 2px solid #555; */
    }
    .footer-middle-name p{
        font-family: sans-serif;
        font-size: 13px;
        white-space: 2px;
    }
    .image-and-text{
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .image-and-text img{
        width: 13px;
        height: 13px;
        margin-right: 5px;
    }
    .footer-middle-section2 p , .footer-middle-section3 p{
        margin-bottom: 15px;
    }

    .footer-bottom {
        height: 40px;
        border-top: 1px solid #555;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: sans-serif;
        font-size: 12px;
        color: #555;
        /* background-color: #174216; */
    }
    </style>
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