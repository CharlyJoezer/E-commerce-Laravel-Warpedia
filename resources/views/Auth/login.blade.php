@extends('Auth.template_auth.templateAuth')
@section('content')
    
    <div class="main-text-top">
        <img src="asset/warped.png" alt="">
    </div>

    <div class="content">
        <div class="canvas-box-login">
            <div class="box-login">
                <div class="box-login-header">
                    <h1>Masuk</h1>
                    <a href="/register" style="color: green;text-decoration: none;font-size: 14px;">Daftar</a>
                </div>

                <div class="box-form-canvas">
                    <form action="/auth/login" method="POST">
                        @csrf
                        <div class="form-emailOrPhone">
                            <p>Email atau Phone number</p>
                            <input type="text" id="Email-phone" placeholder="Email atau No.Telp" name="emailOrPhone" value="{{ old('emailorPhone') }}">
                        </div>
                        <div class="form-password">
                            <p>Password</p>
                            <input type="password" id="password" placeholder="Password" name="password">
                        </div>
                        @if (session()->has('fail'))
                            <div style="color:red;font-size:13px;text-align:center;">{{ session('fail') }}</div>
                        @endif
                        <div class="button-canvas" style="margin-bottom: 5px;">
                            <button type="submit">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection