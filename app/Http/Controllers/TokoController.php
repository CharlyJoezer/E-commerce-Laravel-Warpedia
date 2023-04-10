<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Otp;
use App\Models\City;
use App\Models\Toko;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Product;
use Twilio\Rest\Client;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\SendEmail\SendEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    public function dataPembuatanToko(Request $request)
    {
        try{
            if (auth()->user()->email == null) {
                if ($request->email === null || is_numeric($request->email) ||
                    $request->nama_toko === null || !preg_match('/^[a-zA-Z0-9`]+$/', $request->nama_toko)
                ) {
                    return back()->with('fail', 'Harap menuliskan email yang benar!');
                }

                (bool) $checkAlreadyNamaToko = count(Toko::where('nama_toko', $request->nama_toko)->get()) > 0;
                if($checkAlreadyNamaToko){
                    return back()->with('fail', 'Nama toko sudah dipakai!');
                } 

                $dataToko = [
                    'nama_toko' => strtolower($request->nama_toko),
                    'user_id' => auth()->user()->id,
                    'email' => $request->email,
                    'status' => 2
                ];
                if (!is_null(auth()->user()->telepon)) {
                    $dataToko['telepon'] = auth()->user()->telepon;
                }
                if (count(Toko::where('user_id', auth()->user()->id)->get()) > 0) {
                    return back()->with('fail','Anda hanya bisa memiliki 1 Toko');
                }
                DB::beginTransaction();
                try{
                    User::where('id', auth()->user()->id)->update(['email' => $request->email]);
                    Toko::create($dataToko);

                    DB::commit();
                }catch(Exception){
                    DB::rollback();
                    return back()->with('fail', 'Server Error');
                }
    
                return redirect('/toko/dashboard/beranda');
            } elseif (auth()->user()->email !== null) {
                if ($request->nama_toko === null || 
                !preg_match('/^[a-zA-Z0-9`]+$/', $request->nama_toko)) {
                    return back()->with('fail', 'Nama toko hanya bisa mengandung huruf dan angka');
                }


                (bool) $checkAlreadyNamaToko = count(Toko::where('nama_toko', $request->nama_toko)->get()) > 0;
                if($checkAlreadyNamaToko){
                    return back()->with('fail', 'Nama toko sudah dipakai!');
                } 



                $dataToko = [
                    'nama_toko' => strtolower($request->nama_toko),
                    'user_id' => auth()->user()->id,
                    'telepon' => '-',
                    'status' => 2
                ];
                if (isset(auth()->user()->email)) {
                    $dataToko['email'] = auth()->user()->email;
                }
                if (count(Toko::where('user_id', auth()->user()->id)->get()) > 0) {
                    return back()->with('fail','Anda hanya bisa memiliki 1 Toko');
                }
                try{
                    Toko::create($dataToko);
                }catch(Exception){
                    return back()->with('fail', 'Gagal membuat Toko!');
                }
                return redirect('/toko/dashboard/beranda')->with('success', 'Selamat Toko kamu berhasil dibuat!');
            }
    
            return back()->with('fail', 'Terjadi Kesalahan');
            
        }catch(Exception){
            return abort(500, ['status' => 500, 'message' => 'Server not respond!']);
        }
    }

    public function dashboardTokoView()
    {
        $city = City::all();
        $getPesananUser = Pesanan::where('toko_id', auth()->user()->toko->id)->withonly([])->get();
        $getCountPerluDikemas = 0;
        $getCountSiapDikirim = 0;
        $getCountSedangDikirim = 0;
        $getCountSuccess = 0;
        for ($a = 0; $a < count($getPesananUser); $a++) {
            if ($getPesananUser[$a]['transaction_status'] == 'settlement') {
                $getCountPerluDikemas++;
            }
            if ($getPesananUser[$a]['transaction_status'] == 'readyship') {
                $getCountSiapDikirim++;
            }
            if ($getPesananUser[$a]['transaction_status'] == 'onroad') {
                $getCountSedangDikirim++;
            }
            if ($getPesananUser[$a]['transaction_status'] == 'success') {
                $getCountSuccess++;
            }
        }
        return view('dashboard.index', [
            'title' => 'Dashboard Toko | Warpedia',
            'citys' => $city,
            'pesanan' => $getPesananUser,
            'perludikemas' => $getCountPerluDikemas,
            'siapdikirim' => $getCountSiapDikirim,
            'sedangdikirim' => $getCountSedangDikirim,
            'ordersuccess' => $getCountSuccess
        ]);
    }

    public function dashboardProfilToko()
    {
        return view('dashboard.profil_toko', [
            'title' => 'Profil Toko | Warpedia Dashboard'
        ]);
    }

    public function dashboardRiwayatPesanan()
    {
        return view('dashboard.riwayat_pesanan', [
            'title' => 'Riwayat Pesanan | Warpedia Dashboard'
        ]);
    }

    public function dashboardBuatProduk()
    {
        $kategori = Kategori::all();
        return view('dashboard.buat-produk', [
            'title' => 'Dashboard Toko | Warpedia',
            'kategori' => $kategori
        ]);
    }

    public function dashboardDetailProduk()
    {
        return view('dashboard.detail-produk', [
            'title' => 'Detail Produk | Warpedia'
        ]);
    }

    public function dashboardUlasanPembeli()
    {
        return view('dashboard.ulasan-pembeli', [
            'title' => 'Ulasan Pembeli | Warpedia'
        ]);
    }



    public function sendVerification(Request $request)
    {
        try {
            if ($request->email == null) {
                return ['message' => 'Wrong Input'];
            }
            $otp = Otp::where('user_id', auth()->user()->id)->first('kode_otp');
            if ($otp === null) {
                $number = rand(100000, 999999);
                $createOtp = [
                    'kode_otp' => $number,
                    'user_id' => auth()->user()->id,
                    'toko_id' => auth()->user()->toko->id
                ];
                Otp::create($createOtp);
                $otp = Otp::where('user_id', auth()->user()->id)->first('kode_otp');
            }
            $sendemail = new SendEmail();
            $sendemail->sendEmail($otp['kode_otp'], $request->email);

            return response()->json(['status' => '200', 'message' => 'Email has been sended!']);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function checkVerifikasiOTP(Request $request)
    {
        if ($request->otp === null) {
            return 'null';
        }
        $getOtp = Otp::where([
            'kode_otp' => $request->otp,
            'user_id' => auth()->user()->id
        ])->first();
        if ($getOtp == null) {
            return response()->json([
                'message' => 'Kode Otp tidak ditemukan',
                'status' => 'false'
            ], 200);
        } else {
            Otp::where('user_id', auth()->user()->id)->delete();
            Toko::where('user_id', auth()->user()->id)->update(['status' => 1]);
            return response()->json(['message' => 'success verifikasi Toko', 'status' => 'true'], 200);
        }
    }

    public function storeDataProduk(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_produk' => 'required|max:50',
                'kategori'    => 'required|numeric',
                'deskripsi_produk' => 'required',
                'harga_produk' => 'required|numeric',
                'stok_produk' => 'required|numeric',
                'minimal_pesanan' => 'required|numeric',
                'berat_produk' => 'required|numeric'
            ]);

            $md5Name = md5_file($request->file('gambar_produk')->getRealPath());
            $guessExtension = $request->file('gambar_produk')->guessExtension();

            if ($guessExtension == 'png' || $guessExtension == 'jpg') {
                $namaFile = $md5Name . '.' . $guessExtension;
                $request->file('gambar_produk')->move(base_path('\storage\app\public\image'), $namaFile);
                $finaldata = [
                    'nama_produk' => $validatedData['nama_produk'],
                    'user_id'    => auth()->user()->id,
                    'kategori_id'    => (int)$validatedData['kategori'],
                    'toko_id'    => auth()->user()->toko->id,
                    'deskripsi_produk' => $validatedData['deskripsi_produk'],
                    'harga_produk' => number_format($validatedData['harga_produk'], 0, ",", "."),
                    'stok_produk' => $validatedData['stok_produk'],
                    'minimal_pesan' => $validatedData['minimal_pesanan'],
                    'gambar_produk' => $namaFile,
                    'berat' => $validatedData['berat_produk']
                ];
                $finaldata['nama_produk'] = str_replace('/',' ',$finaldata['nama_produk']);
                Product::create($finaldata);

                return redirect('/toko/dashboard/beranda');
            } else {
                return back()->with('gambar-produk', 'Mohon format gambar bertipe PNG atau JPG!');
            }
        } catch (Exception $e) {
            return back()->with('message', 'Server Not Responding');
        }
    }

    public function insertKotaToko(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'citys' => 'required|string|numeric'
            ]);
            Toko::where('user_id', auth()->user()->id)->update(['city' => $request->citys]);
            return redirect('/toko/dashboard/beranda');
        } else {
            abort(403);
        }
    }
}
