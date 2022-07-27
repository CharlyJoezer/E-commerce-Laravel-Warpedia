<div class="navbar">
    <img class="logo-img" src="asset/warped.png" alt="">
    <p class="navbar-kategori">Kategori</p>
    <div class="navbar-search-box">
        <input class="navbar-search" id="navbar-search-box">
        <div class="navbar-search-button">
            <img src="asset/search.svg" alt="">
        </div>
    </div>
    <img class="cart-shop" id="cart-shop" src="https://img.icons8.com/cute-clipart/64/000000/shopping-cart-loaded.png" alt="">
    @auth
    <div class="navbar-profil">
        <p class="navbar-profil-name">{{ auth()->user()->username }}</p>
        <img src="asset/profile.png" alt="">
    </div>
    @else
    {{-- <div class="line-ver"></div> --}}
    <div class="auth">
        <div class="button-login" id="button-login">
            <p>Masuk</p>
        </div>
        <div class="button-register" id="button-register">
            <p>Daftar</p>
        </div>
    </div>
    <script>
        document.getElementById('button-login').addEventListener('click', function(){
            console.log('ok')
            const baseurl = window.location.origin
            window.location.href = baseurl+'/login'
        })
        document.getElementById('button-register').addEventListener('click', function(){
            const baseurl = window.location.origin
            window.location.href = baseurl+'/register'
        })
    </script>
    @endauth
</div>