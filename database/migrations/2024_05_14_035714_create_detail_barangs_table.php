<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengadaan'); //Otomatis terisi
            $table->string('no_barang'); //Dari Tabel Barang otomatis terisi
            $table->string('kode_barcode'); // Otomatis / Kode auto
            $table->string('no_asset'); // Diisikan oleh penginput dengan format ('KL'-'Input Sendiri'-'Input Sendiri')
            $table->string('merk'); // Barang nya Laptop Merek nya Acer jadi Laptop Acer
            // $table->date('tanggal_pengadaan'); // Pertama Kali barang ini ditempatkan dari status awalnya 'Belum Ditempatkan'
            $table->string('jenis_pengadaan'); // Pembelian - Donasi - Sumbangan - Hibah
            $table->string('spesifikasi'); // Intel Core i7 Ram 16 SSD
            $table->string('kondisi'); // Baik - Rusak
            $table->string('status'); //  Belum Ditempatkan atau Sudah Ditempatkan di Ruangan sekian
            $table->integer('harga'); // Rp. 20.000,00
            // $table->string('kode_aktiva');
            $table->string('keterangan'); // Pengadaan Baru untuk Buang duit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_barangs');
    }
};