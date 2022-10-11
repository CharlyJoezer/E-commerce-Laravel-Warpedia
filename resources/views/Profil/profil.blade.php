@extends('template.template')
@section('content')

<div class="sidebar-profil-user">
    <div class="user-login-item-sidebar">
        @if (auth()->user()->foto_profil != null)
        <img class="profil-sidebar-image" src="/storage/{{ auth()->user()->foto_profil }}" width="50" height="50" alt="">
        @else
        <img class="profil-sidebar-image" src="/asset/profile.png" alt="{{ auth()->user()->username }}" height="50" width="50">
        @endif
        <div class="wrapper-username-role">
            <div class="user-login-username">{{ auth()->user()->username }}</div>
            <div class="user-login-role">
                Role : Member
            </div>
        </div>
    </div>
    
    <div class="horizontal-line-sidebar" style="position: absolute;left:0;right:0;height: 1px;background-color:#ccc;margin-top:10px;"></div>
    <div style="margin: 10px 0px;"></div>
    <div class="wrapper-sidebar-item-profil">
        <a class="item-sidebar-link sidebar-item-profil-1" href="/user/profil">
            <span @if( Request::is('user/profil') ) style="color:green;" @endif>Profil Saya</span>
        </a>
        <a class="item-sidebar-link sidebar-item-profil-2" href="/user/chat">
            <span @if( Request::is('user/chat') ) style="color:green;" @endif>Chat</span>
        </a>
        <a class="item-sidebar-link sidebar-item-profil-3" href="/keranjang">
            <span>Keranjang</span>
        </a>
        <a class="item-sidebar-link sidebar-item-profil-4" href="/user/pengaturan">
            <span @if( Request::is('user/pengaturan') ) style="color:green;" @endif>Pengaturan</span>
        </a>

    </div>
</div>

<div class="content-item-sidebar">
    <div class="user-login-name-content">
        <img src="/asset/person_profil.png" height="30" width="30" alt="">
        <span style="color:#777;">{{ auth()->user()->username }}</span>
    </div>

    <div class="wrapper-navbar-and-content">
        <div class="navbar-content">
            <div class="navbar-link navbar-content-link1 link-navbar-profil-active" id="link-navbar-beranda" style="border-top-left-radius: 10px;">
                Beranda
            </div>
            <div class="navbar-link navbar-content-link2" id="link-daftar-alamat">
                Daftar Alamat
            </div>
            <div class="navbar-link navbar-content-link3" id="link-riwayat-pesanan">
                Riwayat Pesanan
            </div>
        </div>

        <div class="content-item-navbar-beranda" id="content-item-navbar">
            <div class="card-image-beranda">
                @if (auth()->user()->foto_profil != null)
                <img src="/storage/{{ auth()->user()->foto_profil }}" width="220" height="220" alt="">
                @else
                <img src="/asset/profile.png" width="220" height="220" alt="">
                @endif
                <div class="change-image">
                    <form action="/user/profil/foto-profil/change" id="form-change-image" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="foto-profil" name="foto-profil">
                    </form>
                    <span>Pilih Foto</span>
                </div>
                <div class="rules-input-desc">
                    <div>Besar File : maksimum 5MB</div>
                    <div>Ekstensi File yang diperbolehkan : .JPG .JPEG .PNG</div>
                </div>
            </div>
            <div class="data-user-login-table">
                <table class="biodata-user-login-table">
                    <tr style="border-spacing: 0px">
                        <td><div class="header-ubah-biodata">Ubah Biodata diri</div></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>{{ auth()->user()->username }}
                            @if (auth()->user()->username_limit == true)
                            <span class="change-item-biodata" item-biodata="nama" style="font-size: 13px;">Ubah</span></td>
                            @endif
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        @if (auth()->user()->tanggal_lahir != null)
                        <td>{{ auth()->user()->tanggal_lahir }}
                            @if (auth()->user()->tanggal_lahir_limit == true)
                            <span class="change-item-biodata" item-biodata="tanggal-lahir" style="font-size: 13px;" >Ubah Tanggal Lahir</span></td>
                            @endif
                        @else
                        <td><span class="change-item-biodata" item-biodata="tanggal-lahir" style="padding: 0px;font-size:13px;">Tambah Tanggal Lahir</span></td>
                        @endif
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        @if (auth()->user()->gender != null)
                            <td>{{ auth()->user()->gender }}</td>
                        @else
                            <td><span class="change-item-biodata" item-biodata="gender" style="padding: 0px;font-size:13px;">Tambah Jenis Kelamin</span></td>
                        @endif
                    </tr>
                    <tr>
                        <td><div class="header-ubah-kontak">Ubah Kontak</div></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        @if (auth()->user()->email != null)
                            <td>{{ auth()->user()->email }} <span class="change-item-biodata" item-biodata="email" style="font-size: 13px;">Ubah</span></td>
                        @else
                            <td><span class="change-item-biodata" item-biodata="email" style="padding: 0px;font-size:13px;">Tambah Email</span></td>
                        @endif
                    </tr>
                    <tr>
                        <td>Nomor HP</td>
                        <td>
                            @if (auth()->user()->telepon)
                            {{ auth()->user()->telepon }}
                            <span class="change-item-biodata" item-biodata="telepon" style="font-size: 13px;">Ubah</span>
                        </td>
                        @else
                        <td><span class="change-item-biodata" item-biodata="telepon" style="font-size: 13px;">Tambah Nomor Telepon</span></td>
                        @endif
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
</div>




