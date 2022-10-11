<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\KeranjangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// HOME VIEW ROUTE
Route::get('/', [HomeController::class, 'homeView']);

// DETAIL PRODUCT
Route::get('/product/{id}/{slug}', [HomeController::class, 'viewDetailProduct']);

// REGISTER VIEW
Route::get('/register', [UserController::class, 'viewUserRegister']);

// INSERT DATA REGISTER
Route::post('/auth/register', [UserController::class, 'userRegisterAuth']);

// LOGIN VIEW
Route::get('/login', [UserController::class, 'viewUserLogin']);
// INSERT DATA LOGIN
Route::post('/auth/login', [UserController::class, 'userLoginAuth']);
Route::get('/logout', [UserController::class, 'userLogout']);


// BUAT TOKO
Route::get('/buatToko', [UserController::class, 'viewBuatToko']);
Route::post('/buatToko/verify/sendmessage', [TokoController::class, 'dataPembuatanToko']);

//  VERIFIKASI TOKO
Route::post('/verifikasi/otp', [TokoController::class, 'sendVerification']);
Route::post('/check/otp', [TokoController::class, 'checkVerifikasiOTP']);

// CHECK NAMA TOKO
Route::post('/nama-toko/checking', [UserController::class, 'checkNamaToko']);
Route::get('/toko/dashboard', [TokoController::class, 'dashboardTokoView']);
Route::get('/toko/dashboard/buat-produk', [TokoController::class, 'dashboardBuatProduk']);

// DASHBOARD TOKO
Route::post('/store/buat-produk', [TokoController::class, 'storeDataProduk']);

// STORAGE
Route::get('/storage/{filename}', function ($filename) {
    $path = storage_path('app/public/image/' . $filename);
    if (!File::exists($path)) {
        return null;
    }
    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

// HALAMAN KERANJANG
Route::get('/keranjang', [KeranjangController::class, 'index']);
// MASUKAN KERANJANG
Route::post('/insert/keranjang', [KeranjangController::class, 'insertKeranjang']);
// MENGUBAH JUMLAH PESANAN KERANJANG/PRODUK
Route::post('/change/count', [KeranjangController::class, 'ubahJumlahPesanan']);
// MENGHAPUS PRODUK KERANJANG
Route::post('/produk-keranjang/delete-item/{id}', [KeranjangController::class, 'deleteItemKeranjang']);

// CHECKOUT KERANJANG 
Route::post('/keranjang/checkout', [KeranjangController::class, 'prosesCheckoutKeranjang']);

// PROFIL USER
Route::get('/user/profil', [UserController::class, 'viewProfilUser']);
// UBAH DATA USER
Route::post('/user/profil/change/{option}', [UserController::class, 'changeDataUser'])->middleware('auth');
Route::post('/verify/telpon/check-otp', [UserController::class, 'checkEmailVerifikasi']);

// CHANGE FOTO PROFIL
Route::post('/user/profil/foto-profil/change', [UserController::class, 'changeFotoProfil']);

// GET ALAMAT USER 
Route::get('/user/profil/getAlamat', [UserController::class, 'getAlamatUserLogin']);

// UPDATE AND CREATE ALAMAT
Route::post('/user/profil/alamat/{option}', [UserController::class, 'updateOrCreateAlamat']);
