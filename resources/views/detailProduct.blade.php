@extends('template.template')
@section('content')
    <div class="wrapper-content">
        {{-- <div class="breadcumb">
            <div class="breadcumb-text"><b>Warpedia | </b><span>Kategori </span>><span> Sepatu</span></div>
        </div> --}}
    
        <div class="content">
            <div class="wrapper-box-product">
                <img class="main-image-product" src="/storage/{{ $data->gambar_produk }}" alt="">
                <div class="list-item-product">
                    <div class="item-product-name">{{ $data->nama_produk }}</div>
                    <div class="rating-penilaian-terjual">
                        <p>Rating : Belum ada rating</p>
                        <p>Penilaian : 0</p>
                        <p>Terjual : 0</p>
                    </div>
                    <div class="product-price">
                        <h2>Rp {{ $data->harga_produk }}</h2>
                    </div>
                    <div class="stok-produk">
                        <span class="stok-produk-text">Stok Produk</span>
                        <span class="value-stok-produk">{{ $data->stok_produk }}</span>
                    </div>
                    <div class="kuantitas-produk">
                        <span class="jumlah-order-text">Jumlah Order</span>
                        <div class="wrapper-counter-number">
                            <div class="mines-counter" id="mines-counter">&minus;</div>
                            <input class="number-counter" id="number-counter" value="1" disabled>
                            <div class="plus-counter" id="plus-counter">&plus;</div>
                        </div>
                    </div>
                    <div class="btn-keranjang-beli-sekarang">
                        <div id="masukkan-keranjang" class="btn-masukkan-keranjang"><img src="/asset/cart-icon.png"alt="cart-icon"> Masukkan Keranjang</div>
                        <input id="product-info" type="hidden" value="{{ $data->id * 3625 }}">
                        <div class="btn-beli-sekarang">Beli Sekarang</div>
                    </div>
                    <div class="wrapper-deskripsi-produk">
                        <h2 class="deskripsi-produk-header">Deskripsi Produk</h2>
                        <div class="deskripsi-produk" id="deskripsi-produk">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam quaerat nulla qui cum ipsum sequi praesentium, aperiam at maxime nam, commodi voluptatibus vero! Quaerat, reiciendis. Pariatur saepe sapiente dolorum molestias, ipsam cum repudiandae explicabo earum, possimus, eaque provident enim reiciendis quod corporis voluptatum incidunt mollitia. Quia quo dolores pariatur. Aliquam, perferendis? Dolorum eius consectetur ea doloremque repellat architecto neque doloribus sunt pariatur recusandae reiciendis qui nisi voluptas dignissimos accusantium consequatur, incidunt culpa fuga, illo maxime. Officiis asperiores at ab ipsam, laboriosam deleniti molestias incidunt consectetur facere voluptas! Sequi fugiat, necessitatibus eos assumenda placeat sit! Quae ex iusto officiis impedit porro.
                        </div>
                        <p class="read-more-deskripsi" id="read-more-deskripsi" onclick="readMore()"><u>Baca Selengkapnya...</u></p>
                        <p class="baca-sedikit-deskripsi" id="baca-sedikit-deskripsi" onclick="minimizeDesc()"><u>Baca sedikit</u></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-keranjang-true" id="popup-keranjang-true">
        <div class="popup-box-true">
            <img src="/asset/check_list.png" alt="">
            <p>Produk telah ditambahkan ke keranjang</p>
        </div>
    </div>
    <div class="popup-keranjang-false" id="popup-keranjang-false">
        <div class="popup-box-false">
            <img src="/asset/warning.png" alt="">
            <p>Anda belum Login</p>
        </div>
    </div>
    <script>
        $('#plus-counter').click(function(){
            const valueInput = parseInt($('#number-counter').val()) 
            $('#number-counter').val( valueInput + 1 )
        })
        $('#mines-counter').click(function(){
            console.log('mines')
            const valueInput = parseInt($('#number-counter').val())
            if(valueInput > 1){
                $('#number-counter').val( valueInput - 1 )
            } 
        })
        $(document).ready(function(){
            const deskripsiHeight = $('#deskripsi-produk').css('height')
            const parseDeskripsiHeight = parseInt(deskripsiHeight.replace(/\D/g, ""))
            if(parseDeskripsiHeight > 50){
                $('#deskripsi-produk').css({
                    'overflow' : 'hidden',
                    'height'   : '50px'
                })
                $('#read-more-deskripsi').css('display', 'block')
            }

        })

        function readMore(){
            $('#deskripsi-produk').css({
                'overflow' : 'none',
                'height'   : 'fit-content'
            })
            $('#read-more-deskripsi').css({
                'display' : 'none'
            })
            $('#baca-sedikit-deskripsi').css('display', 'block')
        }
        function minimizeDesc(){
            $('#deskripsi-produk').css({
                'height'   : '50px',
                'overflow' : 'hidden'
            })
            $('#read-more-deskripsi').css({
                'display' : 'block'
            })
            $('#baca-sedikit-deskripsi').css('display', 'none')
        }
        function beliSekarang(){
        }
        function login(){
            $('#popup-keranjang-true').css({
                   'display': 'flex'
            })
            setTimeout(() => {
                $('#popup-keranjang-true').css({
                    'display': 'none'
                })
            }, 4000);
        }
        function notLogin(){
            $('#popup-keranjang-false').css({
                    'display': 'flex'
            })
            setTimeout(() => {
                $('#popup-keranjang-false').css({
                    'display': 'none'
                })
            }, 4000);
        }

        $('#masukkan-keranjang').click(function(){
            $.ajax({
                'url': '/insert/keranjang',
                'dataType': 'JSON',
                'type': 'POST',
                'data': {
                    "_token": "{{ csrf_token() }}",
                    'product_item': $('#product-info').val(),
                    'order' : parseInt($('#number-counter').val())
                },
                success:function(data){
                    if(data.status == true){
                        login()
                    }else if(data.status == false){
                        notLogin()
                    }
                }
            })
        })
    </script>
@endsection