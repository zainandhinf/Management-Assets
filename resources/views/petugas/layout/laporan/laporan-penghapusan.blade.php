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
                <form action="/print-data-penghapusan-pdf" method="GET" target="_blank" id="printForm">
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
                    <th>No Penghapusan</th>
                    <th>Tanggal Penghapusan</th>
                    <th>Jenis Penghapusan</th>
                    <th>Keterangan</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($penghapusans as $penghapusan)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $penghapusan->no_penghapusan }}</td>
                    <td>{{ $penghapusan->tanggal_penghapusan }}</td>
                    <td>{{ $penghapusan->jenis_penghapusan }}</td>
                    <td>{{ $penghapusan->keterangan }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $penghapusan->id }}"
                            class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </button>
                        <a href="/print-data-penghapusan-pdf?no_penghapusan={{ $penghapusan->no_penghapusan }}" target="_blank"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#confirm{{ $penghapusan->id }}"
                            class="btn btn-success mt-1">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        </button> --}}
                    </td>
                </tr>
            @endforeach
        </table>


    </div>

    {{-- modal --}}

    {{-- modal view data --}}
    @foreach ($penghapusans as $penghapusan)
        @php
            // $detail_barangs = DB::table('detail_barangs')
            //     ->join('penempatans', 'detail_barangs.kode_barcode', '=', 'penempatans.kode_barcode')
            //     ->select('penempatans.tanggal_penempatan', 'detail_barangs.*')
            //     ->where('detail_barangs.barcode', '=', $penghapusan->barcode)
            //     ->get();

            // dd($penghapusan);
            $detail_penghapusans = DB::table('detail_penghapusans')
                ->join('penghapusans', 'detail_penghapusans.no_penghapusan', '=', 'penghapusans.no_penghapusan')
                ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_penghapusans.kode_barcode')
                ->select(
                    'penghapusans.tanggal_penghapusan',
                    'penghapusans.jenis_penghapusan',
                    'penghapusans.keterangan as keterangan_penghapusan',
                    'detail_barangs.*',
                )
                ->where('detail_penghapusans.no_penghapusan', '=', $penghapusan->no_penghapusan)
                ->get();

        @endphp
        <div class="modal modal-blur fade" id="showdata{{ $penghapusan->id }}" tabindex="-1" role="dialog"
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
                                    <th>Tanggal Penghapusan</th>
                                    {{-- <th>Jenis Pengadaan</th> --}}
                                    <th>Jenis Penghapusan</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Keterangan</th>
                                    {{-- <th>Keterangan</th> --}}
                                    <th data-searchable="false">Action</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($detail_penghapusans as $detail_penghapusan)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td>No Barang: <b>{{ $detail_penghapusan->no_barang }}</b> <br>Barcode:
                                        <b>{!! DNS1D::getBarcodeHTML($detail_penghapusan->kode_barcode, 'UPCA') !!}{{ $detail_penghapusan->kode_barcode }}</b> <br>No
                                        Asset: <b>{{ $detail_penghapusan->no_asset }}</b>
                                    </td>
                                    <td>{{ $detail_penghapusan->merk }}, {{ $detail_penghapusan->spesifikasi }}</td>
                                    <td>{{ $detail_penghapusan->tanggal_penghapusan }}</td>
                                    {{-- <td>{{ $detail_penghapusan->jenis_pengadaan }}</td> --}}
                                    <td>{{ $detail_penghapusan->jenis_penghapusan }}</td>
                                    <td>{{ $detail_penghapusan->keterangan_penghapusan }}</td>
                                    {{-- <td>Rp. {{ number_format($detail_penghapusan->harga) }}</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>{{ $detail_penghapusan->keterangan }}</td> --}}
                                    <td>
                                        {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $detail_barang->id }}"
                                        style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button> --}}
                                        {{-- <a href="/print-data-penghapusan-pdf?no_penghapusan={{ $detail_penghapusan->no_peminjaman }}&kode_barcode={{ $detail_penghapusan->kode_barcode }}" target="_blank"
                                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a> --}}
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