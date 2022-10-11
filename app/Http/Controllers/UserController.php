<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Otp;
use App\Models\Toko;
use App\Models\User;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        try {
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
            $finaldata['password'] = Hash::make($finaldata['password']);

            $fordatabase = [
                'email' => $request->emailOrNumber,
                'username' => $request->username,
                'password' => $finaldata['password'],
                'address' => 'null',
                'telepon' => 'null'
            ];
            if (is_numeric($request->emailOrNumber)) {
                $fordatabase['telepon'] = $request->emailOrNumber;
                $fordatabase['email'] = ' ';
            }
            User::create($fordatabase);
            return redirect('/login');
        } catch (Exception) {
            return back();
        }
    }

    public function userLoginAuth(Request $request)
    {
        if (is_numeric($request->emailOrPhone)) {
            $finaldata = $request->validate([
                'emailOrPhone' => 'required|numeric',
                'password' => 'required'
            ]);
            $checkData = [
                'telepon' => $finaldata['emailOrPhone'],
                'password' => $finaldata['password']
            ];
            if (Auth::attempt($checkData)) {
                $request->session()->regenerate();
                return redirect('/');
            }
        } else {
            $finaldata = $request->validate([
                'emailOrPhone' => 'required|email',
                'password' => 'required'
            ]);
            $checkData = [
                'email' => $finaldata['emailOrPhone'],
                'password' => $finaldata['password']
            ];

            if (Auth::attempt($checkData)) {
                $request->session()->regenerate();
                return redirect('/');
            }
        }

        return redirect('/login');
    }

    public function viewBuatToko()
    {
        if (count(Toko::where('user_id', auth()->user()->id)->get()) > 0) {
            return redirect('/toko/dashboard');
        }
        return view('buatToko', [
            'title' => 'Buat Toko Gratis | Warpedia',
            'css' => 'buattoko.css',
            'js' => 'buattoko.js'

        ]);
    }

    public function checkNamaToko(Request $request)
    {
        $namatoko = strtolower(strval($request->name));
        // CHECK THE WORD
        if (strlen($request->name) <= 0 || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $request->name)) {
            return false;
        }

        $getData = Toko::where('nama_toko', $namatoko)->get();
        if (count($getData) === 0) {
            return ['success' => 'Nama ini tersedia!'];
        } else {
            return ['fail' => 'Maaf nama ini sudah terpakai'];
        }
    }

    public function viewProfilUser()
    {
        return view('Profil.profil', [
            'title' => 'Warpedia | Profil',
            'css' => 'profil.css',
            'js' => 'profil.js'
        ]);
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
            $getAlamatUser = Alamat::where('user_id', auth()->user()->id)->get();
            $returnData = [];
            for ($i = 0; $i < count($getAlamatUser); $i++) {
                $pushArray = [
                    'alamat_id' => $getAlamatUser[$i]['id'],
                    'nama_tempat' => $getAlamatUser[$i]['tempat'],
                    'nama' => $getAlamatUser[$i]['nama'],
                    'nomor' => $getAlamatUser[$i]['telepon'],
                    'alamat' => $getAlamatUser[$i]['alamat_lengkap']
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
            // return $e->getMessage();
            return response()->json(['status' => '500', 'message' => 'Terjadi Kesalahan Server'], 500);
        }
    }
}
