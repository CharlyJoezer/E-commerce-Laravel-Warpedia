<div class="navbar" id="navbar">
    <img class="logo-img" id="logo-img" src="/asset/warped.png" alt="">
    <p class="navbar-kategori">Kategori</p>
    <div class="navbar-search-box">
        <input class="navbar-search" id="navbar-search-box" placeholder="Cari barang ...">
        <div class="navbar-search-button" id="navbar-search-button">
            <img src="/asset/search.svg" alt="">
        </div>
    </div>
    <img class="cart-shop" id="cart-shop" src="https://img.icons8.com/cute-clipart/64/000000/shopping-cart-loaded.png" alt="">
    @auth   
    <div class="wrapper-buat-toko">
        <div class="buat-toko">
            <img src="/asset/buat_toko.png" alt="">
            <p class="buat-toko-text">Toko</p>
        </div>
        <div class="dropdown-buat-toko">
            <p>Anda belum memiliki Toko</p>
            <a href="/buatToko"><button class="btn-buat-toko" id="btn-buat-toko">Buat Toko Gratis</button></a>
        </div>
    </div>
    <div class="navbar-profil">
        <img src="/asset/profile.png" alt="">
        <p class="navbar-profil-name">{{ auth()->user()->username }}</p>
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
        const baseurl = window.location.origin
        document.getElementById('button-login').addEventListener('click', function(){
            window.location.href = baseurl+'/login'
        })
        document.getElementById('button-register').addEventListener('click', function(){
            window.location.href = baseurl+'/register'
        })
    </script>
    @endauth
</div>