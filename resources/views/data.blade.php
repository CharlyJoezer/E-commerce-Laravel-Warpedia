@foreach ($product as $item)
<div class="product-item">
    <img src="storage/{{ $item->gambar_produk }}" alt="">
    <div class="desc-product">
        <p class="product-name">{{ $item->nama_produk }}</p>
        <p class="product-price">Rp <span class="harga-number">{{ $item->harga_produk }}</span></p>
        <p class="product-alamat">Jakarta</p>
    </div>
</div>
@endforeach