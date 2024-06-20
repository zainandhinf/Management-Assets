<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Departemen</title>
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
                <th>No. Departemen</th>
                <th>Departemen</th>
            </tr>
        </thead>
        @php
            $no = 1;
        @endphp
        <tbody>
            @foreach ($departemens as $departemen)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $departemen->no_departemen }}</td>
                    <td>{{ $departemen->departemen }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
