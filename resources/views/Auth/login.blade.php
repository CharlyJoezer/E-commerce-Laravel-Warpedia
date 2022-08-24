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
                            <p>Email or Phone number</p>
                            <input type="text" id="Email-phone" name="emailOrPhone">
                            <p style="font-size: 12px;">example:example@warpedia.com</p>
                        </div>
                        <div class="form-password">
                            <p>Password</p>
                            <input type="password" id="password" name="password">
                        </div>
                        <div class="form-create-cookies">
                            <input type="checkbox" id="setCookies" name="setCookies">
                            <label for="setCookies" style="font-size: 12px;color: #666;">Create cookies to not repeat the login session!</label>
                        </div>

                        <div class="button-canvas" style="margin-bottom: 5px;">
                            <button type="submit">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection