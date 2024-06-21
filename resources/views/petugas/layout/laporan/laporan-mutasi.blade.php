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
                <form action="/print-data-mutasi-pdf" method="GET" target="_blank" id="printForm">
                    @if ($requests == null)
                    @else
                        <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                        {{-- <input type="hidden" name="role" id="requestsInput" value="{{ $requests->query('role') }}"> --}}
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
                    <th>No Mutasi</th>
                    <th>Tanggal Mutasi</th>
                    <th>Lokasi Penempatan</th>
                    {{-- <th>Pengguna</th> --}}
                    <th>Keterangan</th>
                    <th>Tanggal Data Dibuat</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($mutasis as $mutasi)
                @php
                    $lokasi = DB::table('ruangans')
                        ->select('*')
                        ->where('no_ruangan', '=', $mutasi->no_ruangan)
                        ->first();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $mutasi->no_mutasi }}</td>
                    <td>{{ $mutasi->tanggal_mutasi }}</td>
                    <td>{{ $lokasi->ruangan }}</td>
                    {{-- @if ($pengguna == null)
                        <td>Tidak Ada Pengguna</td>
                    @else
                        <td>({{ $pengguna->nik }}) {{ $pengguna->nama_user }}</td>
                    @endif --}}
                    <td>{{ $mutasi->keterangan }}</td>
                    <td>{{ $mutasi->created_at }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $mutasi->id }}"
                            class="btn btn-primary mt-1">
                            <i class="fa fa-eye"></i>
                        </button>
                        <a href="/print-data-mutasi-pdf?no_mutasi={{ $mutasi->no_mutasi }}" target="_blank"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa-solid fa-print"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>


    </div>

    {{-- modal --}}

    {{-- modal view data --}}
    @foreach ($mutasis as $mutasi)
        @php
            // $detail_barangs = DB::table('detail_barangs')
            //     ->join('penempatans', 'detail_barangs.kode_barcode', '=', 'penempatans.kode_barcode')
            //     ->select('penempatans.tanggal_penempatan', 'detail_barangs.*')
            //     ->where('detail_barangs.barcode', '=', $mutasi->barcode)
            //     ->get();
            // dd($mutasi);
            $detail_barangs = DB::table('detail_mutasis')
                ->join('mutasis', 'detail_mutasis.no_mutasi', '=', 'mutasis.no_mutasi')
                ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_mutasis.kode_barcode')
                ->select(
                    'mutasis.tanggal_mutasi',
                    'mutasis.no_ruangan',
                    'mutasis.keterangan as keterangan_mutasi',
                    'detail_barangs.*',
                )
                ->where('detail_mutasis.no_mutasi', '=', $mutasi->no_mutasi)
                ->get();

        @endphp
        <div class="modal modal-blur fade" id="showdata{{ $mutasi->id }}" tabindex="-1" role="dialog" aria-hidden="true"
            style="font-size: 14px;">
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
                                    <th>Tanggal Mutasi</th>
                                    {{-- <th>Jenis Pengadaan</th> --}}
                                    <th>Lokasi Penempatan Baru</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Keterangan</th>
                                    {{-- <th>Keterangan</th> --}}
                                    {{-- <th data-searchable="false">Action</th> --}}
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($detail_barangs as $detail_mutasi)
                                @php
                                    $nama_ruangan = DB::table('ruangans')
                                        ->select('ruangan')
                                        ->where('no_ruangan', '=', $detail_mutasi->no_ruangan)
                                        ->first();
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td>No Barang: <b>{{ $detail_mutasi->no_barang }}</b> <br>Barcode:
                                        <b>{!! DNS1D::getBarcodeHTML($detail_mutasi->kode_barcode, 'UPCA') !!}{{ $detail_mutasi->kode_barcode }}</b> <br>No
                                        Asset: <b>{{ $detail_mutasi->no_asset }}</b>
                                    </td>
                                    <td>{{ $detail_mutasi->merk }}, {{ $detail_mutasi->spesifikasi }}</td>
                                    <td>{{ $detail_mutasi->tanggal_mutasi }}</td>
                                    {{-- <td>{{ $detail_mutasi->jenis_pengadaan }}</td> --}}
                                    <td>{{ $nama_ruangan->ruangan }}</td>
                                    <td>{{ $detail_mutasi->keterangan_mutasi }}</td>
                                    {{-- <td>Rp. {{ number_format($detail_mutasi->harga) }}</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>{{ $detail_mutasi->keterangan }}</td> --}}
                                    {{-- <td>
                                        <a href="/print/barcode?barcode={{ $detail_mutasi->kode_barcode }}" target="blank"
                                            class="btn btn-warning mt-1"><i class="fa-solid fa-barcode"></i></a>
                                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $detail_mutasi->id }}"
                                            class="btn btn-danger mt-1">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal view data --}}

    {{-- modal filter --}}
    <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" style="font-size: 14px;">
                    <label class="mb-1" for="">Filter Berdasarkan Tanggal Dibuat Data Mutasi :</label>
                    <div class="form-group d-flex flex-direction-column">
                        <input type="date" class="form-control form-control-sm" id="startDate">
                        <span class="p-2"> - </span>
                        <input type="date" class="form-control form-control-sm" id="endDate">
                    </div>
                    <div class="mt-1">
                        <a href="" id="filterBtn" type="button" class="btn btn-primary btn-sm">Filter</a>
                    </div>
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- end modal filter --}}

    {{-- end modal --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        // const tipeInput = document.getElementById('tipe');
        const filterBtn = document.getElementById('filterBtn');

        // console.log(tipeInput);

        function updateFilterHref() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            // const tipe = tipeInput.value;
            let href = '/laporan-data-mutasi/f=hah';


            if (startDate && endDate) {
                href = `/laporan-data-mutasi/f=?date=${startDate}_${endDate}`;
            } else if (startDate) {
                href = `/laporan-data-mutasi/f=?date=${startDate}`;
            } else if (endDate) {
                href = `/laporan-data-mutasi/f=?date=${endDate}]`;
                // href = `/laporan-data-petugas/f=_${endDate}]`;
            }

            // if (tipe && startDate == null && endDate == null) {
            //     // href += (href.includes('?') ? '&' : (href ? '' : '')) + `${tipe}`;
            //     href += (href.includes('?') ? '&' : '') + `${tipe}`;
            // }else if (tipe){
            //     href += (href.includes('?') ? '&' : (href ? '?tipe=' : '')) + `${tipe}`;
            // }

            // console.log(href);

            filterBtn.href = href;


        }

        startDateInput.addEventListener('change', updateFilterHref);
        endDateInput.addEventListener('change', updateFilterHref);
        // tipeInput.addEventListener('change', updateFilterHref);
    });
</script>
@endsection
