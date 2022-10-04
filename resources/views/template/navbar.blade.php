<div class="navbar" id="navbar">
    <img class="logo-img" id="logo-img" src="/asset/warped.png" alt="">
    <p class="navbar-kategori">Kategori</p>
    <div class="navbar-search-box">
        <input class="navbar-search" id="navbar-search-box" placeholder="Cari barang ...">
        <div class="navbar-search-button" id="navbar-search-button">
            <img src="/asset/search.svg" alt="">
        </div>
    </div>
    <img onclick="redirectKeranjang()" class="cart-shop" id="cart-shop" src="https://img.icons8.com/cute-clipart/64/000000/shopping-cart-loaded.png" alt="">
    <script>
    const baseurl = window.location.origin
    function redirectKeranjang(){
        window.location.href = baseurl+'/keranjang'
    }
    </script>
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
    <div class="wrapper-navbar-profil">
        <div class="navbar-profil">
            <img src="/asset/profile.png" alt="">
            <p class="navbar-profil-name">{{ auth()->user()->username }}</p>
        </div>
    <div class="dropdown-navbar-profil">
            <a class="dropdown-profil-data" href="test">
                <div><img src="/asset/profile.png" width="50" height="50" alt=""></div>
                <div class="dropdown-profil-username" style="font-family: Roboto;padding-left: 10px;">{{ auth()->user()->username }}<div style="font-size: 10px;">Role : Member</div></div>
            </a>
            <div class="dropdown-profil-logout">
                <a href="/logout">Logout</a>
            </div>
        </div>
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
        const baseurl2 = window.location.origin
        document.getElementById('button-login').addEventListener('click', function(){
            window.location.href = baseurl2+'/login'
        })
        document.getElementById('button-register').addEventListener('click', function(){
            window.location.href = baseurl2+'/register'
        })
        
    </script>
    @endauth
</div>