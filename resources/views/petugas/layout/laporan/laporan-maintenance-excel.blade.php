<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $maintenances }}</title>
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
    @foreach ($maintenance as $item)
        @php
            $asset = DB::table('detail_barangs')
                ->select('*', 'detail_barangs.keterangan as keterangan_barang')
                ->join('maintenances', 'maintenances.kode_barcode', '=', 'detail_barangs.kode_barcode')
                ->where('maintenances.no_maintenance', $item->no_maintenance)
                // ->groupBy('no_ruangan')
                ->first();
        @endphp
    @endforeach
    <p style="margin-left: -55px;">NO MAINTENANCE : {{ $maintenance_detail->no_maintenance }}</p>
    <p style="margin-left: -55px;">TANGGAL MAINTENANCE : {{ $maintenance_detail->tanggal_maintenance }}</p>
    <p style="margin-left: -55px;">TANGGAL SELESAI : @if ($maintenance_detail->tanggal_selesai == null)
        @else
            {{ $maintenance_detail->tanggal_selesai }}
        @endif
    </p>
    <p style="margin-left: -55px;">BIAYA : RP. {{ number_format($maintenance_detail->biaya) }}</p>
    <p style="margin-left: -55px;">STATUS : {{ $maintenance_detail->status }}</p>
    <p style="margin-left: -55px;">KETERANGAN : {{ $maintenance_detail->keterangan }}</p>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA BARANG</th>
                <th>NOMOR KODIFIKASI</th>
                <th>KONDISI</th>
                <th>NAMA PENGGUNA</th>
                <th>KET</th>
            </tr>
        </thead>
        @php
            $no = 1;
            // dd($assets);
        @endphp

        <tbody>
            @php
                foreach ($maintenance as $item) {
                    $asset = DB::table('detail_barangs')
                        ->select('*', 'detail_barangs.keterangan as keterangan_barang')
                        ->join('maintenances', 'maintenances.kode_barcode', '=', 'detail_barangs.kode_barcode')
                        ->where('maintenances.no_maintenance', $item->no_maintenance)
                        // ->groupBy('no_ruangan')
                        ->first();
                }

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
                <td>{{ $asset->keterangan_barang }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
