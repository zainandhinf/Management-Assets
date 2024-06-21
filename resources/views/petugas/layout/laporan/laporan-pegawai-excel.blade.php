<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Pegawai</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>No. Telp</th>
                <th>Organisasi</th>
            </tr>
        </thead>
        @php
            $no = 1;
        @endphp
        <tbody>
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
                @php
                    $organisasi = DB::table('departemens')->where('id', $pegawai->id_departemen)->first(); 
                @endphp
                <td>{{ $organisasi->departemen }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>

</html>
