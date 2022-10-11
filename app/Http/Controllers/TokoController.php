<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Otp;
use App\Models\Toko;
use App\Models\User;
use App\Models\Product;
use App\Models\Kategori;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Http\SendEmail\SendEmail;

class TokoController extends Controller
{
    public function dataPembuatanToko(Request $request)
    {
        if (auth()->user()->telepon == 'null') {
            if (
                $request->telpon_number === null || !is_numeric($request->telpon_number) ||
                $request->nama_toko === null || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $request->nama_toko)
            ) {
                return back();
            }
            $dataToko = [
                'nama_toko' => strtolower($request->nama_toko),
                'user_id' => auth()->user()->id,
                'telepon' => $request->telpon_number,
                'status' => 2
            ];
            if (!is_null(auth()->user()->email)) {
                $dataToko['email'] = auth()->user()->email;
            }
            if (count(Toko::where('user_id', auth()->user()->id)->get()) > 0) {
                return back();
            }
            User::where('id', auth()->user()->id)->update(['telepon' => $request->telpon_number]);
            Toko::create($dataToko);

            return redirect('/toko/dashboard');
        } elseif (auth()->user()->telepon !== 'null') {

            if ($request->nama_toko === null || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $request->nama_toko)) {
                return back();
            }

            $dataToko = [
                'nama_toko' => strtolower($request->nama_toko),
                'user_id' => auth()->user()->id,
                'telepon' => auth()->user()->telepon,
                'status' => 2
            ];
            if (!is_null(auth()->user()->email)) {
                $dataToko['email'] = auth()->user()->email;
            }
            if (count(Toko::where('user_id', auth()->user()->id)->get()) > 0) {
                return back();
            }

            Toko::create($dataToko);
            return redirect('/toko/dashboard');
        }

        return back();
    }

    public function dashboardTokoView()
    {
        return view('dashboard.index', [
            'title' => 'Dashboard Toko | Warpedia'
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
            ], 404);
        } else {
            Otp::where('user_id', auth()->user()->id)->delete();
            Toko::where('user_id', auth()->user()->id)->update(['status' => 1]);
            return response()->json(['message' => 'success verifikasi Toko'], 200);
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
                    'gambar_produk' => $namaFile
                ];
                Product::create($finaldata);

                return redirect('/toko/dashboard');
            } else {
                return back()->with('gambar-produk', 'Mohon format gambar bertipe PNG atau JPG!');
            }
        } catch (Exception $e) {
            return back()->with('message', 'Server Not Responding');
        }
    }
}
