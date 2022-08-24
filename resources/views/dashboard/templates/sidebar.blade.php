
<div class="sidebar" id="sidebar">

    <div class="sidebar-header">
        <img src="/asset/profile.png" width="30" height="30"  alt="">
        <p>{{ auth()->user()->toko->nama_toko }}</p>
    </div>
    <hr style="margin: 10px 0px 20px 0px;">
    
    
    <div class="kategori1 box-kategori">
        <div class="kategori1-header all-kategori-header">
            <img src="/asset/icon-home.svg" width="20" height="20" alt="">
            <p>Tokoku</p>
        </div>
        <div class="kategori1-item all-kategori-item">
            <p class="kategori-link-item" id="beranda">Beranda</p>
            <p class="kategori-link-item" id="profil-toko">Profil Toko</p>
        </div>
    </div>
    
    <div class="kategori2 box-kategori">
        <div class="kategori2-header all-kategori-header">
            <img src="/asset/icons-product.png" width="20" height="20" alt="">
            <p>Pesanan</p>
        </div>
        <div class="kategori2-item all-kategori-item">
            <p class="kategori-link-item"  id="riwayat-pesanan">Riwayat Pesanan</p>
            <p class="kategori-link-item" id="ulasan-pembeli">Ulasan Pembeli</p>
        </div>
    </div>
    
    <div class="kategori3 box-kategori">
        <div class="kategori3-header all-kategori-header">
            <img src="/asset/icons-order.png" width="20" height="20" alt="">
            <p>Produk</p>
        </div>
        <div class="kategori3-item all-kategori-item">
            <a href="/toko/dashboard/buat-produk">
                <p class="kategori-link-item" @if( Request::is('toko/dashboard/buat-produk') ) style="color:green;" @endif id="buat-produk">Buat Produk</p>
            </a>
            <a href="detail-produk">
                <p class="kategori-link-item" id="detail-produk">Detail Produk</p>
            </a>
        </div>
    </div>
</div>