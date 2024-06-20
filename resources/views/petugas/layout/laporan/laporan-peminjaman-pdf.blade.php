<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Peminjaman PDF</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        * {
            font-family: arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 97%;
            margin-left: 10px;
        }

        th {
            border: 1px solid black;
            /* border: 1px solid #dddddd; */
            text-align: center;
            padding: 8px;
        }

        td {
            border: 1px solid black;
            /* border: 1px solid #dddddd; */
            text-align: left;
            padding: 8px;
            font-size: 12px;
        }

        td:first-child {
            text-align: center;
            width: 5px;
        }

        tr:nth-child(even) {
            /* background-color: #dddddd; */
        }

        tr:first-child {}

        .logo img {
            width: 60px;
        }

        .logo .ptdi {
            margin-top: -55px;
            margin-left: 70px;
        }

        .logo p {
            font-size: 8px;
            /* font-weight: bold; */
        }

        .judul h1 {
            margin-bottom: -8px;
            font-size: 20px;
        }

        .judul p {
            font-size: 14px;
            margin-top: -8px;
        }

        .keterangan {
            margin-left: 120px;
            margin-bottom: 18px;
        }

        .keterangan p {
            font-size: 14px;
            margin: 0px;
        }

        .left {
            position: absolute;
            bottom: 0;
            margin-bottom: 180px;
            margin-left: 40px;
        }

        .right {
            position: absolute;
            bottom: 0;
            margin-bottom: 180px;
            margin-left: 420px;
        }

        .bottom {
            position: absolute;
            bottom: 0;
            margin-bottom: 60px;
            margin-left: 40px;
            width: 85%;
        }

        .line {
            display: inline-block;
            width: 100%;
            height: 1px;
            background-color: black;
            color: black;
        }
    </style>
</head>

