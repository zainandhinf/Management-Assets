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
                <form action="/print-data-maintenance-pdf" method="GET" target="_blank" id="printForm">
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
                    {{-- <th>No. Maintenance</th> --}}
                    <th>Kode</th>
                    {{-- <th>Alamat</th> --}}
                    {{-- <th>No Telepon</th> --}}
                    <th>Merk</th>
                    <th>Tanggal Maintenance</th>
                    {{-- <th>Jenis Pengadaan</th> --}}
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Petugas/Koordinator</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($maintenances as $maintenance)
                @php
                // dd($maintenance);
                    $petugas = DB::table('users')
                        ->select('*')
                        ->where('id', '=', $maintenance->user_id)
                        ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $maintenance->no_maintenance }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>No.Maintenance: <b>{{ $maintenance->no_maintenance }}</b><br> No. Barang:
                        <b>{{ $maintenance->no_barang }}</b> <br>Barcode:
                        <b>{!! DNS1D::getBarcodeHTML($maintenance->kode_barcode, 'UPCA') !!}{{ $maintenance->kode_barcode }}</b> <br>No
                        Asset: <b>{{ $maintenance->no_asset }}</b>
                    </td>
                    <td>{{ $maintenance->merk }}, {{ $maintenance->spesifikasi }}</td>
                    <td>{{ $maintenance->tanggal_maintenance }}</td>
                    <td>{{ $maintenance->biaya }}</td>
                    <td>{{ $maintenance->status_maintenance }}</td>
                    <td>{{ $maintenance->keterangan_maintenance }}</td>
                    <td>({{ $petugas->nik }}){{ $petugas->nama_user }}</td>
                    {{-- <td>Rp. {{ number_format($maintenance->harga) }}</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>{{ $maintenance->keterangan }}</td> --}}
                    <td>
                        <a href="/print-data-maintenance-pdf?no_maintenance={{ $maintenance->no_maintenance }}"
                            target="_blank" style="margin-right: 10px" class="btn btn-warning mr-2"><i
                                class="fa-solid fa-print"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- modal --}}

    {{-- end modal --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });
    </script>
@endsection
