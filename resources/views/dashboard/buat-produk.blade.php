@extends('dashboard.templates.template')
@section('content')
    <div class="content">
        <div class="header-text">
            <div class="buat-product-header">
                <h2>Buat Produk</h2>
                <div style="border-bottom: 2px solid green;padding-bottom: 14px;margin-bottom:30px;"></div>

                <form action="/store/buat-produk" enctype="multipart/form-data" method="POST" class="form-buat-produk">
                    @csrf

                    {{-- KATEGORI INPUT PRODUK --}}
                    <label for="kategori">Kategori Produk<br></label>
                    <select class="kategori-produk" name="kategori" id="kategori" required>
                        <option selected disabled>-- Pilih Kategori --</option>
                        @foreach ($kategori as $item)
                            <option class="category-option" value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                        @endforeach
                    </select>

                    <div class="informasi-produk-text">Informasi Produk</div>

                    {{-- NAMA PRODUK INPUT --}}
                    <div class="box-input-name-produk" style="margin-bottom: 20px;">
                        <label for="nama_produk">Nama Produk<br></label>
                        <input type="text" id="nama_produk" name="nama_produk" required>
                        <p style="font-size:12px;color:#aaa;font-family:roboto;padding-top:3px;">*ketik nama yang umum untuk memudahkan user menemukan barang kamu</p>
                        @error('nama_produk')
                            <p style="font-size:12px;color:red;font-family:roboto;padding-top:3px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- GAMBAR PRODUK INPUT --}}
                    <div class="box-input-gambar-produk" style="margin-bottom: 20px;">
                        <label for="btn-gambar-produk" style="margin-bottom: 5px;">Tambah Gambar<br></label>
                        <div class="flex-choose-area">
                            <div class="choose-area" id="choose-area1" style="margin-right: 15px;">
                                <input type="file" name="gambar_produk" id="gambar-produk1" class="btn-gambar-produk" required>
                            </div>
                        </div>
                        <p style="font-size:12px;color:#aaa;font-family:roboto;padding-top:3px;">*pilih gambar berdimensi 150x150 pixels dan berformat gambar .PNG .JPG</p>
                        @if(session('gambar-produk'))
                            <p style="font-size:12px;color:red;font-family:roboto;padding-top:3px;">*Mohon maaf format gambar harus bertipe PNG atau JPG</p>
                        @endif
                    </div>

                    {{-- DESKRIPSI PRODUK INPUT --}}
                    <div class="box-input-deskripsi-produk">
                        <label for="deskripsi-produk-form">Deskripsi Produk<br></label>
                        <textarea name="deskripsi_produk" id="deskripsi-produk-form" class="deskripsi-produk-form" placeholder="Cantumkan deskripsi produk kamu untuk memberi informasi ke pembeli" required></textarea>
                        @error('deskripsi_produk')
                            <p style="font-size:12px;color:red;font-family:roboto;padding-top:3px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="informasi-produk-text">Informasi Stok dan Harga</div>

                    {{-- HARGA PRODUK INPUT --}}
                    <div class="box-input-harga-produk" id="box-input-harga-produk" >
                        <label for="harga-produk-form">Harga produk<br></label>
                        <div class="wrap-input-box-harga">
                            <span style="font-family: Roboto;color:#aaa;font-size:15px;">Rp.</span>
                            <input type="number" name="harga_produk" id="harga-produk-form" class="harga-produk-form" placeholder="0" required>
                        </div>
                    </div>
                    <p style="font-size:12px;color:#aaa;font-family:roboto;padding-top:3px;">per 1 Produk</p>
                    @error('harga_produk')
                            <p style="font-size:12px;color:red;font-family:roboto;padding-top:3px;">{{ $message }}</p>
                    @enderror

                    {{-- STOK PRODUK INPUT --}}
                    <div class="box-input-stok-produk" style="margin-bottom: 20px;margin-top: 20px;">
                        <label for="stok-produk-form">Stok Produk<br></label>
                        <input type="number" name="stok_produk" id="stok-produk-form" class="stok-produk-form" placeholder="0" required>
                        <p style="font-size:12px;color:#aaa;font-family:roboto;padding-top:3px;">x1</p>
                        @error('stok_produk')
                            <p style="font-size:12px;color:red;font-family:roboto;padding-top:3px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- MINIMAL PRODUK INPUT --}}
                    <div class="box-input-minimal-produk" style="margin-bottom: 30px;">
                        <label for="minimal-produk-form">Minimal Pesan<br></label>
                        <input type="number" name="minimal_pesanan" id="minimal-produk-form" class="minimal-produk-form" placeholder="0" required>
                        <p style="font-size:12px;color:#aaa;font-family:roboto;padding-top:3px;">1 order = <span id="change-input-minimal-produk"></span></p>
                        @error('minimal_pesanan')
                            <p style="font-size:12px;color:red;font-family:roboto;padding-top:3px;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CONFIRM PRODUK CREATE --}}
                    <button type="submit" class="btn-confirm-buat-produk" id="btn-confirm-buat-produk">Buat Produk</button>
                </form>
                
            </div>
        </div>
    </div>
    <script>
        $('#harga-produk-form').focusin(function(){
            $('#box-input-harga-produk').css({
                'border-bottom':'2px solid green'
            })
                $('#harga-produk-form').focusout(function(){
                    $('#box-input-harga-produk').css({
                        'border-bottom':'1px solid #555'
                    })
                })
        })
        $('#minimal-produk-form').keyup(function(){
            $('#change-input-minimal-produk').html($(this).val())
        })

        $('.btn-gambar-produk').change(function(){
            var parentElement = $(this).parent()
            var reader = new FileReader();
            reader.onload = function(){
                parentElement.css({
                    'background-image': "url('"+reader.result+"')",
                    'border': 'none'
                })
            };
            reader.readAsDataURL(event.target.files[0]);
        })
        $(document).ready( () => {
            $('.category-option').each(function(){
                var setWordElement = $(this).html()
                var getWordElement = setWordElement.replace(setWordElement[0], setWordElement[0].toUpperCase())
                $(this).html(getWordElement)
            })
        })

        function changeString(element){
            var cekElement = element.html
            console.log(cekElement);
        }
        // var test = $('.category-option').html()
        // console.log(test);
    </script>
@endsection