<body>
    @foreach ($peminjamans as $peminjaman)
        @php
            $no = 1;
        @endphp
        <div class="logo">
            <img src="assets/image/logoPTDIterbarucrophitam.jpg" alt="">
            <div class="ptdi">
                <p style="margin-left: 8px;">DIRGANTARA INDONESIA</p>
                <p>INDONESIAN AEROSPACE (IAe)</p>
            </div>
        </div>
        <div class="judul">
            <div style="width: 100%; text-align: center;">
                <h1>DAFTAR PEMINJAMAN</h1>
            </div>
            <hr>
            <div style="width: 100%; text-align: center;">
                <p>Ref: KP Nomor: 77-KP-001 & AP Nomor 77-AP-001</p>
            </div>
        </div>
        <div class="keterangan">
            @php
                $pegawai = DB::table('pegawais')
                    ->select('*')
                    ->where('nik', '=', $peminjaman->id_pegawai)
                    ->first();
            @endphp
            {{-- <p style="margin-left: -55px;">UNIT ORGANISASI</p>
        <p style="margin-top: -20px; margin-left: 150px;">:HD0000 (Divisi Pengembangan Sumber Daya Manusia)-DU</p>
        <p style="margin-left: -55px;">DEPARTEMEN</p>
        <p style="margin-top: -20px; margin-left: 150px;">:HD3000 (Dept. Pendidikan dan Pelatihan)</p> --}}
            <p style="margin-left: -55px;">NO PEMINJAMAN</p>
            <p style="margin-top: -20px; margin-left: 150px;">: {{ $peminjaman->no_peminjaman }}</p>
            <p style="margin-left: -55px;">TANGGAL PEMINJAMAN</p>
            <p style="margin-top: -20px; margin-left: 150px;">: {{ $peminjaman->tanggal_peminjaman }} s/d
                {{ $peminjaman->tanggal_kembali }}</p>
            <p style="margin-left: -55px;">PEMINJAM</p>
            <p style="margin-top: -20px; margin-left: 150px;">: ({{ $pegawai->nik }}) {{ $pegawai->nama_user }}</p>
            <p style="margin-left: -55px;">STATUS PEMINJAMAN</p>
            <p style="margin-top: -20px; margin-left: 150px;">: {{ $peminjaman->status_peminjaman }}</p>
            <p style="margin-left: -55px;">KETERANGAN</p>
            <p style="margin-top: -20px; margin-left: 150px;">: {{ $peminjaman->keterangan }}</p>
        </div>
        <div class="table">
            <table class="table table-striped" id="data-tables-keranjang">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th style="row-gap: 10px;">NAMA BARANG</th>
                            <th>NOMOR <br> KODIFIKASI</th>
                            <th>KONDISI</th>
                            <th>NAMA <br> PENGGUNA</th>
                            <th>KET</th>
                        </tr>
                    </thead>
                    @php
                    // dd($request->query('kode_barcode'));
                    if ($kode_barcode != null) {
                        $assets = DB::table('detail_barangs')
                            ->select('*')
                            ->join(
                                'detail_peminjamans',
                                'detail_peminjamans.kode_barcode',
                                '=',
                                'detail_barangs.kode_barcode',
                            )
                            ->where('detail_peminjamans.kode_barcode', $kode_barcode)
                            ->where('detail_peminjamans.no_peminjaman', $peminjaman->no_peminjaman)
                            // ->groupBy('no_ruangan')
                            ->get();
                    } else {
                        $assets = DB::table('detail_barangs')
                            ->select('*')
                            ->join(
                                'detail_peminjamans',
                                'detail_peminjamans.kode_barcode',
                                '=',
                                'detail_barangs.kode_barcode',
                            )
                            ->where('detail_peminjamans.no_peminjaman', $peminjaman->no_peminjaman)
                            // ->groupBy('no_ruangan')
                            ->get();
                    }
                @endphp
                @foreach ($assets as $asset)
                    @php
                        $nama_barang = DB::table('barangs')
                            ->select('*')
                            ->where('no_barang', '=', $asset->no_barang)
                            ->first();

                        $no_penempatan = DB::table('detail_penempatans')
                            ->select('*')
                            ->where('kode_barcode', '=', $asset->kode_barcode)
                            ->first();

                        if ($no_penempatan != null) {
                            $user_id = DB::table('penempatans')
                                ->select('*')
                                ->where('no_penempatan', '=', $no_penempatan->no_penempatan)
                                ->first();
                            $pengguna = DB::table('pegawais')
                                ->select('*')
                                ->where('id', '=', $user_id->user_id)
                                ->first();
                        } else {
                            $user_id = null;
                        }
                    @endphp
                    @php
                        if ($kode_barcode) {
                            $assets = DB::table('detail_barangs')
                                ->select('*')
                                ->join(
                                    'detail_peminjamans',
                                    'detail_peminjamans.kode_barcode',
                                    '=',
                                    'detail_barangs.kode_barcode',
                                )
                                ->where('detail_peminjamans.kode_barcode', $kode_barcode)
                                ->where('detail_peminjamans.no_peminjaman', $peminjaman->no_peminjaman)
                                // ->groupBy('no_ruangan')
                                ->count();
                        } else {
                            $assets = DB::table('detail_barangs')
                                ->select('*')
                                ->join(
                                    'detail_peminjamans',
                                    'detail_peminjamans.kode_barcode',
                                    '=',
                                    'detail_barangs.kode_barcode',
                                )
                                ->where('detail_peminjamans.no_peminjaman', $peminjaman->no_peminjaman)
                                // ->groupBy('no_ruangan')
                                ->count();
                        }
                    @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>No Barang: <b>{{ $asset->no_barang }}</b> <br>Barcode:
                        <b>{!! DNS1D::getBarcodeHTML($asset->kode_barcode, 'UPCA') !!}{{ $asset->kode_barcode }}</b> <br>No Asset:
                        <b>{{ $asset->no_asset }}</b>
                        </td> --}}
                        {{-- <td>{{ $nama_barang->nama_barang }}</td> --}}
                        <td>{{ $nama_barang->nama_barang }}, {{ $asset->merk }}</td>
                    <td style="text-align: center;">{{ $asset->nomor_kodifikasi }}</td>
                    {{-- <td>{{ $asset->merk }}, {{ $asset->spesifikasi }}</td> --}}
                    <td style="text-align: center;">{{ $asset->kondisi }}</td>
                    {{-- <td>{{ $pengguna->nama_user }}</td> --}}
                        @if ($user_id == null || $user_id->user_id == null || $no_penempatan->no_penempatan == null)
                            <td></td>
                        @else
                            <td>{{ $pengguna->nama_user }}</td>
                        @endif
                    <td>{{ $asset->keterangan }}</td>
                </tr>
            @endforeach
            </table>
        </div>

        @php
            $count = DB::table('detail_peminjamans')
                ->select('*')
                // ->join('pengadaans', 'pengadaans.no_pengadaan', '=', 'detail_barangs.no_pengadaan')
                ->where('no_peminjaman', $peminjaman->no_peminjaman)
                // ->groupBy('no_ruangan')
                ->count();
        @endphp
        @if ($count > 4)
            <div class="page-break"></div>
        @endif
        <div class="footer">
            <div class="left">
                <p style="font-size: 12px; font-weight: bold;">Mengetahui:</p>
                <p style="font-size: 12px; font-weight: bold; margin-top: -10px;">PENANGGUNG JAWAB AKTIVA TETAP</p>
                <span class="line" style="margin-top: 80px;"></span>
            </div>
            <div class="right">
                <p style="font-size: 12px; font-weight: bold; margin-top: -10px;">Bandung,</p>
                <p style="font-size: 12px; font-weight: bold; margin-top: -10px;">PENANGGUNG JAWAB RUANGAN</p>
                <span class="line" style="margin-top: 80px;"></span>
            </div>
            <div class="bottom">
                <p style="font-size: 13px; margin-top: -10px;">Catatan:</p>
                <p style="font-size: 13px; margin-top: -10px;">Setiap perpindahan/perubahan aset harus melaporkan kepada
                    Asset Holder Unit masing-masing, selanjutnya Asset Holder melaporkan ke Fungsi Sentral Penglola
                    Aktiva
                    Tetap Perusahaan.</p>
                <p style="font-size: 13px; margin-top: -10px;">Contact Person Asset Holder Unit</p>
                <p style="font-size: 13px; margin-top: -30px; margin-left: 230px;">: </p>
                <p style="font-size: 13px; margin-top: -10px;">Contact Person Fungsi Sentral</p>
                <p style="font-size: 13px; margin-top: -30px; margin-left: 230px;">: Eden Surtika - PF4000 / 4184</p>
            </div>
        </div>
        {{-- <h1>Page 2</h1>
        <h1>Hello World</h1> --}}
        <div class="page-break"></div>
    @endforeach
</body>

</html>
