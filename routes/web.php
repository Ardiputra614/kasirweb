<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

// Routing

// Home Route
// Route::get('/', [HomeController::class, 'umum']);
// Route::get('/products', [HomeController::class, 'product']);

// Auth Route
Route::get('/', [AuthController::class, 'indexLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/cartsum', [HomeController::class, 'cartsum']);


Route::middleware(['auth'])->group(function () { //midelware
    Route::resource('stock', StockController::class);
    Route::get('/barcode-data', [StockController::class, 'getData'])->name('searchBarang');
    Route::post('/storeSearch', [StockController::class, 'storeSearch'])->name('storeSearch');

    Route::get('/umum', [HomeController::class, 'umum']);
    Route::get('/member', [HomeController::class, 'member']);
    Route::get('/memberData', [HomeController::class, 'dataMember']);
    Route::get('/grosir', [HomeController::class, 'grosir']);
    Route::get('/member-grosir', [HomeController::class, 'memberGrosir']);

    Route::resource('cart', KeranjangController::class);

    //route jumlah item keranjang
    Route::get('/product/{slug}', [OrderController::class, 'detailProduct']);
    Route::resource('cart', KeranjangController::class);

    // ROute lainnya
    Route::get('/detail/{no_faktur_jualan}', [KeranjangController::class, 'detail']);
    Route::post('/simpan', [KeranjangController::class, 'simpan']);
    Route::get('/print', [HomeController::class, 'print']);
    Route::get('/forgetSession', [HomeController::class, 'forgetSession']);
});
