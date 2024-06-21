<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Petugas</title>
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
                <th>NIK</th>
                <th>Nama User</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Username</th>
                <th>Role</th>
                {{-- <th>Tanggal Dibuat</th>
                <th>Tanggal Diperbarui</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($petugass as $petugas)
                <tr>
                    <td>{{ $petugas->nik }}</td>
                    <td>{{ $petugas->nama_user }}</td>
                    <td>{{ $petugas->jenis_kelamin }}</td>
                    <td>{{ $petugas->alamat }}</td>
                    <td>{{ $petugas->no_telepon }}</td>
                    <td>{{ $petugas->username }}</td>
                    {{-- <td>{{ $petugas->role }}</td> --}}
                    @if ($petugas->role == 'super_user')
                        <td>super user</td>
                    @else
                        <td>koordinator</td>
                    @endif
                    {{-- <td>{{ $petugas->created_at }}</td>
                    <td>{{ $petugas->updated_at }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
