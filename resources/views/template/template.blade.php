<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/{{ $css }}">
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
            width: 130px;
            height: 50px;
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
            border-right: none;
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
            outline: none;
            font-size: 14px;
            color: #555;
        }
        .navbar-search:focus {
            border: 1px solid green;
        }
        .navbar-search-box {
            display: flex;
            align-items: center;
            margin-top: 3px;
        }
        .navbar-search-button{
            border: 1px solid #ddd;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            padding-left: 10px;
            padding-right: 10px;
            background-color: #ccc;
            cursor: pointer;
            transition: 0.3s;
        }
        .navbar-search-button:active {
            background-color: #aaa;
        }
        .navbar-search-button img{
            width: 15px;
            height: 32px;
        }
        .cart-shop{
            margin-top: 3px;
            width: 30px;
            height: 30px;
        }
        .navbar-profil {
            margin-top: 3px;
            display: flex;
            align-items: center;
            padding-right: 5px; 
        }
        .navbar-profil p {
            font-family: Roboto;
            font-size: 15px;
            margin-right: 10px;
            color: #aaa;
        }
        .navbar-profil img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }
        .auth {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding-right: 18px;
            margin-top: 3px;
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
    </style>
</head>
<body>
    @include('template.navbar')
    <div class="container">
        @yield('content')
    </div>

<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script src="js/{{ $js }}"></script>
</body>
</html>