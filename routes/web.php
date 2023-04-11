<?php
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\API\ApidaerahController;

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
Route::get('/register', [UserController::class, 'viewUserRegister'])->middleware('guest');

// INSERT DATA REGISTER
Route::post('/auth/register', [UserController::class, 'userRegisterAuth'])->middleware('guest');

// LOGIN VIEW
Route::get('/login', [UserController::class, 'viewUserLogin'])->middleware('guest')->name('login');
// INSERT DATA LOGIN
Route::post('/auth/login', [UserController::class, 'userLoginAuth'])->middleware('guest');
Route::get('/logout', [UserController::class, 'userLogout'])->middleware('auth');


// BUAT TOKO
Route::get('/buatToko', [UserController::class, 'viewBuatToko']);
Route::post('/buatToko/verify/sendmessage', [TokoController::class, 'dataPembuatanToko']);

//  VERIFIKASI TOKO
Route::post('/verifikasi/otp', [TokoController::class, 'sendVerification']);
Route::post('/check/otp', [TokoController::class, 'checkVerifikasiOTP']);

// CHECK NAMA TOKO
Route::post('/nama-toko/checking', [TokoController::class, 'checkNamaToko']);
Route::get('/toko/dashboard/buat-produk', [TokoController::class, 'dashboardBuatProduk']);

// DASHBOARD TOKO
Route::get('/toko/dashboard/beranda', [TokoController::class, 'dashboardTokoView']);
Route::get('/toko/dashboard/profil-toko', [TokoController::class, 'dashboardProfilToko']);


Route::get('/toko/dashboard/riwayat-pesanan', [TokoController::class, 'dashboardRiwayatPesanan']);

// AJAX OPTION RIWAYAT PESANAN
Route::get('/toko/dashboard/riwayat-pesanan/{option}', [TokoController::class, 'getDataPesanan']);

Route::get('/toko/dashboard/ulasan-pembeli', [TokoController::class, 'dashboardUlasanPembeli']);
Route::get('/toko/dashboard/detail-produk', [TokoController::class, 'dashboardDetailProduk']);
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

// ROUTE CHECKOUT 
Route::post('/keranjang/checkout', [CheckoutController::class, 'viewCheckout']);
Route::post('/pengiriman/getCost', [ApidaerahController::class, 'getCost']);

Route::post('/toko/insert-kota', [TokoController::class, 'insertKotaToko']);

Route::post('/keranjang/checkout/pembayaran', [PembayaranController::class, 'index'])->middleware('auth');
Route::post('/keranjang/checkout/pembayaran/send', [PembayaranController::class, 'store_data_pesanan'])->middleware('auth');

Route::get('/user/profil/riwayat-pesanan/{option}', [UserController::class, 'getRiwayatPesanan']);
Route::get('/user/profil/riwayat-pesanan/detail-pesanan/{option}/{id_produk}', [UserController::class, 'getDetailPesanan']);

Route::get('/user/message/index', [MessageController::class, 'getMessageIndex']);
Route::POST('/user/message/chat/get-data-person', [MessageController::class, 'getHistoryChat']);
Route::POST('/user/message/send-message', [MessageController::class, 'sendMessage']);
Route::POST('/user/message/update-chat-message', [MessageController::class, 'getChatDataRealTime']);
Route::POST('/user/message/check-person-message', [MessageController::class, 'getPersonMessageNew']);
Route::POST('/user/message/create-chat', [MessageController::class, 'createChatConnection']);

// Route::get('/notification/new-message', [MessageController::class, 'notificationMessageNavbar']);


// SEARCH PRODUK ROUTE
Route::get('/search', [HomeController::class, 'search_produk']);
Route::get('/search/kategori', [HomeController::class, 'search_kategori']);

