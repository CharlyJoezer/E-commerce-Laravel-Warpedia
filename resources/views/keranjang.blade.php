@extends('template.template')
@section('content')

    <div class="wrapper-header-text">
        <div class="header-text">
            <img src="/asset/cart-icon.png" alt="">
            <h2>Warpedia | <span style="font-weight: 400">Keranjang</span></h2>
        </div>
        
        <div class="col-list-item-keranjang">
            <div class="wrapper-col-item col-item-left">
                <input class="all-checkbox-keranjang" id="all-checkbox-keranjang" type="checkbox">
                <p class="col-item col-list-item1">Produk</p>
            </div>
            <div class="wrapper-col-item col-item-right">
                <p>Harga Satuan</p>
                <p style="text-align: center;">Kuantitas</p>
                <p>Total Harga</p>
                <p>Aksi</p>
            </div>
        </div>
    </div>
 
    {{-- PENGULANGAN DATA --}}
    <div class="wrapper-list-item-keranjang">
        @foreach ($data as $item)
        <div class="box-item-keranjang" id="{{ $item->harga }}">

            <div class="header-item-keranjang">
                <input style="border: 1px solid black" value="{{ $item->id }}" id="{{ $item->harga }}" class="header-checkbox-item-keranjang" type="checkbox">
                <img src="/asset/mart.png" width="20" height="20" alt="">
                <p>{{ $item->toko->nama_toko }}</p>
            </div>
            <div class="produk-item-keranjang">

                <div class="wrapper-produk-item-keranjang-left">
                    <input class="checkbox-item-keranjang" id="{{ $item->harga }}" value="{{ $item->harga }}" type="checkbox">
                    <img class="produk-image" src="storage/{{ $item->product->gambar_produk }}" alt="">
                    <p class="produk-name">{{ $item->nama_produk }}</p>
                </div>

                <div class="wrapper-produk-item-keranjang-right">
                    <p class="produk-harga">Rp. {{ $item->harga }}</p>
                    <div class="wrapper-counter-number" id="{{ $item->id }}">
                        <div class="mines-counter" id="mines-counter">&minus;</div>
                        <input class="number-counter" id="number-counter" value="{{ $item->jumlah_order }}" disabled>
                        <div class="plus-counter" id="plus-counter">&plus;</div>
                    </div>
                    <p class="total-harga">Rp. {{ $item->harga }}</p>
                    <p class="tombol-hapus" id="{{ $item->id }}">Hapus</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="total-price-fixed-bottom">
        <div class="total-price-left">
            <input type="checkbox" id="pilih-semua">
            <p>Pilih Semua ({{ count($data) }})</p>
        </div>
        <div class="total-price-right">
            <p class="total-produk-text">Total Produk(1 produk):</p>
            <h2>Rp<span id="total-harga">0</span></h2>
            <div class="button-checkout" onclick="checkout()">
                <p>Checkout</p>
            </div>
        </div>
    </div>

    

    <script>
        $(document).ready(function(){
            let getInputKuantitas = $('.number-counter')
            for(i = 0; i < getInputKuantitas.length; i++){
                
            }
        })
        function rupiahFormat(number){
            var bilangan = number;
	
            var	number_string = bilangan.toString(),
                sisa 	= number_string.length % 3,
                rupiah 	= number_string.substr(0, sisa),
                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                    
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah
        }
        function checkNumberSupport(itemLength){
            let result = '';
            for(i = 0; i < itemLength.length; i++){
                if( isNaN(parseInt(itemLength.charAt(i))) ){
                    continue;
                }
                result += parseInt(itemLength.charAt(i));
            }
            return result;
        }
        function changeTotalCheckout(element = null, status = null){
            let getPrice = element.attr('id');
            let result = '';
            $('.all-checkbox-keranjang, #pilih-semua').prop('checked', false);
            for(i = 0; i < getPrice.length; i++){
                if( isNaN(parseInt(getPrice.charAt(i))) ){
                    continue;
                }
                result += parseInt(getPrice.charAt(i));
            }

            var totalPrice = checkNumberSupport($('#total-harga').html())
            if(status == true){
                var finalPrice = Number(totalPrice) + Number(result);
                $('#total-harga').html(rupiahFormat(finalPrice))
            }else if(status == false){
                var finalPrice = Number(totalPrice) - Number(result);
                $('#total-harga').html(rupiahFormat(finalPrice))
            }
        }
        // $('#pilih-semua').click(function(){
        //     let getAllCheckbox = $('.header-checkbox-item-keranjang')
        //     let result = 0;
        //     for(i = 0; i < getAllCheckbox.length; i++){
        //         result += Number(getAllCheckbox[i].value.replace('.', ''))
        //     }
        //     $('#total-harga').html(rupiahFormat(result))
        // })

        $('.checkbox-item-keranjang').click(function(){
            var getELementParent = $(this).parent().parent().parent().children()
            if($(this).prop('checked') == true){
                getELementParent.children('input').prop('checked', true);
                changeTotalCheckout($(this), $(this).prop('checked'))
            }else{
                $('#pilih-semua, .all-checkbox-keranjang').prop('checked', false)
                getELementParent.children('input').prop('checked', false);
                changeTotalCheckout($(this), $(this).prop('checked'))
            }
        })
        $('.header-checkbox-item-keranjang').click(function(){
            var getParentElement2 = $(this).parent().parent().children();
            if($(this).prop('checked') == true){
                getParentElement2.children().children('input').prop('checked', true);
                changeTotalCheckout($(this), $(this).prop('checked'))
            }else{
                getParentElement2.children().children('input').prop('checked', false);
                changeTotalCheckout($(this), $(this).prop('checked'))
            }
        })
        $('.all-checkbox-keranjang, #pilih-semua').click(function(){
            if($(this).prop('checked') == true){
                $('input').prop('checked', true)
                let getAllCheckbox = $('.checkbox-item-keranjang')
                let result = 0;
                for(i = 0; i < getAllCheckbox.length; i++){
                    result += Number(getAllCheckbox[i].value.replace(/\./g,''))
                }
                $('#total-harga').html(rupiahFormat(result))
            }else{    
                $('input').prop('checked', false)
                $('#total-harga').html('0')
            }
        }) 
        $('.plus-counter, .mines-counter').click(function(){
            const valueInput = parseInt($(this).parent().children('input').val()) 
            const itemid = parseInt($(this).parent().attr('id'))
            let finalInput;
            if($(this).attr('class') == 'plus-counter'){
                $(this).parent().children('input').val( valueInput + 1 )
                finalInput = valueInput + 1

            }else if($(this).attr('class') == 'mines-counter'){
                if(valueInput <= 1){
                    return false;
                }else{
                    $(this).parent().children('input').val( valueInput - 1 )
                    finalInput = valueInput - 1
                }
            }
            $('body').append(`
                    <div 
                        style="
                        position:fixed;
                        z-index: 99999;
                        top:0;
                        left:0;
                        right:0;
                        bottom:0;
                        display:flex;
                        justify-content:center;
                        align-items:center;
                        "id="layer-freeze">
                        <img src="/asset/loading_keranjang.gif" width="100" height="100">
                    </div>                    
                    `);
            $.ajax({
                'url' : '/change/count',
                'type': 'POST',
                'dataType': 'JSON',
                'data' : {
                    "_token": "{{ csrf_token() }}",
                    'produk': {
                        'id_produk' : itemid,
                        'afterChange': finalInput
                    }
                },
                success:function(){
                    setTimeout(() => {
                        $('#layer-freeze').remove()
                    }, 1000);
                }
            })
        })
        $('.tombol-hapus').click(function(){
            let getIdProduk = $(this).attr('id')
            $('body').append(`
            <div class="background-form-confirm-delete-item">
                <form class="form-confirm-delete-item" action="/produk-keranjang/delete-item/`+getIdProduk+`" method="POST">
                    @csrf
                    <div style="font-family: Roboto;font-size:16px;font-weight:500;border-bottom:1px solid #ccc;padding: 12px 15px;color:green;">Hapus Produk ?</div>
                    <div style="padding: 13px 15px;display:flex;justify-content:center;">
                        <button class="button-action-batalkan" type="button">Batalkan</button>
                        <button class="button-action-delete" type="submit">Hapus</button>
                    </div>
                </form>
            </div>
            `)
            $('.button-action-batalkan').click(function(){
                $(this).parent().parent().parent().remove();
            })
        })
        $('.button-checkout').click(function(){
            
        })
        function checkout(){
            let classItem = $('.header-checkbox-item-keranjang');
            let inputString = '';
            let indexItem = 1;
            for(i = 0; i < classItem.length; i++){
                if(classItem[i].checked == true){
                    console.log(classItem[i]);
                    inputString += `<input type="hidden" name="item${indexItem}" value="${classItem[i].value}">`
                    indexItem++
                }
            }
            let form = `<form action="/keranjang/checkout" id="form-checkout" method="POST">@csrf${inputString}</form>`
            $('body').append(form)
            $('#form-checkout').submit()
        }
        
    </script>
@endsection