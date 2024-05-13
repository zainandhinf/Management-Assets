<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SUController;
use App\Models\ruangan;
use Illuminate\Http\Request;


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
Route::get('/training', [SUController::class, 'goTraining']);
Route::get('/peserta-training', [SUController::class, 'goPeserta']);
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

//ruangan
Route::post('/addruangan', [SUController::class, 'addRuangan']);
Route::put('/editruangan', [SUController::class, 'editRuangan']);
Route::delete('/deleteruangan', [SUController::class, 'deleteRuangan']);
Route::post('/addimgruangan', [SUController::class, 'addimgRuangan']);
Route::delete('/deleteimgruangan', [SUController::class, 'deleteimgRuangan']);

//training
Route::post('/addtraining', [SUController::class, 'addTraining']);
Route::put('/edittraining', [SUController::class, 'editTraining']);
Route::delete('/deletetraining', [SUController::class, 'deleteTraining']);

//peserta training
Route::post('/addpeserta', [SUController::class, 'addPeserta']);
Route::put('/editpeserta', [SUController::class, 'editPeserta']);
Route::delete('/deletepeserta', [SUController::class, 'deletePeserta']);
// <!-- Route::get('/check-room-availability', function (Request $request) {
//     $tanggalMulai = $request->input('tanggal_mulai');
//     $tanggalSelesai = $request->input('tanggal_selesai');
//     $idRuangan = $request->input('id_ruangan');

//     // Lakukan logika untuk memeriksa ketersediaan ruangan
//     // Misalnya, dapatkan daftar reservasi ruangan pada tanggal tersebut

//     $ruangan = ruangan::findOrFail($idRuangan);

//     $available = $ruangan->checkAvailability($tanggalMulai, $tanggalSelesai);

//     return response()->json(['available' => $available]);
// }); -->

// end end crud super user //