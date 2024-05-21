<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SUController;
use App\Http\Controllers\PController;
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
Route::put('/edit-infotraining', [SUController::class, 'editInfoTraining']);
Route::delete('/deletetraining', [SUController::class, 'deleteTraining']);

//peserta training
Route::post('/addpeserta', [SUController::class, 'addPeserta']);
Route::put('/editpeserta', [SUController::class, 'editPeserta']);
Route::delete('/deletepeserta', [SUController::class, 'deletePeserta']);
Route::get('/getUserByNik', [SUController::class, 'getUserByNik']);
// end end crud super user //

//petugas - Koordinator
Route::get('/dashboard-koordinator', [PController::class, 'index']);
Route::get('/petugas-koordinator', [PController::class, 'goPetugas']);
Route::get('/pegawai-koordinator', [PController::class, 'goPegawai']);
Route::get('/barang-koordinator', [PController::class, 'goBarang']);
Route::get('/kategori-barang-koordinator', [PController::class, 'goKBarang']);
Route::get('/ruangan-koordinator', [PController::class, 'goRuangan']);
Route::get('/tipe-ruangan-koordinator', [PController::class, 'goTRuangan']);
Route::get('/training-koordinator', [PController::class, 'goSchedule']);
Route::get('/peserta-training-koordinator', [PController::class, 'goPeserta']);



// TRANSAKSI PENGADAAN //
Route::get('/pengadaan', [PController::class, 'goPengadaan']);
Route::get('/pengadaan-tambah', [PController::class, 'goPengadaanTambah']);

Route::get('/penempatan', [PController::class, 'goPenempatan']);
Route::get('/penempatan-tambah', [PController::class, 'goPenempatanTambah']);

Route::get('/mutasi', [PController::class, 'goMutasi']);
Route::get('/mutasi-tambah', [PController::class, 'goMutasiTambah']);



//
Route::post('/pengadaan-tambah-barang', [PController::class, 'select']);
Route::post('/addkeranjang', [PController::class, 'addKeranjang']);
Route::delete('/deletekeranjang', [PController::class, 'deleteKeranjang']);
Route::post('/addpengadaan', [PController::class, 'addPengadaan']);
Route::delete('/deletedetail', [PController::class, 'deleteDetail']);
// TRANSAKSI PENGADAAN END END//

// TRANSAKSI PENEMPATAN //
Route::get('/penempatan', [PController::class, 'goPenempatan']);
Route::get('/penempatan-tambah', [PController::class, 'goPenempatanTambah']);
Route::post('/addkeranjangpenempatan', [PController::class, 'addKeranjangPenempatan']);
Route::delete('/deletekeranjangpenempatan', [PController::class, 'deleteKeranjangPenempatan']);
Route::post('/addpenempatan', [PController::class, 'addPenempatan']);
// TRANSAKSI PENEMPATAN END END//

// TRANSAKSI PEMINJAMAN //
Route::get('/peminjaman', [PController::class, 'goPeminjaman']);
Route::get('/peminjaman-tambah', [PController::class, 'goPeminjamanTambah']);
Route::post('/addkeranjangpeminjaman', [PController::class, 'addKeranjangPeminjaman']);
Route::delete('/deletekeranjangpeminjaman', [PController::class, 'deleteKeranangPeminjaman']);
Route::post('/addpeminjaman', [PController::class, 'addPeminjaman']);
// TRANSAKSI PEMINJAMAN END END//


Route::post('/addkeranjangmutasi', [PController::class, 'addKeranjangMutasi']);
Route::delete('/deletekeranjangmutasi', [PController::class, 'deleteKeranjangMutasi']);
Route::post('/addmutasi', [PController::class, 'addMutasi']);

Route::get('/profile-koordinator', [PController::class, 'goProfile']);
//END END petugas - Koordinator

