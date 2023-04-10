<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Otp;
use App\Models\City;
use App\Models\Toko;
use App\Models\User;
use App\Models\Alamat;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApidaerahController;

class UserController extends Controller
{
    public function ViewUserRegister()
    {
        return view('auth.register', [
            'title' => 'Warpedia | Daftar',
            'css' => 'register.css',
            'js' => 'register.js'
        ]);
    }
    public function viewUserLogin()
    {
        return view('auth.login', [
            'title' => 'Warpedia | Masuk',
            'css' => 'login.css',
            'js' => 'login.js'
        ]);
    }

    // LOGOUT USER
    public function userLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // AUTH REGISTER
    public function userRegisterAuth(Request $request)
    {
        if (is_int($request->emailOrNumber)) {
            $finaldata = $request->validate([
                    'username' => 'required|max:250|regex:/^[a-zA-Z]+$/u',
                    'emailOrNumber' => 'required|numeric|max:250',
                    'password' => 'required|min:8|max:100'
                ]);
            } else {
                $finaldata = $request->validate([
                    'username' => 'required|max:250|regex:/^[a-zA-Z]+$/u',
                    'emailOrNumber' => 'required|max:250',
                    'password' => 'required|min:8|max:100'
                ]);
            }
        try {
            $finaldata['password'] = Hash::make($finaldata['password']);
            
            $fordatabase = [
                'email' => $request->emailOrNumber,
                'username' => $request->username,
                'password' => $finaldata['password'],
                'address' => null,
                'telepon' => null
            ];
            if (is_numeric($request->emailOrNumber)) {
                $fordatabase['telepon'] = $request->emailOrNumber;
                $fordatabase['email'] = null;
            }
            $fordatabase['connection_id'] = rand(0, 99999999) . $fordatabase['email'] . rand(0, 99999999) . $fordatabase['username'] . rand(0, 99999999);
            User::create($fordatabase);
            return redirect('/login');
        } catch (Exception) {
            return abort(500);
        }
    }

    public function userLoginAuth(Request $request)
    {
        if (is_numeric($request->emailOrPhone)) {
            $finaldata = $request->validate([
                'emailOrPhone' => 'required',
                'password' => 'required'
            ]);
            $checkData = [
                'telepon' => $finaldata['emailOrPhone'],
                'password' => $finaldata['password']
            ];
            if (Auth::attempt($checkData)) {
                $request->session()->regenerate();
                return redirect('/');
            }else{
                return back()->with('fail', 'Email atau Password salah!');
            }
        } else {
            $finaldata = $request->validate([
                'emailOrPhone' => 'required',
                'password' => 'required'
            ]);
            $checkData = [
                'email' => $finaldata['emailOrPhone'],
                'password' => $finaldata['password']
            ];

            if (Auth::attempt($checkData)) {
                $request->session()->regenerate();
                return redirect('/');
            }else{
                return back()->with('fail', 'Email atau Password salah!');
            }
        }

        return redirect('/login');
    }

    public function viewBuatToko()
    {
        if (count(Toko::where('user_id', auth()->user()->id)->get()) > 0) {
            return redirect('/toko/dashboard/beranda');
        }
        return view('buatToko', [
            'title' => 'Buat Toko Gratis | Warpedia',
            'css' => 'buattoko.css',
            'js' => 'buattoko.js'

        ]);
    }

    public function viewProfilUser()
    {
        if (Auth::check()) {
            $city = City::all();
            return view('Profil.profil', [
                'title' => 'Warpedia | Profil',
                'css' => 'profil.css',
                'js' => 'profil.js',
                'kota' => $city,
                'pesanan' => count(Pesanan::where('user_id', auth()->user()->id)->get())
            ]);
        } else {
            return redirect('/');
        }
    }

