@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Ruangan</th>
                    <th>Ruangan</th>
                    <th>Lokasi</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($ruangans as $ruangan)
                @php
                    $tipe_ruangan = DB::table('tipe_ruangans')
                        ->select('nama_tipe')
                        ->where('id', '=', $ruangan->tipe_ruangan)
                        ->get();
                    $image_ruangan = DB::table('image_ruangans')
                        ->select('image')
                        ->where('no_ruangan', '=', $ruangan->no_ruangan)
                        ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $ruangan->no_ruangan }}</td>
                    <td>{{ $ruangan->ruangan }}</td>
                    <td>{{ $ruangan->lokasi }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $ruangan->no_ruangan }}"
                            style="margin-right: 10px" class="btn btn-primary mr-2"><i class="fa fa-eye"></i></button>
                        <a href="/print/aktiva?no_ruangan={{ $ruangan->no_ruangan }}" target="blank"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>


                        {{-- <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $ruangan->id }}"
                                class="btn btn-danger mt-1">
                                <i class="fa fa-trash"></i>
                            </button> --}}

                    </td>
                </tr>
            @endforeach
        </table>

    </div>


    {{-- modal --}}

    @php
        $assets = DB::table('detail_penempatans')
            ->select('*')
            ->join('penempatans', 'penempatans.no_penempatan', '=', 'detail_penempatans.no_penempatan')
            // ->groupBy('no_ruangan')
            ->get();
    @endphp
    {{-- modal view data --}}
    @foreach ($assets as $asset)
        <div class="modal modal-blur fade" id="showdata{{ $asset->no_ruangan }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <table class="table table-striped" id="data-tables-keranjang">
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
                                $barangs = DB::table('detail_penempatans')
                                    ->select('*')
                                    ->join(
                                        'penempatans',
                                        'penempatans.no_penempatan',
                                        '=',
                                        'detail_penempatans.no_penempatan',
                                    )
                                    ->join(
                                        'detail_barangs',
                                        'detail_barangs.kode_barcode',
                                        '=',
                                        'detail_penempatans.kode_barcode',
                                    )
                                    ->where('no_ruangan', $asset->no_ruangan)
                                    // ->groupBy('no_ruangan')
                                    ->get();
                            @endphp
                            @foreach ($barangs as $barang)
                                @php
                                    $nama_barang = DB::table('barangs')
                                        ->select('*')
                                        ->where('no_barang', '=', $barang->no_barang)
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td>No Barang: <b>{{ $barang->no_barang }}</b> <br>Barcode:
                                        <b>{!! DNS1D::getBarcodeHTML($barang->kode_barcode, 'UPCA') !!}{{ $barang->kode_barcode }}</b> <br>No Asset:
                                        <b>{{ $barang->no_asset }}</b>
                                    </td>
                                    <td>{{ $nama_barang->nama_barang }}</td>
                                    <td>{{ $barang->merk }}, {{ $barang->spesifikasi }}</td>
                                    {{-- <td>{{ $barang->tanggal_pengadaan }}</td> --}}
                                    <td>{{ $barang->kondisi }}</td>
                                    {{-- <td class="@if ($barang->status == 'Belum Ditempatkan')bg-warning @else bg-success @endif text-white">{{ $barang->status }}</td> --}}
                                    <td>Rp. {{ number_format($barang->harga) }}</td>
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>{{ $barang->keterangan }}</td> --}}

                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal view data --}}

    {{-- end modal --}}
@endsection
