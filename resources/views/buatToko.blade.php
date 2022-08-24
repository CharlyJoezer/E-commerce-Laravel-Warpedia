@extends('template.template')
@section('content')

<div class="content">
    <div class="left-content">
        <img class="left-content-image" src="asset/buat_toko.svg" alt="">
    </div>
    <div class="right-content">
        <div class="wrapper-form-buat-toko">
            <div class="box-form-buat-toko">
                <p>Halo, <b>{{ auth()->user()->username }}</b> ayo isi detail tokomu!</p>
            </div>
            <form action="/buatToko/verify/sendmessage" method="post">
            @csrf

            <div class="step1-form">
                <div class="header-step1-form counter-and-header">
                    <span class="number-header" id="number-header1">1</span>
                    <p>Masukan No.HP-mu</p>
                </div>
                <div class="content-step1-form input-step">
                    <div class="line-step"></div>
                    <div class="input-box">
                        @if (auth()->user()->telepon == 'null')
                        <input type="text" id="telpon-number" name="telpon_number" placeholder="+628*********" >
                        <p>Masukkan No.telp aktif untuk menerima Verifikasi!</p>
                        @else
                            <h4 style="font-family: Roboto;" id="number-telp">+62 {{ auth()->user()->telepon }}</h4>
                        @endif
                    </div>
                </div>
            </div>

            <div class="step2-form">
                <div class="header-step2-form counter-and-header">
                    <span class="number-header" id="number-header2">2</span>
                    <p>Masukan Nama Toko</p>
                </div>
                <div class="content-step2-form input-step">
                    <div class="line-step"></div>
                    <div class="input-box">
                        <input type="text" id="nama_toko" name="nama_toko" placeholder="Nama Toko" >
                        <p id="nama_toko_desc">Harap memasukan nama toko dengan benar!</p>
                    </div>
                </div>
            </div>
           
            <div class="step3-form">
                <div class="header-step3-form counter-and-header">
                    <span class="number-header" id="number-header3">3</span>
                    <button type="submit" class="step3-form-button" id="step3-form-button" >Buat Toko</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    $('document').ready(function(){
        if($('#number-telp').length > 0){
            $('#number-header1').css({
                'background-color':'rgb(0, 196, 0)',
                'color':'white'
            });
            $('#number-header2').css({
                'background-color': 'white',
                'border': '1px solid rgb(0, 196, 0)',
                'color': 'rgb(0, 196, 0)',
            });
        }else {
            $('#nama_toko').prop('disabled', true)
        }
    

    $('#nama_toko').change(function(){
            $.ajax({
            'url': window.location.origin+'/nama-toko/checking',
            'type': 'POST',
            'dataType': 'JSON',
            'data': {
                "_token": "{{ csrf_token() }}",
                'name': $(this).val()
            },
            success:function(data){
                if(data.success){
                    $('#nama_toko_desc').html(data.success);
                    $('#nama_toko_desc').css('color','green');
                    $('#number-header2').css({
                        'background-color':'rgb(0, 196, 0)',
                        'color':'white'
                    });
                    $('#step3-form-button').css({
                        'background-color': 'rgb(0, 196, 0)',
                        'border': '1px solid rgb(0, 196, 0)',
                        'color': 'white',
                        'cursor': 'pointer'
                    })
                    $('#number-header3').css({
                        'background-color':'rgb(0, 196, 0)'
                    })
                    $('#step3-form-button').prop('disabled', false)

                }else {
                    $('#nama_toko_desc').html(data.fail);
                    $('#nama_toko_desc').css('color','red');
                    $('#step3-form-button').prop('disabled', true)
                    $('#step3-form-button, #number-header3').css({
                        'background-color': 'rgb(192, 192, 192)',
                        'border': '1px solid rgb(192, 192, 192)',
                        'color': 'white',
                        'cursor': ''
                    })
                }
            }
            })
    })
    $('#telpon-number').change(function(){
        if(!isNaN($(this).val()) && $(this).val().length > 10){
            $('#number-header1').css({
                'background-color':'rgb(0, 196, 0)',
                'color':'white'
            })
            $('#number-header2').css({
                'background-color':'white',
                'color':'rgb(0, 196, 0)',
                'border': '1px solid rgb(0, 196, 0)'
            })
            $('#nama_toko').prop('disabled', false)
        }else {
            $('#number-header1').css({
                'background-color':'white',
                'color':'rgb(0, 196, 0)'
            })
            $('#number-header2').css({
                'background-color':'rgb(192, 192, 192)',
                'color':'white',
                'border': '1px solid rgb(192, 192, 192)'
            })
            $('#nama_toko').prop('disabled', true).val('')
            $('#step3-form-button').prop('disabled', true)
            $('#step3-form-button, #number-header3').css({
                'background-color': 'rgb(192, 192, 192)',
                'border': '1px solid rgb(192, 192, 192)',
                'color': 'white',
                'cursor': ''
            })
        }
    })
})
</script>
@endsection