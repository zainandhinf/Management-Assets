@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    {{-- <th>Foto Profil</th> --}}
                    {{-- <th>Alamat</th> --}}
                    {{-- <th>No Telepon</th> --}}
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    {{-- <th>Tanggal Pengadaan</th> --}}
                    <th>Kondisi</th>
                    {{-- <th>Status</th> --}}
                    <th>Harga</th>
                    {{-- <th>Keterangan</th> --}}
                </tr>
            </thead>
            @php
                $no = 1;
                // $barangs = DB::table('detail_penempatans')
                //     ->select('*')
                //     ->join(
                //         'penempatans',
                //         'penempatans.no_penempatan',
                //         '=',
                //         'detail_penempatans.no_penempatan',
                //     )
                //     ->join(
                //         'detail_barangs',
                //         'detail_barangs.kode_barcode',
                //         '=',
                //         'detail_penempatans.kode_barcode',
                //     )
                //     ->where('no_ruangan', $asset->no_ruangan)
                //     // ->groupBy('no_ruangan')
                //     ->get();
            @endphp
            @foreach ($assets as $asset)
                @php
                    $nama_barang = DB::table('barangs')
                        ->select('*')
                        ->where('no_barang', '=', $asset->no_barang)
                        ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>No Barang: <b>{{ $asset->no_barang }}</b> <br>Barcode:
                        <b>{!! DNS1D::getBarcodeHTML($asset->kode_barcode, 'UPCA') !!}{{ $asset->kode_barcode }}</b> <br>No Asset:
                        <b>{{ $asset->no_asset }}</b>
                    </td>
                    <td>{{ $nama_barang->nama_barang }}</td>
                    <td>{{ $asset->merk }}, {{ $asset->spesifikasi }}</td>
                    {{-- <td>{{ $asset->tanggal_pengadaan }}</td> --}}
                    <td>{{ $asset->kondisi }}</td>
                    {{-- <td class="@if ($asset->status == 'Belum Ditempatkan')bg-warning @else bg-success @endif text-white">{{ $asset->status }}</td> --}}
                    <td>Rp. {{ number_format($asset->harga) }}</td>
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>{{ $asset->keterangan }}</td> --}}

                </tr>
            @endforeach
        </table>

    </div>

@endsection
