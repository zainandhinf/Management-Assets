<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $penempatans }}</title>
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
    @foreach ($penempatan as $item)
        @php
            $assets = DB::table('detail_barangs')
                ->select('*')
                ->join('detail_penempatans', 'detail_penempatans.kode_barcode', '=', 'detail_barangs.kode_barcode')
                ->where('detail_penempatans.no_penempatan', $item->no_penempatan)
                // ->groupBy('no_ruangan')
                ->get();
                
        @endphp
    @endforeach
    @php
        $nama_ruangan = DB::table('ruangans')
        ->select('*')
        ->where('no_ruangan', '=', $penempatan_detail->no_ruangan)
        ->first();
    @endphp
    <p style="margin-left: -55px;">NO PENEMPATAN : {{ $penempatan_detail->no_penempatan }}</p>
    <p style="margin-left: -55px;">TANGGAL PENEMPATAN : {{ $penempatan_detail->tanggal_penempatan }}</p>
    <p style="margin-left: -55px;">LOKASI PENEMPATAN : ({{ $penempatan_detail->no_ruangan }})
        {{ $nama_ruangan->ruangan }}</p>
    <p style="margin-left: -55px;">KETERANGAN : {{ $penempatan_detail->keterangan }}</p>
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
            @foreach ($assets as $asset)
                @php
                    $nama_barang = DB::table('barangs')
                        ->select('*')
                        ->where('no_barang', '=', $asset->no_barang)
                        ->first();

                    // $no_penempatan = DB::table('detail_penempatans')
                    //     ->select('*')
                    //     ->where('kode_barcode', '=', $asset->kode_barcode)
                    //     ->first();

                    if ($asset->no_penempatan != null) {
                        $user_id = DB::table('penempatans')
                            ->select('*')
                            ->where('no_penempatan', '=', $asset->no_penempatan)
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
                    @if ($user_id == null || $user_id->user_id == null || $penempatan->no_penempatan == null)
                        <td></td>
                    @else
                        <td>{{ $pengguna->nama_user }}</td>
                    @endif
                    <td>{{ $asset->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
