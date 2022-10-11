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
    <link rel="stylesheet" href="/css/dashboard.css">
    <title>{{ $title }}</title>
    @if (auth()->user()->toko->status == 'false')
        <style>
            /* body {
                background-image: url('/asset/buat_toko.svg');
                background-position: center;
                background-repeat: no-repeat;
            } */
            .verifikasi-box {
                position: absolute;
                /* border: 1px solid #555; */
                box-shadow: 0 0 3px #aaa;
                border-radius: 5px;
                padding: 5px;
                box-sizing: border-box;
                left: 0;
                right: 0;
                top: 100px;
                margin: 0 auto;
                width: 350px;
                font-family:roboto;
                font-size:14px;
                background-color: white; 
            }
            .verifikasi-number {
                margin-top: 20px; 
                /* border: 1px solid #555; */
                box-sizing: 5px;
                padding: 5px;
                display: flex;
                justify-content: space-around
            } 
            .icon-handphone{
                width: 50px;
                height: 50px;
            }
            .box-kirim-kode-otp{
                margin-top: 12px;
                display: flex;
                justify-content: center;
            }
            .kirim-kode-otp {
                outline: none;
                border: 1px solid rgb(0, 198, 0);
                border-radius: 20px;
                box-sizing: border-box;
                padding: 5px 10px;
                background-color: rgb(0, 198, 0);
                color: white;
                cursor: pointer;
                margin-bottom: 10px;
            }
            .kirim-kode-otp:hover{
                background-color: rgb(0, 171, 0);
            }
            .verifikasi-header img {
                margin-top: 10px;
                width: 140px;
                height: 35px;
            }
            .form-otp{
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .input-kode-otp{
                border: none;
                border-bottom: 1px solid #555;
                font-size: 20px;
                width: 80px;
                text-align: center
            }
            .input-kode-otp:focus {
                outline: none;
                text-align: center
            }
            .input-kode-otp::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            .form-otp button {
                margin-top: 10px;
                border: 1px solid rgb(0, 198, 0);
                background-color: rgb(0, 198, 0);
                color: white;
                padding: 5px 10px;
                border-radius: 20px; 
                cursor: pointer;
                width: 100px;
            }
            .form-otp button:hover{
                background-color: rgb(0, 171, 0);
            }
        </style>
    @endif
</head>
<body>
    
    @if (auth()->user()->toko->status == 'false')
        <div class="verifikasi-header" style="text-align:center;">
            <img src="/asset/warpedia_dash.png" alt="">
        </div>

        <div class="verifikasi-content" id="verifikasi-content">
            <div class="verifikasi-box" id="verifikasi-box">
                <p id="header-text-verifikasi-content" style="color:black;text-align:center;">Toko kamu belum Terverifikasi!</p>
                <div class="verifikasi-number" id="verifikasi-number">
                    <img class="icon-handphone" src="/asset/icon-handphone.png" alt="">
                    <div>
                        <p style="color: #999;">Verifikasi dengan No.HP Kamu</p>
                        <p>+62 {{ auth()->user()->telepon }}</p>
                    </div>
                </div>
                <div class="box-kirim-kode-otp">
                    <button class="kirim-kode-otp" id="kirim-kode-otp">Kirim Kode OTP</button>
                </div>
            </div>
        </div>
        <script>
            function sendCode(){
                $.ajax({
                    'url': window.location.origin + '/verifikasi/otp',
                    'type': 'POST',
                    'dataType': 'JSON',
                    'data' : {
                        "_token": "{{ csrf_token() }}",
                        'telepon': {{ auth()->user()->telepon }},
                        'id': {{ auth()->user()->id }}
                    },
                    success:function(data){
                        $("#kirim-kode-otp").css('display', 'none')
                        $('#text-bottom-form').append(`
                            <span id="countdown"></span>
                        `)
                        var timer = 30;
                        var timerId = setInterval(countdown,1000)
                            function countdown() {
                                $('#countdown').css('display', 'inline')
                                if (timer == -1) {
                                    clearTimeout(timerId);
                                    $("#kirim-kode-otp").css('display', 'inline')
                                    $('#countdown').css('display', 'none')
                                } else {
                                    $('#countdown').html(timer + 's')
                                    timer--;
                                }
                            }
                        }
                })
            }
            $('#kirim-kode-otp').click(function(){
                $.ajax({
                    'url': window.location.origin + '/verifikasi/otp',
                    'type': 'POST',
                    'dataType': 'JSON',
                    'data' : {
                        "_token": "{{ csrf_token() }}",
                        'telepon': {{ auth()->user()->telepon }},
                        'id': {{ auth()->user()->id }}
                    },
                    success:function(data){
                        // $('#verifikasi-content').html('')
                        $('#verifikasi-box').html(`
                        <div class="box-form-otp">
                            <h2 style="font-style: Roboto;font-size: 15px;text-align:center;">Masukkan Kode OTP</h2>
                            <br>
                            <div class="form-otp">
                                <input class="input-kode-otp" id="input-kode-otp" style="display: block;" name="otp" type="number" maxlength="6">
                                <p id="error-messages"></p>
                                <button class="button-verify" id=button-verify style="display: block;" >Verify</button>
                            </div>
                            <p id="text-bottom-form" style="text-align:center; font-size: 12px;color: #aaa;margin-top:5px;">Tidak menerima kode ?<button style="border:none;background-color:white;font-size: 12px;color: blue;cursor:pointer;" id="kirim-kode-otp" onclick="sendCode()">Kirim ulang</button></p>
                        </div>
                        `)
                        scriptCheckOTP();
                    }
                })
            })
            function scriptCheckOTP(){
                $('#input-kode-otp').keyup(function(){
                    if($(this).val().length > 6){
                        $(this).val($(this).val().slice(0, 6)) 
                    }
                    if($(this).val().length == 6){
                        $.ajax({
                            'url': window.location.origin + '/check/otp',
                            'type': 'POST',
                            'dataType': 'text',
                            'data' : {
                                "_token": "{{ csrf_token() }}",
                                'otp' : $(this).val() 
                            },
                            success:function(data){
                                if(data == 'null'){
                                    $('#error-messages').html('Mohon isi dengan benar!')
                                    $('#error-messages').css({
                                        'color': 'red',
                                        'font-size': '12px',
                                        'margin-top': '5px'
                                    })
                                }
                                if(data == 'false'){
                                    $('#error-messages').html('Kode OTP tidak ditemukan!')
                                    $('#error-messages').css({
                                        'color': 'red',
                                        'font-size': '12px',
                                        'margin-top': '5px'
                                    })
                                }
                                if(data == 'success'){
                                    console.log('okee')
                                    location.reload()
                                }
                            }
                        })
                    }
                })

                $('#button-verify').click(function(){
                    $.ajax({
                        'url': window.location.origin + '/check/otp',
                        'type': 'POST',
                        'dataType': 'text',
                        'data' : {
                            "_token": "{{ csrf_token() }}",
                            'otp' : $('#input-kode-otp').val() 
                        },
                        success:function(data){
                            if(data == 'null'){
                                $('#error-messages').html('Mohon isi dengan benar!')
                                $('#error-messages').css({
                                    'color': 'red',
                                    'font-size': '12px',
                                    'margin-top': '5px'
                                })
                            }
                            if(data == 'fail'){
                                console.log('salah')
                            }
                            if(data == 'success'){
                                console.log('okee')
                                location.reload()
                            }
                        }
                    })
                })
            }
        </script>
    @else
        @include('dashboard.templates.navbar')
        @include('dashboard.templates.sidebar')

        <div class="dashboard-content" id="dashboard-content">
            @yield('content')
        </div>
        <script src="/js/dashboard.js"></script>
    @endif


</body>
</html>