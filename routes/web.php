<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SUController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [LoginController::class, 'login']);
Route::post('/loginrequest', [LoginController::class, 'loginrequest']);
Route::post('/logout', [LoginController::class, 'logout']);

//super user
Route::get('/dashboard', [SUController::class, 'index']);
Route::get('/petugas', [SUController::class, 'goPetugas']);
Route::get('/pegawai', [SUController::class, 'goPegawai']);
Route::get('/barang', [SUController::class, 'goBarang']);
Route::get('/kategori-barang', [SUController::class, 'goKBarang']);
Route::get('/ruangan', [SUController::class, 'goRuangan']);
Route::get('/tipe-ruangan', [SUController::class, 'goTRuangan']);
Route::get('/profile', [SUController::class, 'goProfile']);

//crud super user//
//kategoriBarang
Route::post('/addkategori', [SUController::class, 'addKategori']);
Route::put('/editkategori', [SUController::class, 'editKategori']);
Route::delete('/deletekategori', [SUController::class, 'deleteKategori']);

//tiperuangan
Route::post('/addtipe', [SUController::class, 'addTipe']);
Route::put('/edittipe', [SUController::class, 'editTipe']);
Route::delete('/deletetipe', [SUController::class, 'deleteTipe']);

//profil
Route::put('/editprofile', [SUController::class, 'editProfile']);
Route::put('/editpassword', [SUController::class, 'editPassword']);
Route::put('/uploadprofile', [SUController::class, 'editProfileImage']);

//petugas/koordinator
Route::post('/addpetugas', [SUController::class, 'addPetugas']);
Route::put('/editpetugas', [SUController::class, 'editPetugas']);
Route::delete('/deletepetugas', [SUController::class, 'deletePetugas']);

//pegawai
Route::post('/addpegawai', [SUController::class, 'addPegawai']);
Route::put('/editpegawai', [SUController::class, 'editPegawai']);
Route::delete('/deletepegawai', [SUController::class, 'deletePegawai']);

//barang-properti
Route::post('/addbarang', [SUController::class, 'addBarang']);
Route::put('/editbarang', [SUController::class, 'editBarang']);
Route::delete('/deletebarang', [SUController::class, 'deleteBarang']);


// end end crud super user
