<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Petugas PDF</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        *{
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
            font-size: 20px;
            margin-bottom: -8px;
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
        <div style="width: 100%; text-align: center;"><h1>DAFTAR PEGAWAI</h1></div>
        <hr>
        <div style="width: 100%; text-align: center;"><p>Ref: KP Nomor: 77-KP-001 & AP Nomor 77-AP-001</p></div>
    </div>
    <div class="keterangan">
        {{-- <p style="margin-left: -55px;">UNIT ORGANISASI</p> --}}
        {{-- <p style="margin-top: -20px; margin-left: 150px;">:HD0000 (Divisi Pengembangan Sumber Daya Manusia)-DU</p> --}}
        {{-- <p style="margin-left: -55px;">DEPARTEMEN</p> --}}
        {{-- <p style="margin-top: -20px; margin-left: 150px;">:HD3000 (Dept. Pendidikan dan Pelatihan)</p> --}}
        {{-- <p style="margin-left: -55px;">NAMA GEDUNG</p> --}}
        {{-- <p style="margin-top: -20px; margin-left: 150px;">: K-TC (Kantor Training Center)</p> --}}
        {{-- <p style="margin-left: -55px;">NOMOR RUANGAN </p> --}}
        {{-- <p style="margin-top: -20px; margin-left: 150px;">: 02-021</p> --}}
    </div>
    <div class="table">
        <table>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>No. Telp</th>
                <th>Organisasi</th>
            </tr>
            @foreach ($pegawais as $pegawai)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pegawai->nik }}</td>
                    <td>{{ $pegawai->nama_user }}</td>
                    <td>
                        @if ($pegawai->jenis_kelamin === 'L')
                            Laki-Laki
                        @else
                            Perempuan
                        @endif
                    </td>
                    <td>{{ $pegawai->no_telepon }}</td>
                    <td>{{ $pegawai->organisasi }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    {{-- <div class="page-break"></div>
    <h1>Page 2</h1>
    <h1>Hello World</h1> --}}
</body>

</html>
