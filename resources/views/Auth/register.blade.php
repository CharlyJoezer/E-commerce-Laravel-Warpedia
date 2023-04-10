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
                            <p>Phone number atau Email</p>
                            <input type="text" name="emailOrNumber" placeholder="Email atau No.HP" required value="{{ old('emailOrNumber') }}">
                            @error('emailOrNumber')
                                <div style="color:red;font-size:12px;margin-top:3px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-input-username">
                            <p>Username</p>
                            <input type="text" name="username" placeholder="Username" required value="{{ old('username') }}">
                            @error('username')
                                <div style="color:red;font-size:12px;margin-top:3px;">{{ $message }}</div>
                            @else
                                <div style="font-size:12px;color:#aaa;margin-top:3px;">*username hanya boleh mengandung huruf</div>
                            @enderror

                        </div>
                        <div class="form-input-password">
                            <p>Password</p>
                            <input type="password" name="password" placeholder="Password" required>
                            @error('password')
                                <div style="color:red;font-size:12px;margin-top:3px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="button-daftar" type="submit">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
@endsection