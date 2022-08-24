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

<div class="all-kategori">
    <div class="kategori-text">
        <h2 style="
        font-family: PP telegraf;
        font-weight: 500;
        font-size: 23px;
        margin-top: 5px;
        margin-bottom: 5px;
        text-align:center;">Kategori Produk</h2>
        <div class="bottom-line-header"></div>
    </div>
    <div class="list-category-wrapper1">
        <div class="item-category">
            <img src="asset/kategori-baju.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Baju</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-celana.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Celana</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-sepatu.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Sepatu</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-topi.png" style="padding:3px;box-sizing: border-box;" salt="">
            <p>Topi</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-skincare.png" style="padding:3px;box-sizing: border-box;"  alt="">
            <p>Skincare</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-tas.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Tas</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-jaket.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Jaket</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-parfum.png" style="padding:2px;box-sizing: border-box;" alt="">
            <p>Parfum</p>
        </div>
    </div>

    <div class="list-category-wrapper2" id="list-category-wrapper2">
        <div class="item-category">
            <img src="asset/kategori-headset.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Headset</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-keyboard.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Keyboard</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-monitor.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Monitor</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-mouse.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Mouse</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-laptop.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Laptop</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-kamera.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Kamera</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-speaker.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Speaker</p>
        </div>
        <div class="item-category">
            <img src="asset/kategori-mousepad.png" style="padding:3px;box-sizing: border-box;" alt="">
            <p>Mousepad</p>
        </div>
    </div>
</div>

<hr>
<div class="text-continue">
    <h2 style="
        font-family: PP telegraf;
        color: #555;
        font-weight: 500;
        font-size: 20px;">Produk Lainnya</h2>
</div>
<div class="content" id="content">
    <div class="trend-product">
        @foreach ($data as $item)
            <div class="product-item">
                <img src="storage/{{ $item->gambar_produk }}" alt="">
                <div class="desc-product">
                    <p class="product-name">{{ $item->nama_produk }}</p>
                    <p class="product-price">Rp <span class="harga-number">{{ $item->harga_produk }}</span></p>
                    <p class="product-alamat">Jakarta</p>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="wrapper-box-list-product" id="wrapper-box-list-product"> 
        <div class="trend-product" id="page2-product">
            
        </div>
    </div>
  
</div>

<script>
    function loadData(page){
        $.ajax({
            'url':'?page='+page,
            'type': 'GET',
            'dataType': 'JSON',
            success:function(data){
                if(data.html == ''){
                    statusProduct = null;
                    return;
                }
                $('#wrapper-box-list-product').append(`
                    <div class="trend-product" id="page${page}-product">
                        ${data.html}
                    </div>
                `)
            }
        })
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
                console.log(windowScroll)
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