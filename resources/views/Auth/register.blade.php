@extends('Auth.template_auth.templateAuth')
@section('content')
    
    <div class="main-text-top">
        <img src="asset/warped.png" alt="">
    </div>

    <div class="main-content">
        <div class="image-and-text">
            <img class="register-image" src="asset/auth-img.png" alt="">
        </div>

        <div class="box-register">
            <div class="box-register-content">
                <h1>Daftar Sekarang</h1>
                <p class="for-login">Sudah Punya akun Warpedia ? <a href="/login" style="color:green;text-decoration: none;">Masuk</a></p>
                <div class="register-input">
                    <form action="/auth/register" method="post" class="form-register">
                        @csrf
                        <div class="form-input-email">
                            <p>Phone number or Email</p>
                            <input type="text" name="emailOrNumber" required >
                        </div>
                        <div class="form-input-username">
                            <p>Username</p>
                            <input type="text" name="username" required>
                        </div>
                        <div class="form-input-password">
                            <p>Password</p>
                            <input type="password" name="password" required >
                        </div>
                        <div class="check-input">
                            <input type="checkbox" id="check-save" required>
                            <label for="check-save"> I Trust This Website is Safe!</label><br>
                        </div>

                        <button class="button-daftar">Daftar</button>
                    </form>
                </div>
            </div>
        </div>  
@endsection