    public function changeDataUser($option, Request $request)
    {
        try {
            if (Auth::check()) {
                $getDataUserLogin = User::where('id', auth()->user()->id)->first(
                    [
                        'username_limit',
                        'tanggal_lahir_limit',
                        'telepon_limit',
                        'email_limit',
                        'telepon_verify'
                    ]
                );
                if ($option == 'username') {
                    $request->validate([
                        'username' => 'required|string'
                    ]);
                    if ($getDataUserLogin['username_limit'] == 0) {
                        return back()->with('username', 'Kamu hanya bisa melakukan 1 kali Perubahan');
                    } else {
                        User::where('id', auth()->user()->id)->update(
                            ['username' => $request->username, 'username_limit' => false]
                        );
                    }
                }
                if ($option == 'tanggal-lahir') {
                    $request->validate([
                        'tanggal_lahir' => 'required|date'
                    ]);
                    if ($getDataUserLogin['tanggal_lahir_limit'] == 0) {
                        return back()->with('tanggal_lahir', 'Kamu hanya bisa melakukan 1 kali Perubahan');
                    } else {
                        $formatDate = date("d-F-Y", strtotime($request->tanggal_lahir));
                        User::where('id', auth()->user()->id)->update(
                            ['tanggal_lahir' => str_replace('-', ' ', $formatDate), 'tanggal_lahir_limit' => false]
                        );
                    }
                }
                if ($option == 'gender') {
                    $request->validate([
                        'gender' => 'required|string'
                    ]);
                    if (auth()->user()->gender != null) {
                        return back()->with('gender', 'Kamu hanya bisa melakukan nya 1 kali');
                    }
                    if ($request->gender != 'Laki-Laki' && $request->gender !=  'Perempuan') {
                        return back()->with('gender', 'Pilih gender dengan Sesuai');
                    } else {
                        User::where('id', auth()->user()->id)->update(
                            ['gender' => $request->gender]
                        );
                    }
                }
                if ($option == 'email') {
                    $request->validate([
                        'email' => 'required|string|email:dns'
                    ]);
                    if ($getDataUserLogin['email_limit'] == 0) {
                        return back()->with('email', 'Kamu hanya bisa melakukan 1 kali Perubahan');
                    }
                    if ($getDataUserLogin['telepon_verify'] == 0) {
                        return back()->with('email', 'Kamu perlu melakukan verifikasi melalui no telepon');
                    } else {
                        User::where('id', auth()->user()->id)->update(
                            [
                                'email' => $request->email,
                                'email_limit' => false,
                                'telepon_verify' => false
                            ]
                        );
                        return back()->with('email', 'Email berhasil diubah!');
                    }
                }
                if ($option == 'telepon') {
                    $request->validate([
                        'telepon' => 'required|numeric'
                    ]);
                    if ($getDataUserLogin['telepon_limit'] == 0) {
                        return back()->with('telepon', 'Kamu hanya bisa melakukan 1 kali Perubahan');
                    }
                    if ($getDataUserLogin['telepon_verify'] == 0) {
                        return back()->with('telepon', 'Kamu perlu melakukan verifikasi melalui no telepon');
                    } else {
                        User::where('id', auth()->user()->id)->update(
                            [
                                'telepon' => $request->telepon,
                                'telepon_limit' => false,
                                'telepon_verify' => false
                            ]
                        );
                        return back()->with('telepon', 'Email berhasil diubah!');
                    }
                }
                return back();
            } else {
                return abort(404);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function checkEmailVerifikasi(Request $request)
    {
        if ($request->otp === null) {
            return response()->json([
                'message' => 'Kode OTP kosong',
                'status' => 'false'
            ], 404);
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
            User::where('id', auth()->user()->id)->update(['telepon_verify' => true]);
            return response()->json([
                'message' => 'Success',
                'status' => 'true'
            ], 200);
        }
    }

    public function changeFotoProfil(Request $request)
    {
        try {
            if (Auth::check()) {
                $request->validate([
                    'foto-profil' => 'required|image|file|max:5000'
                ]);
                if ($request->file('foto-profil') == null) {
                    return back()->with('message', 'File tidak boleh kosong!');
                }
                $file = $request->file('foto-profil');
                $namafile = md5_file($file->getRealPath());
                $getExtension = $file->guessExtension();
                $fullNameFile = $namafile . '.' . $getExtension;
                if ($getExtension == 'png' || $getExtension == 'jpg' || $getExtension == 'jpeg') {
                    $getUserData = User::where('id', auth()->user()->id);
                    $foto = $getUserData->first('foto_profil');
                    if ($foto != null) {
                        Storage::delete('public/image/' . $foto['foto_profil']);
                    }
                    $file->move(base_path('\storage\app\public\image'), $fullNameFile);
                    $getUserData->update(['foto_profil' => $fullNameFile]);
                } else {
                    return back()->with('message', 'File yang anda pilih tidak sesuai!');
                }
                return back()->with('message', 'Foto Profil berhasil diubah');
            } else {
                return abort(404);
            }
        } catch (Exception $e) {
            // return back()->with('message', 'Server Error');
            return abort(500);
        }
    }

    public function getAlamatUserLogin()
    {
        if (Auth::check()) {
            $getAlamatUser = Alamat::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
            $returnData = [];
            for ($i = 0; $i < count($getAlamatUser); $i++) {
                $pushArray = [
                    'alamat_id' => $getAlamatUser[$i]['id'],
                    'nama_tempat' => $getAlamatUser[$i]['tempat'],
                    'nama' => $getAlamatUser[$i]['nama'],
                    'nomor' => $getAlamatUser[$i]['telepon'],
                    'alamat' => $getAlamatUser[$i]['alamat_lengkap'],
                    'city' => $getAlamatUser[$i]['city']
                ];
                array_push($returnData, $pushArray);
            }
            return $returnData;
        } else {
            return response()->json(['message' => 'Silahkan Login Terlebih dahulu', 'status' => 'true'], 200);
        }
    }

    public function updateOrCreateAlamat($option, Request $request)
    {
        try {
            if (Auth::check()) {
                $validationData = Validator::make($request->data, [
                    'city_id' => 'required|numeric',
                    'tempat' => 'required|string',
                    'nama' => 'required|string|max:50',
                    'telepon' => 'required|string|numeric|digits_between:10,15',
                    'alamat' => 'required|string|'
                ]);
                if ($validationData->fails()) {
                    return response()->json(['status' => 0, 'error' => $validationData->errors()->toArray()]);
                }
                if ($request->data['tempat'] != 'Rumah' && $request->data['tempat'] != 'Kantor') {
                    return response()->json(['status' => 'true', 'message' => 'Pilihan tempat tidak sesuai!'], 200);
                }
                $finaldata = [
                    'city_id' => $request->data['city_id'],
                    'user_id' => auth()->user()->id,
                    'tempat' => $request->data['tempat'],
                    'nama' => $request->data['nama'],
                    'telepon' => $request->data['telepon'],
                    'alamat_lengkap' => $request->data['alamat'],
                ];
                if ($option == 'buat-alamat') {
                    Alamat::create($finaldata);
                    return response()->json(['status' => 'true', 'message' => 'Alamat baru telah ditambahkan!'], 200);
                } else if ($option == 'ubah-alamat') {
                    if ($request->id == null || !is_numeric($request->id)) {
                        return response()->json(['status' => 'false', 'message' => 'Alamat tidak ditemukan'], 200);
                    } else {
                        $alamat_id = $request->id;
                        Alamat::where([
                            'id' => $alamat_id,
                            'user_id' => auth()->user()->id
                        ])->update($finaldata);
                        return response()->json(['status' => 'true', 'message' => 'Alamat berhasil diubah!'], 200);
                    }
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => '500', 'message' => 'Terjadi Kesalahan Server'], 500);
        }
    }

    public function getRiwayatPesanan(Request $request, $option)
    {
        try {
            if ($request->ajax()) {
                if (Auth::check()) {
                    if ($option == 'perlu-dibayar') {
                        $pesanan = Pesanan::where([
                            ['user_id', auth()->user()->id],
                            ['transaction_status', 'pending']
                        ])->get();
                        $view = view('Profil.RiwayatPesanan.belumdibayar', [
                            'pesanan' => $pesanan,
                            'status' => 'pending'
                        ]);
                        return $view;
                    }

                    if ($option == 'sedang-dikemas') {
                        $pesanan = Pesanan::where([
                            ['user_id', auth()->user()->id],
                            ['transaction_status', 'settlement']
                        ])->get();
                        $view = view('Profil.RiwayatPesanan.sedangdikemas', [
                            'pesanan' => $pesanan,
                            'status' => 'settlement'
                        ]);
                        return $view;
                    }

                    if ($option == 'sedang-dikirim') {
                        $pesanan = Pesanan::where([
                            ['user_id', auth()->user()->id],
                            ['transaction_status', 'onroad']
                        ])->get();
                        $view = view('Profil.RiwayatPesanan.sedangdikirim', [
                            'pesanan' => $pesanan,
                            'status' => 'onroad'
                        ]);
                        return $view;
                    }
                    if ($option == 'penilaian') {
                        $pesanan = Pesanan::where([
                            ['user_id', auth()->user()->id],
                            ['transaction_status', 'success']
                        ])->get();
                        $view = view('Profil.RiwayatPesanan.penilaian', [
                            'pesanan' => $pesanan,
                            'status' => 'success'
                        ]);
                        return $view;
                    }
                } else {
                    return response()->json(['message' => 'error'], 500);
                }
            }
            return abort(500);
        } catch (Exception $e) {
            return response()->json(['message' => 'Server Error'], 500);
        }
    }

    public function getDetailPesanan(Request $request, $option, $id_produk)
    {
        try {
            if ($request->ajax() || Auth::check()) {
                $getPesanan = Pesanan::where([
                    ['id', $id_produk],
                    ['user_id', auth()->user()->id]
                ])->first();
                $filterData = [
                    'ekspedisi' => [
                        'ekspedisi_detail' => $getPesanan['ekspedisi'],
                        'origin' => $getPesanan['product']['toko']['city']['city_name'],
                        'destination' => $getPesanan['alamat']['city']['city_name'],
                        'ongkos_kirim' => $getPesanan['harga_ekspedisi']
                    ],
                    'alamat' => [
                        'tempat' => $getPesanan['alamat']['tempat'],
                        'nama' => $getPesanan['alamat']['nama'],
                        'nomor' => $getPesanan['alamat']['telepon'],
                        'jalan' => $getPesanan['alamat']['alamat_lengkap']
                    ],
                    'product' => [
                        'nama' => $getPesanan['product']['nama_produk'],
                        'gambar' => $getPesanan['product']['gambar_produk'],
                        'harga' => $getPesanan['product']['harga_produk'],
                        'nama_toko' => $getPesanan['product']['toko']['nama_toko'],
                    ],
                    'pesanan' => [
                        'quantity' => $getPesanan['quantity'],
                        'total_harga_pesanan' => number_format((str_replace('.', '', $getPesanan['product']['harga_produk']) * $getPesanan['quantity']) + $getPesanan['harga_ekspedisi'])
                    ],
                    'pembayaran' => [
                        'metode_pembayaran' => $getPesanan['payment']['payment_type'],
                        'token_pembayaran' => $getPesanan['payment']['payment_code'],
                        'status_pembayaran' => $getPesanan['transaction_status']
                    ]
                ];
                $view = view('Profil.RiwayatPesanan.detailpesanan_popup', [
                    'data' => $filterData,
                    'id_produk' => $getPesanan['product']['id'],
                    'option' => $option
                ])->render();
                return $view;
            } else {
                return response()->json(['message' => 'Server Error'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
}
