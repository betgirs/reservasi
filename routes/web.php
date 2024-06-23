<?php
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\ProfileController;
use App\http\Controllers\ReservasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/dashboard', function () {
    return Inertia::render('User/beranda',[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
]);
})->name('dashboard');

Route::get('/opsss',function(){
    return Inertia::render('User/opsss');
})->name('opsss');

// Route::get('/dashboard', function () {
//     return Inertia::render('User/beranda');
// })->middleware(['auth', 'verified', 'role:user'])->name('dashboard');

// Route::get('/beranda',function(){
    //     return Inertia::render('User/beranda');
    // })->name('beranda');



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/ind', [MejaController::class, 'indexcoba'])->name('index');

// ========================= ADMINNN ====================================
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
   
//========== admin MEJA=========
Route::get('/create/meja',[MejaController::class, 'create'])->name('formTambahMeja');
Route::post('/create/meja',[MejaController::class, 'store'])->name('tambahMeja');
Route::get('/meja/index', [MejaController::class, 'index'])->name('IndexMeja');
Route::get('/edit/meja/{id_meja}', [MejaController::class, 'edit'])->name('editMeja');
Route::put('/update/meja/{id_meja}', [MejaController::class, 'update'])->name('updateMeja');
Route::delete('/meja/{id_meja}', [MejaController::class, 'destroy'])->name('deleteMeja');

//========== admin MENU=========
Route::get('/menu/index', [MenuController::class, 'index'])->name('IndexMenu');
Route::get('/create/menu',[MenuController::class,'create'])->name('formTambahMenu');
Route::post('/create/menu',[MenuController::class,'store'])->name('tambahMenu');
Route::get('/edit/menu/{id_menu}', [MenuController::class, 'edit'])->name('editMenu');
Route::put('/update/menu/{id_menu}', [MenuController::class, 'update'])->name('updateMenu');
Route::delete('/menu/{id_menu}', [MenuController::class, 'destroy'])->name('deleteMenu');


//==========ADMIN RESERVASI=========

Route::get('/reservasi/adminIndex', [ReservasiController::class, 'indexAdmin'])->name('konfirmasiReservasi');
Route::post('/reservasi/{id_reservasi}/status', [ReservasiController::class, 'updateStatus'])->name('updateStatusReservasi');
Route::get('/admin/reservasi/filter',[ReservasiController::class,'indexFilter'])->name('filter');

//==========ADMIN konfirmasi pembayaran=========

Route::get('/konfirmasiPembayaran', [PembayaranController::class, 'index'])->name('daftarPembayaran');
Route::post('/pembayaran/{id_pembayaran}/status', [PembayaranController::class, 'updateStatus'])->name('updateStatusPembayaran');
Route::get('/pembayaran/detail/{id_reservasi}',[PembayaranController::class,'show'])->name('detailPembayaran');


});


// ================= USERRR HUHU ========== =================================

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {

    // === BIKIN RESERVASI ======
    // Route::get('/beranda',function(){
    //     return Inertia::render('User/beranda');
    // })->name('beranda');
    Route::get('/create/reservasi', [ReservasiController::class, 'create'])->name('formReservasi');
    Route::post('/create/reservasi',[ReservasiController::class,'store'])->name('buatReservasi');
    Route::get('/reservasi',[ReservasiController::class,'index'])->name('daftarReservasi');
    Route::get('/reservasi/{id_reservasi}',[ReservasiController::class,'show'])->name('detailReservasi');
  

    // ============ Bikin pesanan ====================
    Route::get('/orders/create/{id_reservasi}',[PesananController::class, 'create'])-> name('formBuatPesanan');
    Route::post('/orders',[PesananController::class,'store'])->name('buatPesanan');
    Route::delete('/orders/{id_pesanan}',[PesananController::class,'destroy'])->name('hapusPesanan');
    Route::delete('/orders/delete/{id_reservasi}',[PesananController::class,'hapusSemua'])->name('hapusSemuaPesanan');

    // ================== Pembayaran =====================
    Route::get('/pembayaran/{id_reservasi}',[PembayaranController::class, 'create'])->name('formBayar');
    Route::post('/pembayaran/{id_reservasi}',[PembayaranController::class,'store'])->name('bayar');

});

require __DIR__.'/auth.php';
