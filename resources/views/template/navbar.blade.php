<div class="navbar" id="navbar">
    <a href="/" style="color:#03A10E;font-size:25px;font-family:Roboto;text-decoration:none;padding: 10px 5px;font-weight:500;">
        Warpedia
    </a>
    <p class="navbar-kategori">Kategori</p>
    <div class="navbar-search-box">
        <form action="/search" id="navbar-search" method="GET">
            <input class="navbar-search" name="search_key" id="navbar-search-box" placeholder="Cari barang ...">
        </form>
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
    <div class="wrapper-pesan">
        <img src="/asset/message.png" width="21" style="padding-top: 2px;" height="20" alt="">
        <div class="notification-message" id="notification-message"></div>
    </div>
    <div class="wrapper-buat-toko">
        <div class="buat-toko">
            <img src="/asset/mart.png" alt="">
        </div>
        @if (auth()->user()->toko == null)
        <div class="dropdown-buat-toko">
            <p>Anda belum memiliki Toko</p>
            <a href="/buatToko"><button class="btn-buat-toko" id="btn-buat-toko">Buat Toko Gratis</button></a>
        </div>
        @else
        <div class="dropdown-buat-toko">
            <div class="dropdown-box-profil-toko">
                @if (auth()->user()->foto_profil != null)
                <img src="/storage/{{ auth()->user()->foto_profil }}">
                @else
                <img src="/asset/profile.png">
                @endif
                <div class="dropdown-toko-name">
                    <div class="dropdown-toko-name-text">{{ auth()->user()->toko->nama_toko }}</div>
                    <div class="dropdown-toko-text">Owner : {{ auth()->user()->username }}</div>
                </div>
            </div>
            <a href="/toko/dashboard/beranda"><button class="btn-dashboard-toko" id="btn-dashboard-toko">Dashboard Toko</button></a>
        </div>
        @endif
    </div>
    <div class="wrapper-navbar-profil">
        <div class="navbar-profil">
            @if (auth()->user()->foto_profil != null)
            <img src="/storage/{{ auth()->user()->foto_profil }}" alt="">
            <p class="navbar-profil-name">{{ auth()->user()->username }}</p>
            @else
            <img src="/asset/profile.png" alt="">
            <p class="navbar-profil-name">{{ auth()->user()->username }}</p>
            @endif
        </div>
        <div class="dropdown-navbar-profil">
            <a class="dropdown-profil-data" href="/user/profil">
                <div>
                    @if (auth()->user()->foto_profil != null)
                    <img class="navbar-dropdown-image-profil" src="/storage/{{ auth()->user()->foto_profil }}" width="50" height="50" alt="Picture Profil">
                    @else
                    <img class="navbar-dropdown-image-profil" src="/asset/profile.png" width="50" height="50" alt="">
                    @endif
                </div>
                <div class="dropdown-profil-username" style="font-family: Roboto;padding-left: 10px;">{{ auth()->user()->username }}<div style="font-size: 10px;">Role : Member</div></div>
            </a>
            <div class="dropdown-profil-logout">
                <a href="/logout">Logout</a>
            </div>
        </div>
    </div>
    <script>
        setInterval(() => {
            $.ajax({
                url: '/notification/new-message',
                type:'GET',
                dataType: 'JSON',
                success:function(data){
                    if(data.status == true){
                        $('#notification-message').css('display', 'flex')
                        $('#notification-message').html(data.count_message)
                    }else if(data.status == false){
                        $('#notification-message').css('display', 'none')
                        $('#notification-message').html('')
                    }
                }
            })
        }, 5000);
        $('.wrapper-pesan').click(function(){
            window.location.href = '/user/profil#chat'
        })
    </script>
    @else
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

<script>
    $('#navbar-search-button').click(function(){
        $('#navbar-search').submit()
    })
</script>