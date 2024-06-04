@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <table class="table table-striped" id="data-tables" style="font-size: 14px;">
            <thead>
                <tr>
                    <th>#</th>
                    {{-- <th>Kode Aktiva</th> --}}
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Qty</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($barangs as $barang)
                @php
                    $qty = DB::table('detail_barangs')
                        ->where('no_barang', '=', $barang->no_barang)
                        ->count();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>{{ $barang->kode_aktiva }}</td> --}}
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->nama_kategori }}</td>
                    <td>{{ $qty }}</td>
                    <td>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#detailbarang{{ $barang->id }}"
                            style="margin-right: 10px" class="btn btn-primary mr-2"><i class="fa fa-list"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $barang->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $barang->id }}"
                            class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button> --}}

                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $barang->no_barang }}"
                            style="margin-right: 10px" class="btn btn-primary mr-2"><i class="fa fa-eye"></i></button>
                        <a href="/print/assets?no_barang={{ $barang->no_barang }}" target="blank"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>




                    </td>
                </tr>
            @endforeach
        </table>

    </div>


    {{-- modal --}}

    {{-- @php
        $assets = DB::table('detail_penempatans')
            ->select('*')
            ->join('penempatans', 'penempatans.no_penempatan', '=', 'detail_penempatans.no_penempatan')
            // ->groupBy('no_ruangan')
            ->get();
    @endphp --}}
    {{-- modal view data --}}
    @foreach ($barangs as $barang)
        <div class="modal modal-blur fade" id="showdata{{ $barang->no_barang }}" tabindex="-1" role="dialog"
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
                                $assets = DB::table('barangs')
                                    ->select('*')
                                    ->join(
                                        'detail_barangs',
                                        'detail_barangs.no_barang',
                                        '=',
                                        'barangs.no_barang',
                                    )
                                    ->where('detail_barangs.no_barang', $barang->no_barang)
                                    // ->groupBy('no_ruangan')
                                    ->get();
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
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal view data --}}

    {{-- end modal --}}
@endsection
