<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Ruangan</title>
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
                <th>NO</th>
                <th>NO. RUANGAN</th>
                <th>NAMA RUANGAN</th>
                <th>LOKASI</th>
                <th>KAPASITAS</th>
                <th>TIPE RUANGAN</th>
            </tr>
        </thead>
        @php
            $no = 1;
        @endphp
        <tbody>
            @foreach ($ruangans as $ruangan)
            @php
            $nama_tipe = DB::table('tipe_ruangans')->where('id', $ruangan->tipe_ruangan)->first();
            @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $ruangan->no_ruangan }}</td>
                    <td>{{ $ruangan->ruangan }}</td>
                    <td>{{ $ruangan->lokasi }}</td>
                    <td>{{ $ruangan->kapasitas }}</td>
                    <td>{{ $nama_tipe->nama_tipe }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
