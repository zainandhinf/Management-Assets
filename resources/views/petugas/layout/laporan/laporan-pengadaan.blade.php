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
                <form action="/print-data-pengadaan-pdf" method="GET" target="_blank" id="printForm">
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

        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Pengadaan</th>
                    <th>Tanggal Pengadaan</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($pengadaans as $pengadaan)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pengadaan->no_pengadaan }}</td>
                    <td>{{ $pengadaan->tanggal_pengadaan }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $pengadaan->id }}"
                            class="btn btn-primary mt-1">
                            <i class="fa fa-eye"></i>
                        </button>
                        <a href="/print-data-pengadaan-pdf?no_pengadaan={{ $pengadaan->no_pengadaan }}" target="_blank"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>
                        {{-- <a href="/print/barcode-all?no_pengadaan={{ $pengadaan->no_pengadaan }}" target="blank" class="btn btn-warning mt-1"><i
                                class="fa-solid fa-barcode"></i></a> --}}
                        {{-- <button data-bs-toggle="modal" data-bs-target="#deletePengadaan{{ $pengadaan->id }}"
                            class="btn btn-danger mt-1">
                            <i class="fa fa-trash"></i>
                        </button> --}}
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

    {{-- modal --}}

    {{-- modal view data --}}
    @foreach ($pengadaans as $pengadaan)
        @php
            $detail_barangs = DB::table('detail_barangs')
                ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
                ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
                ->where('detail_barangs.no_pengadaan', '=', $pengadaan->no_pengadaan)
                ->get();
        @endphp
        <div class="modal modal-blur fade" id="showdata{{ $pengadaan->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <table class="table table-striped" id="data-tables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Foto Profil</th> --}}
                                    <th>Kode</th>
                                    {{-- <th>Alamat</th> --}}
                                    {{-- <th>No Telepon</th> --}}
                                    <th>Merk</th>
                                    <th>Tanggal Pengadaan</th>
                                    {{-- <th>Jenis Pengadaan</th> --}}
                                    <th>Kondisi</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Harga</th>
                                    {{-- <th>Keterangan</th> --}}
                                    <th data-searchable="false">Action</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($detail_barangs as $detail_barang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td>No Barang: <b>{{ $detail_barang->no_barang }}</b> <br>Barcode:
                                        <b>{!! DNS1D::getBarcodeHTML($detail_barang->kode_barcode, 'UPCA') !!}{{ $detail_barang->kode_barcode }}</b> <br>No
                                        Asset: <b>{{ $detail_barang->no_asset }}</b>
                                    </td>
                                    <td>{{ $detail_barang->merk }}, {{ $detail_barang->spesifikasi }}</td>
                                    <td>{{ $detail_barang->tanggal_pengadaan }}</td>
                                    {{-- <td>{{ $detail_barang->jenis_pengadaan }}</td> --}}
                                    <td>{{ $detail_barang->kondisi }}</td>
                                    {{-- <td>{{ $detail_barang->status }}</td> --}}
                                    <td>Rp. {{ number_format($detail_barang->harga) }}</td>
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>{{ $detail_barang->keterangan }}</td> --}}
                                    <td>
                                        {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $detail_barang->id }}"
                                        style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button> --}}
                                        <a href="/print/barcode?barcode={{ $detail_barang->kode_barcode }}" target="blank"
                                            class="btn btn-warning mt-1"><i class="fa-solid fa-barcode"></i></a>
                                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $detail_barang->id }}"
                                            class="btn btn-danger mt-1">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
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

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });
    </script>
@endsection