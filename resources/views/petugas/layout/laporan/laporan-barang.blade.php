@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-warning btn-sm mt-2 mb-2 w-100" data-bs-toggle="modal"
                    data-bs-target="#filter">
                    <i class="fa fa-slider"></i>
                    Filter
                </button>
            </div>
            {{-- <div class="col-md-8">
            <a href="/print-petugas" target="blank" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                <i class="fa-solid fa-print"></i>
                Print
            </a>
        </div> --}}
            <div class="col-md-8">
                <!-- Form untuk mengirimkan data saat print -->
                <form action="/print-data-barang-pdf" method="GET" target="_blank" id="printForm">
                    @if ($requests == null)
                    @else
                        <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                        <input type="hidden" name="role" id="requestsInput" value="{{ $requests->query('role') }}">
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                        <i class="fa-solid fa-print"></i>
                        Print
                    </button>
                </form>
            </div>
        </div>

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

                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $barang->id }}"
                            style="margin-right: 10px" class="btn btn-primary mr-2"><i class="fa fa-eye"></i></button>
                        <a href="/print-data-barang-pdf?no_barang={{ $barang->no_barang }}" target="blank" style="margin-right: 10px"
                            class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>



                    </td>
                </tr>
            @endforeach
        </table>

        {{-- modal --}}

        {{-- modal view data --}}
        @foreach ($barangs as $barang)
            <div class="modal modal-blur fade" id="showdata{{ $barang->id }}" tabindex="-1" role="dialog"
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
                                    $barangs = DB::table('detail_barangs')
                                        ->select('*')
                                        ->join(
                                            'pengadaans',
                                            'pengadaans.no_pengadaan',
                                            '=',
                                            'detail_barangs.no_pengadaan',
                                        )
                                        ->where('detail_barangs.no_barang', $barang->no_barang)
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
    </div>
@endsection
