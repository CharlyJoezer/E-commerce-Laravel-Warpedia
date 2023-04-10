@extends('template.template')
@section('content')
<div class="box-carousel">
    <div class="carousel" id="carousel">
        <img class="carousel-slide1" id="carousel-slide1" src="https://random.imagecdn.app/1280/720" alt="">
        <div class="carousel-button-box" id="carousel-button-box">
            <img id="carousel-left-button" src="asset/carousel-left-button.webp" alt="">
            <img id="carousel-right-button" src="asset/carousel-right-button.webp" alt="">
        </div>
    </div>
</div>

<hr style="border: none;border-top: 5px solid #eee;">
<div class="content" id="content">
    <div class="trend-product">
        @foreach ($data as $item)
            <a href="/product/{{ $item->id * 3625 }}/{{ $item->nama_produk }}" class="product-item">
                <img class="product-image" src="storage/{{ $item->gambar_produk }}" alt="">
                <div class="desc-product">
                    <p class="product-name">{{ $item->nama_produk }}</p>
                    <p class="product-price">Rp <span class="harga-number">{{ $item->harga_produk }}</span></p>
                    <div class="product-toko">
                        <img src="/asset/mart.png" width="12" height="12"  alt="">
                        <span class="product-toko-name">{{ $item->toko->nama_toko }}</span>
                    </div>
                    {{-- <p class="product-alamat">{{ $item->toko->city->city_name }}</p> --}}
                </div>
            </a>
        @endforeach
    </div>
</div>

<script>
    function loadData(page){
        if(statusProduct !== null){
            $.ajax({
                'url':'?page='+page,
                'type': 'GET',
                'dataType': 'JSON',
                success:function(data){
                    if(data.html == ''){
                        statusProduct = null;
                        return;
                    }
                    console.log(data.html);
                    $('#wrapper-box-list-product').append(`
                        <div class="trend-product" id="page${page}-product">
                            ${data.html}
                        </div>
                    `)
                }
            })
        }
    }
    var statusProduct = '';
    var scroll = this.scrollY;
    var page = 1;
    var windowScroll = $('#list-category-wrapper2').offset().top - 300;
    var test = $('#list-category-wrapper2').offset().top - 300;
    $(window).scroll(function(){
        if(test < $(window).scrollTop()){
            if(statusProduct == null){
                return;
            }
            if($(window).scrollTop() > windowScroll){
                page++;
                windowScroll = windowScroll + 200;
                loadData(page);
            }
        }
    })

    $('.item-category').hover(function(e){
        $(this).children('p').css({
            'color' : 'green'
        })
        $(this).children('img').css({
                'box-shadow' : '0 0 3px #aaa'
        })
    })
    $('.item-category').mouseout(function(e){
        $(this).children('p').css({
            'color' : 'black'
        })
        $(this).children('img').css({
            'box-shadow' : 'none'
        })
    })

    

    

</script>
@endsection