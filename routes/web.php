<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\KategoriController;

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

// Route utama, langsung diarahkan ke daftar arsip surat
Route::get('/', [SuratController::class, 'index'])->name('arsip.index');

// Resourceful routes untuk menangani semua aksi CRUD arsip surat
Route::resource('arsip', SuratController::class)->except(['index']);
Route::get('arsip/download/{id}', [SuratController::class, 'download'])->name('arsip.download');
Route::get('arsip/preview/{id}', [SuratController::class, 'preview'])->name('arsip.preview');

// Resourceful routes untuk menangani semua aksi CRUD kategori surat
Route::resource('kategori', KategoriController::class);

// Route untuk halaman "About"
Route::get('/about', function () {
    return view('about');
})->name('about');