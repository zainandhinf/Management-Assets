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
                    <th>No Pengadaan</th>
                    <th>Tanggal Pengadaan</th>
                    <th>Tanggal Data Dibuat</th>
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
                    <td>{{ $pengadaan->created_at }}</td>
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

    {{-- modal filter --}}
    <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" style="font-size: 14px;">
                    <label class="mb-1" for="">Filter Berdasarkan Tanggal Dibuat Data Pengadaan :</label>
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
                let href = '/laporan-data-pengadaan/f=hah';


                if (startDate && endDate) {
                    href = `/laporan-data-pengadaan/f=?date=${startDate}_${endDate}`;
                } else if (startDate) {
                    href = `/laporan-data-pengadaan/f=?date=${startDate}`;
                } else if (endDate) {
                    href = `/laporan-data-pengadaan/f=?date=${endDate}]`;
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