<script>
    const popupChangeData = {
        'ubahNama' : `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                </div>
                <div class="popup-header">Ubah Username</div>
                <div class="popup-tipsrule">Harap menuliskan nama dengan pantas 
                    agar anda tidak mendapat pelanggaran dari kami
                </div>
                <div class="wrapper-form-change">
                    <form action="/user/profil/change/username" method="POST">
                        @csrf
                        <div class="wrapper-input-nama">
                            <label for="InputEdit">Nama</label>
                            <input type="text" class="inputnama" id="InputEdit" name="username" required>
                        </div>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>`,

        'ubahTanggal': `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                </div>
                <div class="popup-header">Ubah Tanggal lahir</div>
                <div class="popup-tipsrule">Kamu hanya bisa mengganti tanggal lahir 1 kali saja
                </div>
                <div class="wrapper-form-change">
                    <form action="/user/profil/change/tanggal-lahir" method="POST">
                        @csrf
                        <div class="wrapper-input">
                            <label for="InputEdit">Tanggal</label>
                            <input type="date" id="InputEdit" name="tanggal_lahir" required>
                        </div>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>`,

        'jeniskelamin' : `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                </div>
                <div class="popup-header">Ubah Tanggal lahir</div>
                <div class="popup-tipsrule">Kamu hanya bisa mengganti tanggal lahir 1 kali saja
                </div>
                <div class="wrapper-form-change">
                    <form action="/user/profil/change/gender" method="POST">
                        @csrf
                        <div class="wrapper-input wrapper-radio-input">
                            <div class="wrapper-input-pria">
                                <div >
                                    <label style="display: flex;align-items:center;">
                                        <input type="radio" name="gender" value="Laki-Laki" id="InputEdit" checked required>
                                    </label>
                                </div>
                                <img src="/asset/man.png" height="30" width="30" alt="">
                                <label>Pria</label>
                            </div>
                            <div class="wrapper-input-wanita">
                                <div >
                                    <label style="display: flex;align-items:center;">
                                        <input type="radio" name="gender" value="Perempuan" id="InputEdit" required>
                                    </label>
                                </div>
                                <img src="/asset/woman.png" height="30" width="30" alt="">
                                <label>Wanita</label>
                            </div>
                        </div>
                        
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        `,

        'email' : `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                </div>
                <div class="popup-header">Ubah Email</div>
                <div class="popup-tipsrule">Harap memasukan Email yang aktif 
                    untuk verifikasi
                </div>
                <div class="wrapper-form-change">
                    <form action="/user/profil/change/email" method="POST">
                        @csrf
                        <div class="wrapper-input-email">
                            <label for="InputEdit">Email</label>
                            <input type="email" class="inputemail" id="InputEdit" name="email" placeholder="warpedia@example.com" required>
                        </div>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        `,

        // VERIFIKASI TELEPON
        'email2': `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                </div>
                <div class="popup-header">Ubah Email</div>
                <div class="popup-tipsrule">Kami harus mengirimkan kode konfirmasi melalui Email anda untuk melakukan Verifikasi
                </div>
                <div class="wrapper-form-change wrapper-form-verifikasi-telepon">
                    <div class="verifikasi-nomor-telepon">
                        <img src="/asset/email.png" width="30" height="30" alt="">
                        <div class="default-nomor-telepon">Youremail@warpedia.com</div>
                    </div>
                </div>
                <div class="button-send-code" id="button-send-code" sub-id="email">Verifikasi</div>
            </div>
        </div>
        `,

        'email3': `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                </div>
                <div class="popup-header">Ubah Email</div>
                <div class="popup-tipsrule">Kami harus mengirimkan kode konfirmasi melalui Email anda untuk melakukan Verifikasi
                </div>
                <div class="wrapper-form-change">
                    <div class="wrapper-input-kode-otp">
                        <div style="font-family: Segoe UI;font-size:14px;font-weight: 600;">Kode OTP</div>
                        <input type="number" name="kode_otp" id="kode_otp" required>
                    </div>
                </div>
                <div class="button-check-otp" id="button-check-otp" sub-id="email">Verifikasi</div>
            </div>
        </div>
        `,

        'telepon' : `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="close">
                </div>
                <div class="popup-header">Ubah Nomor Telepon</div>
                <div class="popup-tipsrule">Harap memasukan Nomor Telepon yang aktif 
                    untuk verifikasi
                </div>
                <div class="wrapper-form-change">
                    <form action="/user/profil/change/telepon" method="POST">
                        @csrf
                        <div class="wrapper-input-telepon">
                            <label for="InputEdit">Nomor Telepon</label>
                            <input type="text" minlength="10" class="inputtelepon" id="InputEdit" name="telepon" required placeholder="+62">
                        </div>
                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        `,

        // VERIFIKASI TELPON
        'telepon2' : `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                </div>
                <div class="popup-header">Ubah Nomor Telepon</div>
                <div class="popup-tipsrule">Kami harus mengirimkan kode konfirmasi melalui Email anda untuk melakukan Verifikasi
                </div>
                <div class="wrapper-form-change wrapper-form-verifikasi-telepon">
                    <div class="verifikasi-nomor-telepon">
                        <img src="/asset/email.png" width="30" height="30" alt="">
                        <div class="default-nomor-telepon">Youremail@warpedia.com</div>
                    </div>
                </div>
                <div class="button-send-code" id="button-send-code" sub-id="telepon">Verifikasi</div>
            </div>
        </div>
        `,
        
        'telepon3' : `
        <div class="wrapper-popup">
            <div class="popup-changeBiodata">
                <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;">
                    <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                </div>
                <div class="popup-header">Ubah Nomor Telepon</div>
                <div class="popup-tipsrule">Silahkan Cek Email anda untuk melihat kode OTP yang kami kirim
                </div>
                <div class="wrapper-form-change">
                    <div class="wrapper-input-kode-otp">
                        <div style="font-family: Segoe UI;font-size:14px;font-weight: 600;">Kode OTP</div>
                        <input type="number" name="kode_otp" id="kode_otp" required>
                    </div>
                </div>
                <div class="button-check-otp" id="button-check-otp" sub-id="telepon">Verifikasi</div>
            </div>
        </div>
        `,

    }
    $('.change-item-biodata').click(function(){
        let getAttr = $(this).attr('item-biodata')
        if(getAttr == 'nama'){
            $('body').append(popupChangeData.ubahNama)
        }else if(getAttr == 'tanggal-lahir'){
            $('body').append(popupChangeData.ubahTanggal)
        }else if(getAttr == 'gender'){
            $('body').append(popupChangeData.jeniskelamin)
        }else if(getAttr == 'email'){
            $('body').append(popupChangeData.email2)
            sendCode();
        }else if(getAttr == 'telepon'){
            $('body').append(popupChangeData.telepon2)
            sendCode();
        }
    })

    function sendCode(){
        $('#button-send-code').click(function(){
            $('#button-send-code').html('')
            $('#button-send-code').append('Please Wait...')
            $(this).attr('id', 'empty');
            let subid = $(this).attr('sub-id');
                $.ajax({
                    url: window.location.origin + '/verifikasi/otp',
                    type: 'POST',
                    dataType: 'JSON',
                    data : {
                        "_token": "{{ csrf_token() }}",
                        'email':  '{{ auth()->user()->email }}',
                        'id': {{ auth()->user()->id }}
                    },
                    success:function(data){
                        $('.wrapper-popup').remove()
                        if(subid == 'email'){
                            $('body').append(popupChangeData.email3)
                        }else{
                            $('body').append(popupChangeData.telepon3)
                        }
                        checkOtpShow()
                    }
                })
        })
    }
    function checkOtpShow(){
        $('#button-check-otp').click(function(){
        let subid = $(this).attr('sub-id');
        $.ajax({
                'url': window.location.origin + '/verify/telpon/check-otp',
                'type': 'POST',
                'dataType': 'text',
                            'data' : {
                                "_token": "{{ csrf_token() }}",
                                'otp' : $('#kode_otp').val()
                            },
                            success:function(data){
                                $('.wrapper-popup').remove()
                                if(subid == 'email'){
                                    $('body').append(popupChangeData.email)
                                }else{
                                    $('body').append(popupChangeData.telepon)
                                }
                            }
            })              
        })
    }
    function closePopup(){
        $('.wrapper-popup').remove()
        $('.wrapper-popup-ubah-alamat').remove()
            event.preventDefault()
    }

    $('#foto-profil').change(function(){
        setTimeout(() => {
            let getExtc = $(this).val().substr($(this).val().length - 3)
            if(getExtc == 'jpg' || getExtc == 'png' || getExtc == 'jpeg'){
                $('#form-change-image').submit();
            }else{
                return false;
            }
        }, 100);
    })
    
    $('#link-navbar-beranda').click(function(){
        location.reload()
    })
    let timeout = 0;
    $('#link-daftar-alamat').click(function(){
        $('.navbar-link').removeClass('link-navbar-profil-active');
        $(this).addClass('link-navbar-profil-active');
        if(timeout == 1){
            return false;
        }
        $('#wrapper-list-alamat').html('');
        $('#content-item-navbar').removeClass('content-item-navbar-beranda');
        $('#content-item-navbar').addClass('content-item-navbar-daftar-alamat');
        $('#content-item-navbar').html(`
                <div class="button-tambah-alamat" id="button-tambah-alamat">
                    Tambahkan Alamat
                </div>
                <div class="wrapper-list-alamat" id="wrapper-list-alamat"></div>
        `)
        getAllAlamatUserAjax()
        
    })
    function getAllAlamatUserAjax(){
        $('#wrapper-list-alamat').html('');
        $.ajax({
            url : '/user/profil/getAlamat',
            type: 'GET',
            dataType : 'JSON',
            success:function(data){
                $('#wrapper-list-alamat').html('')
                for(let i = 0; i < data.length; i++){
                    $('#wrapper-list-alamat').append(`
                        <div class="item-alamat-profil">
                            <div class="keterangan-tempat" id="input-tempat" style="margin-top: 0px;">${data[i].nama_tempat}</div>
                            <div class="nama-penerima" id="input-nama-penerima">${data[i].nama}</div>
                            <div class="nomor-penerima" id="input-nomor-penerima">${data[i].nomor}</div>
                            <div class="alamat-lengkap-pemerima" >${data[i].alamat}</div>
                            <div class="ubah-alamat" id="ubah-alamat" alamat-id="${data[i].alamat_id}">Ubah Alamat</div>
                        </div>
                    `)
                }
                timeout++;
                createEventDaftarHalaman()
            }
        })
    }
    $('#link-riwayat-pesanan').click(function(){
        timeout = 0;
        $('.navbar-link').removeClass('link-navbar-profil-active')
        $(this).addClass('link-navbar-profil-active')
        $('#content-item-navbar').removeClass('content-item-navbar-beranda');
        $('#content-item-navbar').addClass('content-item-navbar-riwayat-pesanan');
        $('#content-item-navbar').html('Riwayat Pesanan');
    })

    function createEventDaftarHalaman(){
        $('.ubah-alamat').click(function(){
            closePopup();
            let tempat = $(this).parent().children().eq(0).html();
            let nama = $(this).parent().children().eq(1).html();
            let nomor = $(this).parent().children().eq(2).html();
            let alamat = $(this).parent().children().eq(3).html();
            let alamat_id = $(this).attr('alamat-id');
            let tempatSelected = '';
            if(tempat == 'Rumah'){
                tempatSelected = `
                <option value="Rumah" selected >Rumah</option>
                <option value="Kantor">Kantor</option>
                `;
            }else if(tempat == 'Kantor'){
                tempatSelected = `
                <option value="Rumah">Rumah</option>
                <option value="Kantor" selected>Kantor</option>
                `;
            }else{
                return alert('Kategori Tempat tidak sesuai');
            }
            $('.wrapper-popup-ubah-alamat').remove();
            $('body').append(`
                <div class="wrapper-popup-ubah-alamat">
                    <div class="popup-ubah-alamat">
                        <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;width: 95%;">
                            <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                        </div>
                        <div class="header-popup-ubah-alamat">Ubah Alamat</div>
                        <div class="form-popup-ubah-alamat">
                            <div class="form-input-item">
                                <div class="label-ubah-alamat">Tempat</div>
                                <select name="tempat" id="input-tempat-alamat">
                                `+tempatSelected+`
                                </select>
                                <span class="errormsginput" id="error_tempat"></span>
                            </div>
                            <div class="form-input-item">
                                <div class="label-ubah-alamat">Nama</div>
                                <input type="text" id="input-nama" value="${nama}">
                                <span class="errormsginput" id="error-nama"></span>
                            </div>
                            <div class="form-input-item">
                                <div class="label-ubah-alamat">Telepon</div>
                                <input type="text" id="input-nomor" value="${nomor}">
                                <span class="errormsginput" id="error-telepon"></span>
                            </div>
                            <div class="form-input-item">
                                <div class="label-ubah-alamat">Alamat Lengkap</div>
                                <textarea name="alamat" id="input-alamat" cols="30" rows="5" >${alamat}</textarea>
                                <span class="errormsginput" id="error-alamat"></span>
                            </div>
                        </div>
                        <div class="save-ubah-form" id="save-ubah-form" alamat-id="${alamat_id}" option="ubah-alamat">
                            Simpan
                        </div>
                    </div>
                </div>
            `)
            
            addSubmitEventAlamat()
    
        })

        $('#button-tambah-alamat').click(function(){
            closePopup();
            $('body').append(`
            <div class="wrapper-buat-alamat-baru wrapper-popup-ubah-alamat">
                <div class="popup-buat-alamat-baru popup-ubah-alamat">
                    <div class="wrapper-close-popup" style="text-align: end;margin-top:5px;width: 95%;">
                        <img src="/asset/close.png" onclick="closePopup()" class="button-close-popup" style="cursor: pointer;" width="25" width="25" alt="">
                    </div>
                    <div class="header-buat-alamat-baru header-popup-ubah-alamat">Tambahkan Alamat</div>
                    <div class="form-buat-alamat-baru form-popup-ubah-alamat">
                        <div class="form-input-item">
                            <div class="buat-alamat-baru label-ubah-alamat">Tempat</div>
                            <select name="tempat" id="input-tempat-alamat">
                                <option value="Rumah" selected>Rumah</option>
                                <option value="Kantor" >Kantor</option>
                            </select>
                            <span class="errormsginput" id="error-tempat"></span>
                        </div>
                        <div class="form-input-item">
                            <div class="label-buat-alamat-baru label-ubah-alamat">Nama</div>
                            <input type="text" id="input-nama">
                            <span class="errormsginput" id="error-nama"></span>
                        </div>
                        <div class="form-input-item">
                            <div class="label-buat-alamat-baru label-ubah-alamat">Telepon</div>
                            <input type="text" id="input-nomor">
                            <span class="errormsginput" id="error-telepon"></span>
                        </div>
                        <div class="form-input-item">
                            <div class="label-buat-alamat-baru label-ubah-alamat">Alamat Lengkap</div>
                            <textarea name="alamat" id="input-alamat" cols="30" rows="5" ></textarea>
                            <span class="errormsginput" id="error-alamat"></span>
                        </div>
                    </div>
                    <div class="simpan-buat-alamat-baru save-ubah-form" id="simpan-buat-alamat-baru" option="buat-alamat">
                        Simpan
                    </div>
                </div>
            </div>
            `)
            addSubmitEventAlamat()
        })


        function addSubmitEventAlamat(){
            $('#save-ubah-form, #simpan-buat-alamat-baru').click(function(){
                let allValueInputForm = {
                    tempat : $('#input-tempat-alamat').val(),
                    nama : $('#input-nama').val(),
                    telepon : $('#input-nomor').val(),
                    alamat : $('#input-alamat').val(),
                }
                if(
                    allValueInputForm.tempat == ''
                    || 
                    allValueInputForm.nama == '' 
                    || 
                    allValueInputForm.nomor == '' 
                    || 
                    allValueInputForm.alamat == ''
                ){
                    alert('Input tidak boleh kosong');
                    return false;
                 }
                 let alamat_id = '';
                 if($(this).attr('alamat-id') != undefined){
                    alamat_id = $(this).attr('alamat-id');
                 }else{
                    alamat_id = null
                 }
                 let optionURL = $(this).attr('option')
                 $.ajax({
                    url : 'profil/alamat/'+optionURL,
                    type: 'POST',
                    dataType : 'JSON',
                    data : {
                        _token : '{{ csrf_token() }}',
                        data : allValueInputForm,
                        id : alamat_id
                    },
                    beforesend:function(){
                        $('.errormsginput').text('')
                    },
                    success:function(data){
                        if(data.status == 0){
                            $.each(data.error, function(prefix, val){
                                $('#error-'+prefix).text(val[0])
                            })
                        }else{
                            closePopup()
                            getAllAlamatUserAjax()
                        }
                    },
                 })
            });
        }
    }

  
</script>
    
@endsection