<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Aktiva / Fasilitas Ruangan PDF</title>
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
        }

        .judul p {
            margin-top: -8px;
        }

        .judul h1 {
            margin-left: 180px;
            font-size: 20px;
        }

        .judul p {
            margin-left: 190px;
            font-size: 14px;
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
        <h1>DAFTAR AKTIVA TETAP RUANGAN</h1>
        <hr>
        <p>Ref: KP Nomor: 77-KP-001 & AP Nomor 77-AP-001</p>
    </div>
    <div class="keterangan">
        <p style="margin-left: -55px;">UNIT ORGANISASI</p>
        <p style="margin-top: -20px; margin-left: 150px;">:HD0000 (Divisi Pengembangan Sumber Daya Manusia)-DU</p>
        <p style="margin-left: -55px;">DEPARTEMEN</p>
        <p style="margin-top: -20px; margin-left: 150px;">:HD3000 (Dept. Pendidikan dan Pelatihan)</p>
        <p style="margin-left: -55px;">NAMA GEDUNG</p>
        <p style="margin-top: -20px; margin-left: 150px;">: K-TC (Kantor Training Center)</p>
        <p style="margin-left: -55px;">NOMOR RUANGAN </p>
        <p style="margin-top: -20px; margin-left: 150px;">: {{ $no_ruangan }}</p>
    </div>
    <div class="table">
        <table class="table table-striped" id="data-tables-keranjang">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Kondisi</th>
                    <th>Nama Pengguna</th>
                </tr>
            </thead>
            @foreach ($assets as $asset)
                @php
                    $nama_barang = DB::table('barangs')
                        ->select('*')
                        ->where('no_barang', '=', $asset->no_barang)
                        ->first();
                    $pengguna = DB::table('pegawais')
                        ->select('*')
                        ->where('id', '=', $asset->user_id)
                        ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>No Barang: <b>{{ $asset->no_barang }}</b> <br>Barcode:
                        <b>{!! DNS1D::getBarcodeHTML($asset->kode_barcode, 'UPCA') !!}{{ $asset->kode_barcode }}</b> <br>No Asset:
                        <b>{{ $asset->no_asset }}</b>
                    </td>
                    <td>{{ $nama_barang->nama_barang }}</td>
                    <td>{{ $asset->merk }}, {{ $asset->spesifikasi }}</td>
                    <td style="text-align: center;">{{ $asset->kondisi }}</td>
                    <td>{{ $pengguna->nama_user }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    @if ($count == 7)
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
                Asset Holder Unit masing-masing, selanjutnya Asset Holder melaporkan ke Fungsi Sentral Penglola Aktiva
                Tetap Perusahaan.</p>
            <p style="font-size: 13px; margin-top: -10px;">Contact Person Asset Holder Unit</p>
            <p style="font-size: 13px; margin-top: -30px; margin-left: 230px;">: </p>
            <p style="font-size: 13px; margin-top: -10px;">Contact Person Fungsi Sentral</p>
            <p style="font-size: 13px; margin-top: -30px; margin-left: 230px;">: Eden Surtika - PF4000 / 4184</p>
        </div>
    </div>
    {{-- <h1>Page 2</h1>
    <h1>Hello World</h1> --}}
</body>

</html>